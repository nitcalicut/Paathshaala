<?php
/**
* Activity Class for handling user activities on Paathsaala.
* @author Vipin Nair <swvist@gmail.com>
* @author Jaseem Abid <jaseemabid@gmail.com>
* @copyright Copyright (c) 2011, Vipin Nair & Jaseem Abid
* @license http://www.gnu.org/licenses/gpl.html GNU General Public License 
* @package content
*/

/**
* Includes files for database connectivity.
*/

include_once 'functions.php';
include_once 'class.user.php';

/**
* Class for handling user activities.
* @package activity
*/
class activity
{
	/**
	* Static function to save content likes and dislikes in the database.
	* TODO: Resource intensive, needs to be optimized.
	* @param integer $cid Content ID of the liked/disliked content.
	* @param integer $uid User ID who liked/disliked content.
	* @param integer $like User Preference (1:Like | -1:Dislike)
	* @return integer Like ID identifying the User, Content and Preference (like/dislike)
	*/
	public static function like($cid,$uid,$like)
	{
		activity::removelike($cid,$uid);
		$sql="Insert into content_like(cl_cid,cl_uid,cl_value) values('".$cid."','".$uid."','".$like."') returning cl_id";
		$likeid=pg_fetch_result(dbquery($sql),0,0);
		if($likeid)
		{
			if($like==1)
				$sql="Update content set cn_likes=cn_likes+1 where cn_id=$cid";
			else if($like==-1)
				$sql="Update content set cn_dislikes=cn_dislikes+1 where cn_id=$cid";
			dbquery($sql);
		}
		return $likeid;
	}
	
	/**
	* Static function to remove like/dislike of content by a user. 
	* @param integer $cid Content ID of the liked/disliked content.
	* @param integer $uid User ID who liked/disliked the content.
	* @return integer on success:1 on fail: 0
	*/
	public static function removelike($cid,$uid)
	{
		$sql="Delete from content_like where cl_cid=$cid and cl_uid=$uid returning cl_value";
		$like=pg_fetch_result(dbquery($sql),0,0);
		if($like)
		{
			if($like==1)
				$sql="Update content set cn_likes=cn_likes-1 where cn_id=$cid";
			if($like==-1)
				$sql="Update content set cn_dislikes=cn_dislikes-1 where cn_id=$cid";
			dbquery($sql);
			return 1;
		}
		return 0;
	}
	
	/**
	* Stores feedback in the database. Anonymous users will have a special user ID.
	* Name/Email of the Anonymous user should be appended to the description.
	* @param string $ip IP address of the user.
	* @param string $uid User ID, Anonymous user will have special user ID. NOT fixed yet.
	* @param string $type Type of Feedback (I: idea, X:problem, P: praise, Q: question)
	* @param string $desc Feedback message
	* @return integer Feedback ID
	*/
	public static function feedback($ip,$uid,$type,$desc)
	{
		$ip=pg_escape_string($ip);
		$uid=pg_escape_string($uid);
		$type=pg_escape_string($type);
		$desc=pg_escape_string($desc);
		$sql="Insert into feedback(fb_ip,fb_uid,fb_type,fb_desc) values('$ip','$uid','$type','$desc') returning fb_id";	
		return pg_fetch_result(dbquery($sql),0,0);
	}
	
	/**
	* Stores user comments. 
	* TODO: Crude implementation, needs to be fixed.
	* @param integer $cid Content ID
	* @param integer $uid User ID of the commentor
	* @param string $comment The comment string.
	* @return integer Comment ID of the comment.
	*/
	public static function comment($cid,$uid,$comment)
	{
		$uid=pg_escape_string($uid);
		$cid=pg_escape_string($cid);
		$comment=pg_escape_string($comment);
		$sql="Insert into comments(cm_cid,cm_uid,cm_msg) values('".$cid."','".$uid."','".$comment."') returning cm_id";
		return pg_fetch_result(dbquery($sql),0,0);
	}
	
	/**
	* Login function
	* @param string $uname Username
	* @param string $upass User Password
	* @return 
	*/
	public static function login($uname,$upass)
	{
		global $global_salt;
		$uname=pg_escape_string($uname);
		$upass=sha1($upass.$global_salt);
		$sql="Select us_id, us_name, us_fullname, us_status from users where us_name='$uname' and us_pass='$upass'";
		$res=dbquery($sql);
		if($res)
		{
			$user=resource2array($res);
			session_start();
			$_SESSION['uid']=$user[0];
			$_SESSION['username']=$user[1];
			$_SESSION['fullname']=$user[2];
			$_SESSION['status']=$user[3];
			$_SESSION['userpic']=user::getUserPictureS($user[0]);
			return 1;
		}
		return 0;
	}
	
	/**
	* Destroys the session of a user and logs the user out.
	*/
	public static function logout()
	{
		session_destroy();
		$_SESSION=array();
	}
}
