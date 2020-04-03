<?php
function check_login()
{
if(strlen($_SESSION['id'])==0)
	{	
		$host = $_SERVER['HTTP_HOST'];
		$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$extra="index.php";		
		$_SESSION["id"]="";
		header("Location: http://$host$uri/$extra");
	}
}



$ret="select * from booking where student_id=?";
$stmt= $mysqli->prepare($ret) ;
$stmt->bind_param('i',$id);
$stmt->execute() ;//ok
$userRec=$stmt->fetch();

if($userRec){
	$_SESSION['booked'] = true;
}else{
	$_SESSION['booked'] = false;
}

?>

