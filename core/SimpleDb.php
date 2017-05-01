<?php

class Database 
{
	//Singleton database instance
	//Loads connection and login variables from config file
	require_once("config.php");

	private static $instance; 

	class combinedResult
	{
		var resultSet;
		var rowCount;
	}

	private function __construct()
	{	
		//Hidden constructor - makes initial connection to the database
	    $con = mysql_connect($db_server, $db_user, $db_pass) or die (mysql_error());
		mysql_select_db($db_name,$con) or die(mysql_error());
	}

	public static function getInstance()
	{	
		//Public constructor method - creates a new instance if one does not exist
	    if(!self::$instance)
	    {
	        self::$instance = new Database();
	    }
	    return self::$instance;     
	}

	public function query($sql) 
	{
	    //Executes queries  - input value  
	    $result = mysql_query($sql) or die(mysql_error()); 
	    return $result;
	}

	public function numrows($sql) 
	{
	    //Returns the rowcount for a query  
	    $count = $this->query($sql) or die(mysql_error());
	    return mysql_num_rows($count);
	}

	public function numrows($sql) 
	{
	    //Returns the rowcount for a query  
	    $count = $this->query($sql) or die(mysql_error());
	    return mysql_num_rows($count);
	}

	public function combinedQuery($sql)
	{	
		//Executes a SQL statement, and returns complex object with result set and rowcount
		//in one operation. Only executes one database query.
		$result = mysql_query($sql) or die(mysql_error());
		$count = mysql_num_rows($result);
		$objOut = new combinedResult;
		$objOut->resultSet = $result;
		$objOut->rowCount = $count;
		return $objOut;
	}
}

?>