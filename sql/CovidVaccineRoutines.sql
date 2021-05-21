use covidVaccination;

# Procedure to match patients
DELIMITER $$

create procedure matchpatients()
BEGIN
    DECLARE counter INT DEFAULT 1;


    REPEAT
        Drop temporary table if exists assignments;
        Drop temporary table if exists alldist;
        Drop temporary table if exists sortPref;
        Drop temporary table if exists matched;

        CREATE TEMPORARY table alldist

        with filtereddistance as(
            with alldistance as(
            select pat_id,pa.lat as pa_lat, pa.lon as pa_lon, prov_id, pr.lat as pr_lat, pr.lon as pr_lon
            FROM Provider as pr, patient as pa
             )
        SELECT pat_id, prov_id, dist_btwn_pat_prov(pa_lon, pa_lat, pr_lon, pr_lat) as dist
        FROM alldistance
            )
        Select patient.pat_id, prov_id, dist
        From filtereddistance natural join patient
         where dist <= patient.maxDistance;

        Create TEMPORARY table  sortPref
        Select p.pat_id, count(cid) as prefcount, priority
        From  patient p left join PatientPreference pp on p.pat_id = pp.pat_id
        WHERE p.pat_id not in
              (SELECT pat_id
                  From  AppointmentAvailable
                  WHERE status ='Accepted' or status ='Complete' or  status= 'Pending')
        GROUP BY priority,p.pat_id
        order by priority asc, prefcount asc
        ;

        create TEMPORARY table assignments
        with availtoassign as (
            select aid,prov_id,cid, status, apptdate
            FROM AppointmentAvailable join Calendar
            where appttime < endtime and
                  appttime >= starttime and
                  weekday(apptdate) = day and status = 'Available'
        )
        SELECT S.pat_id, prov_id, ata.cid, aid, priority, prefcount,apptdate
        FROM PatientPreference pp join availtoassign ata on ata.cid = pp.cid
            join sortPref S on S.pat_id = Pp.pat_id;

        create temporary table matched
        SELECT assignments.pat_id, assignments.prov_id, cid, aid, assignments.priority, prefcount,dist,apptdate, date_eligible
        FROM assignments join alldist a on assignments.pat_id = a.pat_id and assignments.prov_id = a.prov_id
            join prioritygroup pg on pg.priority = assignments.priority
        where apptdate >= date_eligible
        order by priority asc, prefcount asc, apptdate asc;


        UPDATE AppointmentAvailable, (SELECT aid, pat_id FROM  matched LIMIT 1) as t1
        SET status = 'Pending',
        AppointmentAvailable.pat_id = t1.pat_id,
        offerdate = MAKEDATE(YEAR(NOW()), DAYOFYEAR(NOW())),
        deadline = MAKEDATE(YEAR(NOW()), DAYOFYEAR(NOW())) + INTERVAL 7 DAY
        where AppointmentAvailable.aid = t1.aid;



        SET counter = counter + 1;
    UNTIL counter >= 10
    END REPEAT;
END$$
DELIMITER ;

# Procedure to set patient priority

DELIMITER $$
create procedure setpatientpriority()
Begin
        UPDATE Patient
        SET priority = IF(FirstResponder = 1,1, priority),
            priority = IF(EssentialWorker =1 and FirstResponder = 0,2, priority),
            priority = IF(EssentialWorker =0 and FirstResponder = 0 and preexisting_conditions =1,3, priority),
            priority = IF(year(DOB)<= YEAR(current_date)-65 and priority is null,4,priority),
            priority = IF(year(DOB)<= YEAR(current_date)-55 and priority is null,5,priority),
            priority = IF(year(DOB)<= YEAR(current_date)-45 and priority is null,6,priority),
            priority = IF( priority is null,7,priority);
    END $$
DELIMITER ;

# function to return distance between patient and provider
DELIMITER $$

create function dist_btwn_pat_prov(lonA float, latA float, lonB float, latB float) returns float deterministic
Begin
    return ST_DISTANCE_SPHERE(point(lonA, latA), point(lonB,latB)) * .000621371192;
end $$
DELIMITER ;



create definer = root@localhost event declineAppointment on schedule
    every '10' SECOND
        starts '2021-05-18 00:00:01'
    enable
    do
    BEGIN
    UPDATE AppointmentAvailable
    SET status = 'Declined'
    WHERE (MAKEDATE(YEAR(NOW()), DAYOFYEAR(NOW())) > AppointmentAvailable.deadline);

    UPDATE AppointmentAvailable
    SET status = 'Declined'
    WHERE (MAKEDATE(YEAR(NOW()), DAYOFYEAR(NOW())) > AppointmentAvailable.apptdate and replydate is null);
    end;

create definer = root@localhost event runMatched on schedule
    every '10' SECOND
        starts '2021-05-18 08:00:00'
    enable
    comment 'Matches patients to available appointments'
    do
    CALL matchpatients();

