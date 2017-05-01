<?
/* =================================================================== */
/* 
 * Log in functions
*/
/* =================================================================== */

/**
 * Returns 0 if the user is not logged in, or returns their userid if they are.
 * Updates the 'lastAccess' field in the logged users table.
 */
function is_logged($sid="")
{
	global $con;
	if(!isset($sid) || $sid == '')
	{
		$sid = session_id();
	}

	clean_sessions();
	$query = "SELECT userId from loggedusers where sessionId = '$sid' and
			  unix_timestamp(date_add(lastAccess, interval 1 hour)) > unix_timestamp(now())";
			  
	$result = mysql_query($query);	
	if($result)
	{
		$row = mysql_fetch_row($result);
		if($row)
		{	
			$query = "UPDATE loggedusers set lastAccess=now() where userId = $row[0]";
			mysql_query($query);
		}		
		return $row[0];
	}
	else
	{
		return 0;
	}
}

/**
 * returns true if the username and password, and password confirm fields
 * are set.
 */
function is_valid_username()
{
	$pass = sanitize_variable($_REQUEST['password']);
	$pass1 = sanitize_variable($_REQUEST['password1']);
	$user = sanitize_variable($_REQUEST['username']);
	return (isset($pass) && $pass != '' &&
			isset($pass1) && $pass1 != '' &&
			isset($user) && $user != '');
}

/**
 * returns true if the email address is aldready in use
 */
function is_used_email()
{
	$email = sanitize_variable($_REQUEST['email']);

	$query = "SELECT userId FROM userprofile WHERE userEmail = '$email'";			  
	$result = mysql_query($query);
	error_log(mysql_error());
	//error_log($query,1,"giles@lughnasadh.com");
	if($result && mysql_num_rows($result) ==1)
	{		
		return 1;
	}
	else
	{
		return 0;
	}
}


/**
 * this method changes the user status. The acceptable values are
 * 0 - account disabled
 * 1 - guest account
 * 2 - registered account
 * 3 - administrator account
 */
function set_user_status($userId, $status)
{
	$query = "UPDATE users set userstatus = $status WHERE userId = $userId";
	return mysql_query($query);
}
 

/**
 * hotmail, msn, bigfoot and other free addresses are not allowed.
 */
function is_valid_addr()
{
	$disallow = "/hotmail\.com|msn\.com|yahoo\.com|bigoot\.com|lycos\.com/";
	$email = sanitize_variable($_REQUEST['email']);
	if($email == '' )
	{
		return 0;
	}
	else
	{
		return 1;
	}
}


/**
 * returns userId on success. 0 on failure.
 */
function is_valid($user,$password)
{
	global $con;
	$query = "SELECT userId FROM users WHERE
			  userName = '$user' and userPassword = md5('$password') and userStatus > 0";			  
	$result = mysql_query($query);
	//error_log(mysql_error());
	//error_log($query,1,"giles@lughnasadh.com");
	if($result && mysql_num_rows($result) ==1)
	{		
		$row = mysql_fetch_row($result);
		return $row[0];
	}
	return 0;
}

/**
 * changes the password for the given user
 */
	
function change_password($userId,$password)
{
	global $con;
	$password = addslashes($password);
	$query = "UPDATE users set userPassword= md5('$password') WHERE userId=$userId";
	$result = mysql_query($query);
	return mysql_errno();
}

/**
 * Log out the current user
 */
function log_out()
{
	global $con;
	$sid = session_id();
	$query = "DELETE from loggedusers where sessionId = '$sid'";
	mysql_query($query);
	echo mysql_error();
}


/* =================================================================== */
/* 
 * Session Management functions
*/
/* =================================================================== */

/**
 * The heart of the session manager.
 *
 * If you are load balancing your web site across several servers you cannot
 * store session information in files. You will either need to store the 
 * information in a database or use cookies. Since many people are reluctant
 * to trust cookies your choices narrow down to exactly one. YOu need to use
 * database.
 *
 * Storing session information in a database makes sense if you are on a 
 * shared hosting enviorenment and have concerns about security.
 *
 * To enable this feature set the variable $session_in_db to 'db';
 */
function on_session_write($key, $val) {
	error_log("$key = $val");
	$val = addslashes($val);
	$insert_stmt  = "insert into sessions values('$key', ";
	$insert_stmt .= "'$val',unix_timestamp(date_add(now(), interval 1 hour)))";
	$update_stmt  = "update sessions set session_data ='$val', ";
	$update_stmt .= "session_expiration = unix_timestamp(date_add(now(), interval 1 hour))";
	$update_stmt .= "where session_id ='$key '";	
	// First we try to insert, if that doesn't succeed, it means
	// session is already in the table and we try to update
	mysql_query($insert_stmt);	
	$err = mysql_error();	
	if ($err != 0)
	{
		error_log(mysql_error());
		mysql_query($update_stmt);
	}
}


/**
 * Creates an entry in the logged users table. Call this method 
 * directly if you want to automatically log in a new user who 
 * has just signed up.
 */
 
function set_session($userId,$sessionId, $con)
{
	$query = "insert into loggedusers set userId = $userId,
			  sessionId = '$sessionId', loginTime = now(), 
			  lastAccess = now()";			  
	$result = mysql_query($query,$con);	
	if(mysql_errno() != 0)
	{
		/*
		 * it could be that you are already logged in 
		 */
		 $u2 = is_logged($sessionId);		 
		 return ($u2 == $userId);
	}
	return 1;
}

/**
 * this should not be a function, it should be a cron. It has however
 * been made available so that you have a means of cleaning up unwanted
 * sessions, even if you do not have access to the cron daemon or other
 * scheduling mechanism.
 */
function clean_sessions()
{
	$query = "delete from loggedusers where 
				unix_timestamp(date_add(lastAccess, interval 1 hour)) < unix_timestamp(now())";
	$result = mysql_query($query);
}

function on_session_start($save_path, $session_name) {
	error_log($session_name . " ". session_id());
}


function on_session_read($key) {
	error_log($key);
	$stmt = "select session_data from sessions ";
	$stmt .= "where session_id ='$key' ";
	$stmt .= "and unix_timestamp(session_expiration) > unix_timestamp(date_add(now(),interval 1 hour))";
	$sth = mysql_query($stmt);
	if($sth)
	{
		$row = mysql_fetch_array($sth);
		return($row['session_data']);
	}
	else
	{
		return $sth;
	}
}

function on_session_destroy($key) {
	mysql_query("delete from sessions where session_id = '$key'");
}

function on_session_gc($max_lifetime) {
	mysql_query("delete from sessions where unix_timestamp(session_expiration) < unix_timestamp(now())");
}
	



?>