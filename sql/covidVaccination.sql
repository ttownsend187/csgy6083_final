create table if not exists covidVaccination.Calendar
(
    cid       int auto_increment
        primary key,
    day       int  not null,
    starttime time not null,
    endtime   time not null
);

create table if not exists covidVaccination.PatientToken
(
    email varchar(256) not null,
    token varchar(256) not null
);

create table if not exists covidVaccination.PriorityGroup
(
    priority      int auto_increment
        primary key,
    date_eligible date not null
);

create table if not exists covidVaccination.Provider
(
    prov_id      int auto_increment
        primary key,
    name         varchar(255) not null,
    email        varchar(150) not null,
    stnum        varchar(10)  not null,
    stname       varchar(50)  not null,
    zip          char(5)      not null,
    city         varchar(50)  not null,
    state        varchar(50)  not null,
    areacode     char(3)      not null,
    phone        char(7)      not null,
    lon          float        null,
    lat          float        null,
    password     varchar(80)  not null,
    providerType varchar(255) null
);

create table if not exists covidVaccination.AppointmentAvailable
(
    aid       int auto_increment
        primary key,
    prov_id   int         not null,
    apptdate  date        not null,
    appttime  time        not null,
    status    varchar(25) not null,
    pat_id    int         null,
    offerdate date        null,
    replydate date        null,
    deadline  date        null,
    constraint AppointmentAvailable_Provider_prov_id_fk
        foreign key (prov_id) references covidVaccination.Provider (prov_id)
            on update cascade on delete cascade
);

create table if not exists covidVaccination.ProviderToken
(
    email varchar(256) not null,
    token varchar(256) not null
);

create table if not exists covidVaccination.emailQueue
(
    eid       int auto_increment
        primary key,
    pat_id    int          not null,
    email     varchar(256) not null,
    firstname varchar(256) not null,
    lastname  varchar(256) not null,
    prov_id   int          not null,
    prov_name varchar(256) not null,
    appttime  time         not null,
    apptdate  date         not null,
    executed  char         not null
);

create table if not exists covidVaccination.patient
(
    pat_id                 int auto_increment
        primary key,
    firstname              varchar(255) not null,
    lastname               varchar(130) not null,
    email                  varchar(255) not null,
    SSN                    char(9)      not null,
    DOB                    datetime     not null,
    stnum                  varchar(50)  not null,
    stname                 varchar(50)  not null,
    zip                    char(5)      null,
    city                   varchar(50)  not null,
    state                  varchar(50)  not null,
    areacode               char(3)      not null,
    phone                  char(7)      not null,
    lon                    float        null,
    lat                    float        null,
    preexisting_conditions tinyint(1)   null,
    FirstResponder         tinyint(1)   null,
    EssentialWorker        tinyint(1)   null,
    password               varchar(80)  not null,
    priority               int          null,
    maxDistance            int          not null
);

create table if not exists covidVaccination.PatientPreference
(
    pat_id int not null,
    cid    int not null,
    primary key (pat_id, cid),
    constraint Preferecne_patient_pat_id_fk
        foreign key (pat_id) references covidVaccination.patient (pat_id)
            on update cascade on delete cascade,
    constraint Preference_Calendar_cid_fk
        foreign key (cid) references covidVaccination.Calendar (cid)
            on update cascade on delete cascade
);

