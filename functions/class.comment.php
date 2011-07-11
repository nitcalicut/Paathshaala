<?php
/**
* Comments class for insertion/deletion from CouchDB
* @author Vipin Nair <swvist@gmail.com>
* @author Jaseem Abid <jaseemabid@gmail.com>
* @copyright Copyright (c) 2011, Vipin Nair & Jaseem Abid
* @license http://www.gnu.org/licenses/gpl.html GNU General Public License 
* @package content
*/

/**
* Includes files for CouchDB connectivity.
*/

include_once 'functions.php';

/**
* Comment class for updating CouchDb.
*/
class comment
{
	private $url, $context, $database;
	function __construct()
	{
		global $global_couch_host, $global_couch_port, $global_couch_dbname,  $global_couch_user, $global_couch_password;
		$this->url = "http://".$global_couch_user.":".$global_couch_password."@".$global_couch_host.":".$global_couch_port."/";
		$this->database = $global_couch_dbname;
		$this->context = array('http' => array());
		$this->context['http']['timeout'] = 5;
		$this->context['http']['ignore_errors'] = true;
		$this->context['http']['user_agent'] = 'Paathshaala/1.0';
	}
	
	/**
	* Returns a unique ID for a new comment.
	* @return string Unique ID of the new comment.
	*/
	private function getUniqueId()
	{
		$context['http']['method'] = 'GET';
		$url=$this->url."_uuids";
		$context = stream_context_create($context);
		$commentId=json_decode(file_get_contents($url, false, $context));
		return $commentId->{'uuids'}[0];
	}
	
	/**
	* Function to post comment data to CouchDB. Comment data should be a array.
	* @param array $data Comment Data
	* @return string JSON string with results(success/fail) of the database update.
	*/
	public function post(array $data)
	{
		$data['_id']=$this->getUniqueId();
		$this->context['http']['method'] = 'PUT';
		$this->context['http']['header'] = 'Content-Type: application/json';
		$this->context['http']['content'] = json_encode($data);
		$context = stream_context_create($this->context);
		return file_get_contents($this->url."/".$this->database."/".$data['_id']."/", false, $context);
	}
	
	/**
	* Delete a comment from the database, based on its comment ID and its revision ID.
	* TODO: Verify the Comment UID with Session UID to avoid injection vulnerability.
	* @param string $id Comment ID of the Comment Document.
	* @return string $rev Revision ID of the comment Document.
	*/
	public function delete($id,$rev)
	{
		$this->context['http']['method'] = 'DELETE';
		$context = stream_context_create($this->context);
		return file_get_contents($this->url."/".$this->database."/".$id."?rev=$rev", false, $context);
	}
	
	/**
	* Report a comment as a spam.
	* @param string $comid Comment ID
	* @param string $revid Revision ID of the comment
	* @param integer $uid User ID of person who reported spam.
	* @return integer Spam return ID
	*/
	public static function report($comid, $revid, $uid)
	{
		$sql = "Insert into comment_spam(sp_comid,sp_revid,sp_uid) values('$comid','$revid','$uid') returning sp_id";
		$row=pg_fetch_row(dbquery($sql));
		return $row[0];
		
	}

}
?>
