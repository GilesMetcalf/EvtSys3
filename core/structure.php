<?
/* 
 * Start a session if one does not already exist
 */
if(!session_id())
 	{session_start();}

require_once("config.php");
require_once("core_msg.php");
require_once("log_functions.php");
require_once("utility_functions.php");

/* 
 *  Page Data class definition
 */
class pageData {
	var $id;
	var $Heading;
	var $menuTitle;
	var $mID;
	var $menuLevel;
	var $accessLevel;
	var $url;
}

/*
 * creates the header on each page
 */
function create_header($pID) {
	global $title_tag;			
	global $page;
	$page = get_page_data($pID);			
	require("core_content/header.txt");
}

/*
 * Creates the footer on each page
 */
function create_footer() {
	require("core_content/footer.txt");
}

/* 
 * Gets the page profile data for a given page
 */
function get_page_data($pageID) {
	global $con;
	$query = "SELECT * from sitecontent where pID = $pageID";	
	$result = mysql_query($query);
	if($result)
	{
		$row = mysql_fetch_array($result);
		$page = new pageData;
		$page->id = $row[0];
		$page->Heading = $row[1];
		$page->menuTitle = $row[2];
		$page->mID = $row[3];
		$page->menuLevel = $row[4];
		$page->accessLevel = $row[5];
		$page->url =  $row[6];	
		return $page;
	}
}

/* 
 * Builds the menu data for a given access level
 */
function make_menu($level) {
	$query = "SELECT * from sitecontent
			WHERE accessLevel = $level AND menuLevel > 0";
	$result = mysql_query($query);
	$count = @mysql_num_rows($result);
	if($count == 0)
	{
		echo '<em>No menu entries</em><br />';
	}
	else
	{
		for($i=0 ; $i < $count ; $i++)
		{
			$row = mysql_fetch_array($result);

			if ($row['menuLevel']==1)
			{
				$menuline=sprintf('<span class="lv1"><a href="%s" class="%s">%s</a></span><br />',$row[6],$row[3],$row[2]);
				echo $menuline;
			}
			else
			{
				$menuline=sprintf('<span class="lv2"><a href="%s" class="%s">%s</a></span><br />',$row[6],$row[3],$row[2]);
				echo $menuline;
			}
		}
	}
}




/*
 * Creates an interest box on the page
 */ 
function makeInterestBox($evt) {
	$query = "SELECT * from regtranslate where regValue='$evt'";
	$result = mysql_query($query);
	$count = mysql_num_rows($result);
	
	if($count == 0)
	{
		echo "<em>Event not configured!</em>\n";
	}
	else
	{
		$row = mysql_fetch_array($result);

		$evtName = $row[1]; // Name of event (Human readable)
		$evtState=$row[2]; // Event status (0=Bookable, 1=Full, 2=Cancelled)
		$minUserStatus = $row[3]; // Minimum user status that can update this IB
		$actionForm = $row[4]; // Name of action form (should be containing page)
		$unregisterable = $row[5];	// 0 if registration cannot be cancelled, 1 if it can
		$maxListLength=$row[6]; // Maximum number of lines displayed in IB
		$topLineText=$row[7]; // Text displayed at top of list
		$buttonText=$row[8]; // Text to diplay on button
		$cancelButtonText=$row[9]; // Text to display on Unregister button (if displayed)
		$eventFullText=$row[10]; // Text to display if the event is fully booked
		$eventCancelledText=$row[11]; // Text to display if the event is cancelled
		
		echo '<p class="interestbox">';
		if(($userId = is_logged()) && (get_user_status($userId) >= $minUserStatus))
		{
			// List of interested attendees 
			echo '<table  border="0" cellspacing="2">';
			echo '<tr><td colspan=4>';
			echo '<h3>'.$evtName.'</h3>';
			if($evtState==0)
			{
				echo '<p>'.$topLineText.':</p></td></tr><tr>';   		
				show_user_list2($evt,$maxListLength); 
				echo '</tr><tr><td colspan=4>';
				if (!is_booked($evt, $userId))
				{
					echo '<form action="'.$actionForm.'" method="post">';
					echo '<input name="thisAction" type="hidden" value="'.$evt.'" />';
					echo '<input name="submit" type="submit" value="'.$buttonText.'" />';
					echo '</form>';
				}
				else if($unregisterable == 1)
				{
					echo '<form action="'.$actionForm.'" method="post">';
					echo '<input name="thisAction" type="hidden" value="'.$evt.'" />';
					echo '<input name="unregister" type="submit" value="'.$cancelButtonText.'" />';
					echo '</form>';			
				}
			}
			else if($evtState==1)
			{
				echo '<p>'.$eventFullText.'</p></td></tr>';   		
			}
			else if($evtState==2)
			{
				echo '<p>'.$eventCancelledText.'</p></td></tr>';   		
			}
			echo '</td></tr></table>';			
		}
	}
}



?>