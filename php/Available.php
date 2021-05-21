<?php
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
	<div id = "alert_placeholder"></div>
<div class="container">
    <div class="row">
        <div class='col-lg-9'>
            <div class="form-group">
            <label for="dtpickerdemo" class="col-sm-2 control-label">New Date/Time:</label>
                <!-- <div class='col-sm-4 input-group date'> -->
                    <input type='text' class="form-control" id='newAvailability' />
                    
                <!-- </div> -->
            </div>
            <button class="btn btn-primary" type="submit" id="submit"> Add </button>
            
        </div>


        <script type="text/javascript">
            $(function () {
                $('#newAvailability').datetimepicker({ format: 'YYYY-MM-DD HH:mm', stepping: 60, disabledHours:[0, 1, 2, 3, 4, 5, 6, 7, 21, 22, 23]});
            });
			$('#submit').click(function(){  
				var newAvailability = $('#newAvailability').val();  

				if(newAvailability != '')  
				{  
				     $.ajax({  
				          url:"AddAvailable.php",  
				          method:"POST",  
				          data:{datetime:newAvailability},  
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


	    </div>
	    <br>
	    <table class="table table-striped" id="table">
		  <thead>
		    <tr>
		      <th class="th-sm">Date</th>
		      <th class="th-sm">Start Time</th>
		      <th class="th-sm">Status</th>
		      <th scope="col">Action</th>
		    </tr>
		  </thead>
		  <tbody>

		  <?php
			    include 'connectMySqlDB.php';

			    $statement = $conn->prepare("SELECT aid, apptdate, appttime, status FROM AppointmentAvailable WHERE prov_id = :prov_id;");

			    $statement->bindParam(':prov_id', $prov_id);
			    $prov_id = $_SESSION['prov_id'];

			    $statement -> execute();
			    $data = $statement->fetchAll();
			    $count = 1;

			    for($i = 0; $i < count($data); $i++) {
			    	echo "
			    	<tr>
				      <td>".$data[$i]['apptdate']."</td>
				      <td>".$data[$i]['appttime']."</td>
				      <td>".$data[$i]['status']."</td>
				      <td>
                            <a class='delete' title='Delete' data-toggle='tooltip' data-id =".$data[$i]['aid']."><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-dash-circle-fill' viewBox='0 0 16 16'><path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1h-7z'/></svg></a>
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
		bootstrap_alert = function() {}
		bootstrap_alert.warning = function(message) {
		            $('#alert_placeholder').html('<div class="alert alert-warning"><a class="close" data-dismiss="alert">×</a><span>'+message+'</span></div>')
		        }
		bootstrap_alert.success = function(message) {
		            $('#alert_placeholder').html('<div class="alert alert-success"><a class="close" data-dismiss="alert">×</a><span>'+message+'</span></div>')
		        }


		$(function (){
			$(document).on("click", ".delete", function(){
			var aid = $(this).attr('data-id');
			console.log(aid);
	        var item = $(this).parents("tr");
			$.ajax({  
				          url:"deleteAvailable.php",  
				          method:"POST",  
				          data: {aid : aid},  
				          success:function(data)

				          {
				          	data = JSON.parse(data);
				          	console.log(data.stat);
				          	if (data.stat == 'Success') {
				          		item.remove();
				               bootstrap_alert.success("Delete the appointment successfully!");
				          	} else {
				          		// alert("Can't delete unavailable appointments!");
				          		bootstrap_alert.warning("Can't delete unavailable appointments!");
						    }
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
