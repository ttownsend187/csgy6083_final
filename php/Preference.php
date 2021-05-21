<?php
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
include('base.php');
if(session_status() !== PHP_SESSION_ACTIVE) session_start();



?>

<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
<link href="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.24/css/dataTables.jqueryui.min.css" rel="stylesheet">


<script type="text/javascript" src="//code.jquery.com/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
<script src="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>


<body>
<div class="container">
    <h5 class="display-5">Add More Prefer Time Slots</h5>
    <div class="row">
        <div class='col-lg-9'>
            <div class="form-group">
		      <label for="day" class="col-sm-2 control-label">Day</label>
		      <select id="day" class="form-control">
		        <option selected>Monday</option>
		        <option>Tuesday</option>
		        <option>Wednesday</option>
		        <option>Thursday</option>
		        <option>Friday</option>
		        <option>Saturday</option>
		        <option>Sunday</option>
		      </select>
            <label for="dtpickerdemo" class="col-sm-2 control-label">Start Time:</label>
                <!-- <div class='col-sm-4 input-group date'> -->
                    <input type='text' class="form-control" id='starttime' />
            <!-- <label for="dtpickerdemo" class="col-sm-2 control-label">End Time:</label> -->
                <!-- <div class='col-sm-4 input-group date'> -->
<!--                     <input type='text' class="form-control" id='endtime' /> -->
                    
                <!-- </div> -->
            </div>
            <button class="btn btn-primary" type="submit" id="submit"> Add </button>
            
        </div>


        <script type="text/javascript">

            $(function () {
                $('#starttime').datetimepicker({ format: 'HH:mm', stepping: 60, disabledHours:[0, 1, 2, 3, 4, 5, 6, 7, 9, 10, 11, 13, 14, 15, 17, 18, 19, 20, 21, 22, 23]});
            });
            // $(function () {
            //     $('#endtime').datetimepicker({ format: 'HH:mm', stepping: 60, disabledHours:[0, 1, 2, 3, 4, 5, 6, 7, 21, 22, 23]});
            // });
			$('#submit').click(function(){
				var endTimeMap = new Map();
	        	endTimeMap.set('08:00', '12:00');
	        	endTimeMap.set('12:00', '16:00');
	        	endTimeMap.set('16:00', '20:00');

				var day = $('#day').val();
				var starttime = $('#starttime').val();
				console.log(starttime);
				var endtime = endTimeMap.get(starttime);
				console.log(endtime);

				if(day != '' && starttime != '' && endtime != '')  
				{  
				     $.ajax({  
				          url:"AddPreference.php",  
				          method:"POST",  
				          data:{day: day, starttime:starttime, endtime:endtime},  
				          success:function(data)  
				          {  
				               location.reload();
				          }  
				     });  
				}  
				else  
				{  
				     alert("Please Select Date");  
				}  
		});
        </script>
    <br>
<!--         <div class="row"> -->

	        
<!--         </div> -->

	    </div>
    <h5 class="display-5">Your Time Slots</h5>
	    <table class="table table-striped" id="table">
		  <thead>
		    <tr>
		      <th scope="col">Day</th>
		      <th scope="col">Start Time</th>
		      <th scope="col">End Time</th>
		      <th scope="col">Action</th>
		    </tr>
		  </thead>
		  <tbody>

		  <?php
			    include 'connectMySqlDB.php';

			    $statement = $conn->prepare("SELECT cid, day, starttime, endtime FROM Calendar WHERE cid in (SELECT cid FROM PatientPreference WHERE pat_id = :pat_id)");

			    $statement->bindParam(':pat_id', $pat_id);
			    $pat_id = $_SESSION['pat_id'];

			    $statement -> execute();
			    $data = $statement->fetchAll();
			    $count = 1;

              $day_map = array();

              $day_map[0] = "Monday";
              $day_map[1] = "Tuesday";
              $day_map[2] = "Wednesday";
              $day_map[3] = "Thursday";
              $day_map[4] = "Friday";
              $day_map[5] = "Saturday";
              $day_map[6] = "Sunday";
			    for($i = 0; $i < count($data); $i++) {
			    	echo "
			    	<tr>
				      
				      <td>".$day_map[$data[$i]['day']]."</td>
				      <td>".$data[$i]['starttime']."</td>
				      <td>".$data[$i]['endtime']."</td>
				      <td>
                            <a class='delete' title='Delete' data-toggle='tooltip' data-id =".$data[$i]['cid']."><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-dash-circle-fill' viewBox='0 0 16 16'><path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1h-7z'/></svg></a>
                        </td>
				    </tr>
			    	";
			    }		  
		?>
		</tbody>
	</table>
	<script type="text/javascript">
			$(document).ready(function() {
			    $('#table').DataTable({searching: false});
			});
		</script>
	</div>
	<script type="text/javascript">
		$(function (){
			$(document).on("click", ".delete", function(){
			var cid = $(this).attr('data-id');
			console.log(cid);
	        $(this).parents("tr").remove();
			$.ajax({  
				          url:"deletePreference.php",  
				          method:"POST",  
				          data: {cid : cid},  
				          success:function(data)  
				          {  
				               console.log('success');
				          }  
				     }); 
			
		});
    });
	</script>


</body>
<footer class="position-relative z-index-10 d-print-none" >
  <!-- Copyright section of the footer-->
  <div class="py-4 font-weight-light bg-gray-800 text-gray-300">
      <div class="container text-md-center text-center">
          <p class="text-sm mb-md-0">&copy; 2021, Vaccination NYU</p>
      </div>
  </div>
</footer>
