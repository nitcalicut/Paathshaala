<?php
	/**
	* Processes user login and redirects back to page.
	*/
	
	include_once '../functions/class.activity.php';
	if(activity::login($_POST['uname'],$_POST['pass'])){
		$login="success";
	}
	else{
		$login="fail";
	}
	if($_POST['parameter']!=""){
		header("Location: ".$_POST['page']."?".$_POST['parameter']."&login=$login");
	}
	else{
		header("Location: ".$_POST['page']."?"."login=$login");
	}
	

?>
