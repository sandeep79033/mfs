<?php 

$dbhost = "localhost"; 
$dbuser = "id15785357_root"; 
$dbpass = "1kDWN2sVMNHEmM$/"; 
$conn = mysqli_connect($dbhost, $dbuser, $dbpass); 
	if(!$conn ) { 
		die('Could not connect: ' . mysqli_error($conn )); 
	} 
mysqli_select_db($conn,'id15785357_medicalinfo');

?>
