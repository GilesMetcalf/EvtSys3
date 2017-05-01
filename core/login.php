<?
require_once('structure.php');

//Login page
$pID = 2;
create_header($pID);

if(!isset($_REQUEST['submit']))
{
	require("core_content/login.txt");
}
else
{
	global $msg_login_fail;
	global $msg_login_error;
	
	$userName = $_REQUEST['username'];
	$password = $_REQUEST['password'];
	if(($userId = is_valid($userName,$password,$con)) != 0)
	{
		$sessionId = session_id();
		//log_OK_access($userName);
		if(set_session($userId,$sessionId,$con))
		{
			header("Location: ../fluid/home.php");
		}
		else
		{
 			//log_fail_access($userName, mysql_error());
			echo $msg_login_error;			
		}
	}
	else
	{
 			//log_fail_access($userName, mysql_error());
			echo $msg_login_fail;			
	}
}
echo '</td></tr></table>';
create_footer();
?>

