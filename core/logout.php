<?
require_once("structure.php");

//Logout page
$pID = 3;
create_header($pID);
	
if(is_logged())
{
	log_out();
	session_destroy();	
	global $msg_logged_out;
	echo $msg_logged_out;
}
create_footer();
?>

