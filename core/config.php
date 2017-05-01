<?

/* MySQL Database */
$db_server = "localhost"; 			/* MySQL server name or IP address */
$db_name = "Evt3";				/* MySQL Schema name */
$db_user = "evtSystem";				/* MySQL user name */
$db_pass = "evtuser";				/* MySQL user password */

/* Site parameters */
$site_name = "Unoff Weekend 3";					/* Primary title of the website */
$site_url  = "http://starlight/Unoff2/";		/* URL of the home page */
$member_service_email = "membership@site.com";	/* 'From' address for automated emails from site */
$title_tag  = "The Unoff Weekend 3";			/* Text for <title> tag root on each page

/* Registration parameters */
$validate_by_email = 0;		/* 1 if a confirmation email is sent before a user can log on */
$send_welcome_email = 1;	/* 1 if an email is sent when a user registers */


/* Session management parameters */
$session_save = 'system';	/* 'system' or 'database' for session management */

/** ################################################################################## **/
/* Do not modify anything below this line! */

$con = mysql_connect($db_server, $db_user, $db_pass);
mysql_select_db($db_name,$con);
				
?>
