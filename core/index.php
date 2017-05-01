<?
require_once('structure.php');

if(is_logged())
{
	header("Location: main.php\n");
}
else
{

	//Index page
	$pID = 5;
	create_header($pID);

	require('core_content/landing.txt');	

	create_footer();
}
?>

