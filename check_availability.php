<?php
require_once("includes/config.php");



	$query = 'SELECT * FROM rooms';
	$stmt = $mysqli->prepare($query);
	$stmt->execute();
	$res = $stmt->get_result();

	while($row = $res->fetch_object()){


		// count the room number of each loop in the booking

		$bq = 'SELECT count(room_no) FROM booking WHERE room_no =?';
		$stmt = $mysqli->prepare($bq);
		$stmt->bind_param('i',$row->room_no);
		$stmt->execute();
		$r = mysqli_num_rows($stmt->get_result());

		// var_dump($row->room_no.' | '.$r);

		if($row->seater == $r){
			$uq = 'UPDATE rooms SET full = 1 WHERE room_no=?';
			$stmt = $mysqli->prepare($uq);
			$stmt->bind_param('i',$row->room_no);
			$stmt->execute();
		}
		// die();


	}















// if(!empty($_POST["emailid"])) {
// 	$email= $_POST["emailid"];
// 	if (filter_var($email, FILTER_VALIDATE_EMAIL)===false) {

// 		echo "error : You did not enter a valid email.";
// 	}
// 	else {
// 		$result ="SELECT count(*) FROM userRegistration WHERE email=?";
// 		$stmt = $mysqli->prepare($result);
// 		$stmt->bind_param('s',$email);
// 		$stmt->execute();
// $stmt->bind_result($count);
// $stmt->fetch();
// $stmt->close();
// if($count>0)
// {
// echo "<span style='color:red'> Email already exist .</span>";
// }
// else{
// 	echo "<span style='color:green'> Email available for registration .</span>";
// }
// }
// }

// if(!empty($_POST["oldpassword"])) 
// {
// $pass=$_POST["oldpassword"];
// $result ="SELECT password FROM userregistration WHERE password=?";
// $stmt = $mysqli->prepare($result);
// $stmt->bind_param('s',$pass);
// $stmt->execute();
// $stmt -> bind_result($result);
// $stmt -> fetch();
// $opass=$result;
// if($opass==$pass) 
// echo "<span style='color:green'> Password  matched .</span>";
// else echo "<span style='color:red'> Password Not matched</span>";
// }


// if(!empty($_POST["roomno"])) 
// {
// $roomno=$_POST["roomno"];
// $result ="SELECT count(*) FROM registration WHERE roomno=?";
// $stmt = $mysqli->prepare($result);
// $stmt->bind_param('i',$roomno);
// $stmt->execute();
// $stmt->bind_result($count);
// $stmt->fetch();
// $stmt->close();
// if($count>0)
// echo "<span style='color:red'>$count. Seats already full.</span>";
// else
// 	echo "<span style='color:red'>All Seats are Available</span>";
// }
?>