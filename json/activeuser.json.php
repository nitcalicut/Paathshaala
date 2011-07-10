<?php
	//JSON data of the active user. Contains, uid, username, fullname, status and userpic.
	include '../functions/functions.php';
	if(checkSession()){
		echo json_encode($_SESSION);
	}
	else{
		redirect();
	}
?>
