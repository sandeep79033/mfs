<?php 
include_once('index.php');
$sql = 'SELECT * FROM example_tbl'; 
$retval = mysqli_query($conn,$sql); 
if(! $retval ) { 
	die('Could not get data: ' . mysqli_error($conn )); 
} 

$emparray = array();
while($row = mysqli_fetch_assoc($retval)) 
{ 
    $emparray['hosdetails'][] = $row;
	 
    
}

$result=json_encode($emparray);
echo $result;
return $result;

?>
