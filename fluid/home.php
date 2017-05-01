<?
require_once("../core/structure.php");

//Home page
$pID = 1;
create_header($pID);

$pContent = "fluid_content/home.txt";
$pContentGuest = "fluid_content/guesthome.txt";

if($userId = is_logged())
{
	if (get_user_status($userId) > 1)
		{require($pContent);}
	else
		{require($pContentGuest);}
}
else
{
	global $msg_not_logged_in;
	echo $msg_not_logged_in;
}

create_footer();
?>

