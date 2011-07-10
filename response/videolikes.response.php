<?php
	/**
	* Accepts video likes from front end and stores in database.
	* TODO: Implement Sessions.
	*/
	include '../functions/class.activity.php';
	$cid=$_POST['cid'];
	$value=$_post['value'];
	$uid=$_SESSION['uid'];
	activity::like($cid,$uid,$value);
?>
