<?
/* =================================================================== */
/* 
 * User Information functions
*/
/* =================================================================== */

 /**
 * this function returns the currently logged in user's username
 */
function get_name()
{
	global $con;
	$sid = session_id();
	$query = "SELECT a.userFirstName FROM userprofile a, loggedusers b
			  WHERE b.sessionId = '$sid' and b.userId = a.userId";	
	$result = mysql_query($query);
	if($result)
	{
		$row = mysql_fetch_row($result);
		return $row[0];
	}
	else
	{
		return "";
	}			  
}

/**
 * Are you logged in as the administrator?
 * also updates the 'lastAccess' field in the logged users table.
 */
function is_admin($sid="")
{
	global $con;	
	if(!isset($sid) || $sid == '')
	{
		$sid = session_id();
	}
	clean_sessions();
	$query = "SELECT a.userId FROM loggedusers a, users b 
		      WHERE a.sessionId = '$sid' AND b.userStatus = 3 AND
			  a.userId = b.userId AND
			  unix_timestamp(date_add(lastAccess, interval 1 hour)) > unix_timestamp(now())";
	$result = mysql_query($query);
	if($result)
	{
		$row = mysql_fetch_row($result);
		if($row && $row[0]>1)
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
 * retrieves the uers's status. Currently supported values are
 * 0 - account disabled
 * 1 - guest account
 * 2 - registered account
 * 3 - administrator account
 */ 
function get_user_status($userId)
{
	$query = "SELECT userStatus from users where userId = $userId";
	$result = mysql_query($query);
	if($result)
	{
		$row = mysql_fetch_row($result);
		return $row[0];
	}
	return 0;
}

/**
 * retrieves the email address given the username, used mainly by the
 * password reminder service.
 */
function get_email($username, $userId=0)
{
	if($userId==0)
	{
		$query = "SELECT a.userEmail from userprofile a, users b
				where b.username='$username' and b.userId = a.userId";
	}
	else
	{
		$query = "SELECT userEmail from userprofile	where 
				 userId = $userId";	
	}
	error_log($query);	  
	$result = mysql_query($query);
	if(mysql_errno() == 0)
	{
		if($result)
		{
			$row=mysql_fetch_row($result);
			return $row[0];
		}
		else
		{
			return 0;			
		}
	}
	else
	{
		error_log(mysql_error());		
		return 0;
	}
}

/** 
 * displays a list of users for administration
 * WHERE clause value set to 9 to exclude intrinsic users
 */
function show_current_users($listlen)
{
	$query = "SELECT A.userId, A.userStatus, A.userName, 
			B.userFirstName, B.userLastName, B.userEmail 
			FROM users as A INNER JOIN userprofile as B 
			ON A.userId = B.userId
			WHERE A.userId>9
			ORDER BY B.userLastName";				
	$result = mysql_query($query);
	$count = @mysql_num_rows($result);
	$linecount = 0;
	if($count == 0)
	{
		echo '<em>No users yet</em><br />';
	}
	else
	{
		echo '<table width="65%"><tr bgcolor="#CCCCCC">';
		echo '<td><strong>UserID</strong></td>';
		echo '<td><strong>Login</strong></td>';
		echo '<td><strong>User Name</strong></td>';
		echo '<td><strong>User eMail</strong></td>';
		echo '<td><strong>User Status</strong></td>';
		echo '<td>&nbsp;</td></tr>';
		
		for($i=0 ; $i < $count ; $i++)
		{
			$row = mysql_fetch_array($result);
			printf('<tr valign="top" style="usrCell"><td>'.$row[0].'</td>');		//User ID
			printf('<td>'.$row[2].'</td>');		//User Login Name
			printf('<td>'.$row[3].' '.$row[4].'</td>');		//User Name
			printf('<td>'.$row[5].'</td>');		//User eMail

			switch($row[1])
			{
				case 0;
					echo '<td>Disabled</td>';
					break;
				case 1;
					echo '<td>Guest</td>';
					break;
				case 2;
					echo '<td>Registered</td>';
					break;
				case 3;
					echo '<td>Administrator</td>';
					break;
			}
	
			echo '<td><form method="post" action="changeuser.php">';
			printf('<input name="UID" type="hidden" value="'.$row[0].'">');
			echo '<input name="Profile" type="submit" id="Profile" value="P">';
			echo '<input name="Status" type="submit" id="Status" value="S">';
			echo '<input name="Register" type="submit" id="Register" value="R">';
			echo '<input name="Booked" type="submit" id="Booked" value="B">';
			echo '</form></td></tr>';

			$linecount++;
			if ($linecount==$listlen)
			{
				 //some work to do around paging here...
				// $linecount = 0;
			}
		}
	}
	echo '</table>';
}





?>