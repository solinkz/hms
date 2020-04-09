<?php
session_start();
include('includes/config.php');
	if(isset($_POST['submit'])){
			
		$seater = $_POST['seater'];
		$room_no = $_POST['room_no'];
		$type = 'female';
		$fees= '';


		switch ($seater) {
			case 2:	
				$fees = 6000;
				break;
			case 3:
				$fees = 8000;
				break;
			case 4:
				$fees = 10000;
				break;
			default:
				$fees = 6000;
				break;
		}

		$query = 'INSERT INTO rooms(seater,room_no,fees,type) VALUES(?,?,?,?)';
		$stmt = $mysqli->prepare($query);
		$stmt->bind_param('iiis',$seater,$room_no,$fees,$type);
		// var_dump($type);
		// die();
		$res = $stmt->execute();

		if($res){
			echo"<script>alert('Room created successfully');</script>";
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
	<title>Create room</title>
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">>
	<link rel="stylesheet" href="css/bootstrap-social.css">
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<link rel="stylesheet" href="css/fileinput.min.css">
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
	<link rel="stylesheet" href="css/style.css">
<script type="text/javascript" src="js/jquery-1.11.3-jquery.min.js"></script>
<script type="text/javascript" src="js/validation.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
<script type="text/javascript">
function valid()
{
if(document.registration.password.value!= document.registration.cpassword.value)
{
alert("Password and Re-Type Password Field do not match  !!");
document.registration.cpassword.focus();
return false;
}
return true;
}
</script>
</head>
<body>
	<?php include('includes/header.php');?>
	<div class="ts-main-content">
		<?php include('includes/sidebar.php');?>
		<div class="content-wrapper">
			<div class="container-fluid">

				<div class="row">
					<div class="col-md-12">
					
						<h2 class="page-title">Create room </h2>

						<div class="row">
							<div class="col-md-7">
								<div class="panel panel-primary">
									<div class="panel-heading"></div>
									<div class="panel-body">
										<form method="post" action="" name="registration" class="form-horizontal" >
											
											<div class="form-group">
												<label class="col-sm-2 control-label">seater : </label>
												<div class="col-sm-8">
													<input type="text" name="seater" id="seater"  class="form-control">
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-2 control-label">room no. : </label>
												<div class="col-sm-8">
													<input type="text" name="room_no" id="room_no"  class="form-control">
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-2 control-label">room no. : </label>
												<div class="col-sm-8">
													<select name="type" id="type" class="form-control">
														<option value="male">male</option>
														<option value="female">female</option>
													</select>
												</div>
											</div>
											<button type="submit" name="submit" class="btn btn-primary">Create room</button>




										</form>

									</div>
									</div>
								</div>
							</div>
						</div>
							</div>
						</div>
					</div>
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
	<script>
function checkAvailability() {

$("#loaderIcon").show();
jQuery.ajax({
url: "check_availability.php",
data:'emailid='+$("#email").val(),
type: "POST",
success:function(data){
$("#user-availability-status").html(data);
$("#loaderIcon").hide();
},
error:function ()
{
event.preventDefault();
alert('error');
}
});
}
</script>

</html>