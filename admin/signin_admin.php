<?php
include("class/users.php");
$admin_signin= new users;
extract($_POST);
if($admin_signin->signin($e,$p))
{
	$admin_signin->url("home_admin.php");
	
}

else
{
	$admin_signin->url("index.php?run=failed");
	
}


?>