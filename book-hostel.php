<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
include('check_availability.php');
check_login();
//code for registration





if(isset($_POST['submit'])){
	$seat = $_POST['seat'];
		

	$id = $_SESSION['id'];
	$ret="select * from userregistration where id=?";
	$stmt= $mysqli->prepare($ret) ;
	$stmt->bind_param('i',$id);
	$stmt->execute() ;//ok
	$res=$stmt->get_result();
	$dept = '';
	while($row = $res->fetch_object()){
		$dept = $row->department;
	}
	

	// check if room is available
	$query = 'SELECT * FROM rooms WHERE seater =?';
	$stmt= $mysqli->prepare($query) ;
	$stmt->bind_param('i',$seat);
	$stmt->execute() ;//ok
	$res=$stmt->get_result();

	while($row = $res->fetch_object()){

		


		if($row->full == 0 && $row->department == $dept || $row->department == ''){
			
			$query = 'INSERT INTO booking(room_no, student_id) VALUES(?,?)';
			$stmt = $mysqli->prepare($query);
			$stmt->bind_param('ss',$row->room_no , $id);
			$stmt->execute();


			$uq = 'UPDATE rooms SET department = ? WHERE id = ?';
			$stmt = $mysqli->prepare($uq);
			$stmt->bind_param('ss', $dept , $row->id);
			$stmt->execute();


			header("location:room-details.php");
			break;

		}

	}


}



?>

<!doctype html>
<html lang="en" class="no-js">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="theme-color" content="#3e454c">
	<title>Student Hostel Registration</title>
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/fileinput.min.css">
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
	<link rel="stylesheet" href="css/style.css">
<script type="text/javascript" src="js/jquery-1.11.3-jquery.min.js"></script>
<script type="text/javascript" src="js/validation.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>


</head>
<body>
	<?php include('includes/header.php');?>
	<div class="ts-main-content">
		<?php include('includes/sidebar.php');?>
		<div class="content-wrapper">
			<div class="container-fluid">

				<div class="row" style="margin-top: 4rem;">
					<div class="col-md-12">
					
						<h2 class="page-title">Book hostel </h2>
					</div>
				</div>

				<div class="row">
					<?php

						$id=$_SESSION['id'];

						$ret="select * from booking where student_id=?";
						$stmt= $mysqli->prepare($ret) ;
						$stmt->bind_param('i',$id);
						$stmt->execute() ;//ok
						$res=$stmt->fetch();

						 

					 	if($res){
					 	?>
					 		
					 	<div class="bg-light">
					 		<h4>You have already booked a room</h4>
					 	</div>


					 	<?php

					 	}else{



						$ret="select * from userregistration where id=?";
						$stmt= $mysqli->prepare($ret) ;
						$stmt->bind_param('i',$id);
						$stmt->execute() ;//ok
						$res=$stmt->get_result();

						while($row = $res->fetch_object()){
							$dept = $row->department;
							
						}


					 	?>

					 	<div class="container">
					 		
						 	<div class="row">
						 		<div class="col-md-6">

							 		<form action="" method="post">
							 			<div class="form-group">
							 				<label> Room type</label>
							 				<select name="seat" class="form-control">
							 					<option value="2">2 rooms</option>
							 					<option value="3">3 rooms</option>
							 					<option value="4">4 rooms</option>
							 				</select>

							 			</div>
							 			<button class=" btn btn-primary" name="submit" type="submit" style="padding: 1rem 3rem">Book</button>
							 		</form>
						 			
						 		</div>
						 	</div>
					 	</div>

					 	<?php }
						 	// while($row = $res->fetch_object()){

					?>
				</div>	
			</div>
		</div>
	</div>

						



	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap-select.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.bootstrap.min.js"></script>
	<script src="js/Chart.min.js"></script>
	<script src="js/fileinput.js"></script>
	<script src="js/chartData.js"></script>
	<script src="js/main.js"></script>
</body>
<script type="text/javascript">
	$(document).ready(function(){
        $('input[type="checkbox"]').click(function(){
            if($(this).prop("checked") == true){
                $('#paddress').val( $('#address').val() );
                $('#pcity').val( $('#city').val() );
                $('#pstate').val( $('#state').val() );
                $('#ppincode').val( $('#pincode').val() );
            } 
            
        });
    });
</script>
	<script>
function checkAvailability() {
$("#loaderIcon").show();
jQuery.ajax({
url: "check_availability.php",
data:'roomno='+$("#room").val(),
type: "POST",
success:function(data){
$("#room-availability-status").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}
</script>


<script type="text/javascript">

$(document).ready(function() {
	$('#duration').keyup(function(){
		var fetch_dbid = $(this).val();
		$.ajax({
		type:'POST',
		url :"ins-amt.php?action=userid",
		data :{userinfo:fetch_dbid},
		success:function(data){
	    $('.result').val(data);
		}
		});
		

})});
</script>

</html>