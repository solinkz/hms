<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();



if(isset($_POST['done_payment'])){

	$query = 'UPDATE booking SET status ="paid" WHERE student_id=?';
	$stmt->prepare($query);
	$stmt->bind_param('i', $_SESSION['id']);
	$res=$stmt->execute();

	if($res){
		header("location:room-details.php");
	}else{
		echo '<script> alert("error");</script>';
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
	<title>Room Details</title>
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">

</head>



<style>
	
	.modal-footer{
		display: flex;
		justify-content: flex-end;
	}

	.modal-footer .btn{
		margin-right: 1rem;
	}
</style>




<body>
	<?php include('includes/header.php');?>

	<div class="ts-main-content">
			<?php include('includes/sidebar.php');?>
		<div class="content-wrapper">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-12">
						<h2 class="page-title">Rooms Details</h2>


						<div class="container">
							<div class="row">
								<div class="col-md-6">
									<?php

										$query = 'SELECT * FROM userregistration JOIN booking on booking.student_id = userregistration.id JOIN rooms on booking.room_no = rooms.room_no WHERE userregistration.id=? ';


										$stmt = $mysqli->prepare($query);
										$stmt->bind_param('i',$_SESSION['id']);
										$stmt->execute();
										$rt = $stmt->get_result();



										while($row = $rt->fetch_object()){

											// $rq = 'SELECT * FROM room WHERE room_no ='
										?>
											
											<table class="table table-striped table-bordered">
												<tr>
													<th>Name</th>
													<td><?php echo $row->firstName.' '.$row->lastName ?></td>
												</tr>
												<tr>
													<th>Reg No.</th>
													<td><?php echo $row->regNo ?></td>
												</tr>
												<tr>
													<th>Gender</th>
													<td><?php echo $row->gender ?></td>
												</tr>
												<tr>
													<th>Room number</th>
													<td><?php echo $row->room_no ?></td>
												</tr>
												<tr>
													<th>Accomodation fee</th>
													<td><?php echo $row->fees ?></td>
												</tr>
												<tr>
													<th>Status</th>
													<td><?php echo $row->status ?></td>
												</tr>
											
											</table>
											
											<?php

												if($row->status !== 'paid'){
											?>

												<a href="#" class="btn btn-primary" data-toggle="modal" data-target="#paymentModal">Make payment</a>
											<?php
												}

											?>

											<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
											  <div class="modal-dialog" role="document">
											    <div class="modal-content">
											      <div class="modal-header">
											        <h5 class="modal-title" id="exampleModalLabel">Payment for room <?=$row->room_no?></h5>
											        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
											          <span aria-hidden="true">&times;</span>
											        </button>
											      </div>
											      <div class="modal-body">

											      		<h1 class="h2" style="margin-bottom: 2rem;">Payment for room <?=$row->room_no?></h1>

											      		<p id="paydetail">
											      			<strong>Room fee:</strong>
											      			N<?=$row->fees?>
											      			<br>
											      			<strong>Duration:</strong>
											      			<span>1 session</span>
											      	
											      		</p>
											      		<p id="load" style="display: none">
											      			<span>Simulating payment</span><br>
											      			loading...
											      		</p>
											      		<p id="done" style="display: none">
											      			payment completed
											      		</p>

											        	
											      </div>
											      <div class="modal-footer">
											        <button type="button" class="btn btn-primary makePayment">
														<i class="fa fa-lock "></i>&nbsp;
											        	securely make payment
											    	</button> 
													

											    	<!-- hidden form -->

													<form action="" method="post" class="display: inline-block;">
														<input type="hidden" name="done_payment">

												    	<button type="submit" class="btn btn-success donePayment" style="display: none">
															<i class="fa fa-check "></i>&nbsp;
												        	Done
												    	</button>
													</form>



											        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
											      </div>
											    </div>
											  </div>
											</div>
										<?php
										}

									?>




								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


	<!-- Loading Scripts -->
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap-select.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/main.js"></script>
	

	<script >


		let paymentBtn = document.querySelector('.makePayment');
		let doneBtn = document.querySelector('.donePayment');

		paymentBtn.addEventListener('click', function(){

			document.querySelector('#paydetail').style.display = 'none';
			document.querySelector('#load').style.display = 'block';

			setTimeout(function(){

				document.querySelector('#load').style.display = 'none';
				document.querySelector('#done').style.display='block';

				paymentBtn.style.display='none';
				doneBtn.style.display='inline-block';


				
			},2000);

		});

		

	</script>

</body>

</html>
