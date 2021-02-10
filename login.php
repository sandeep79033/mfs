<?php
//error_reporting(0);
ob_start();
include_once('index.php');
function loginUser($mobile,$pswrd) /* Register User Fun. */
{
	global $conn;
	$chk_user = "SELECT * FROM example_tbl WHERE mobile='$mobile' AND pswrd='$pswrd'";
	$chk_exe = mysqli_query($conn,$chk_user);
	
	if($chk_exe)
	{
		return $chk_exe;
	}
	else
	{
		return false;
	}
}
function registerUser($name,$mobile,$email,$pswrd) /* Register User Fun. */
{
	global $conn;
	$response = array();
	$chk_user = "SELECT email,mobile FROM example_tbl WHERE mobile='$mobile' OR email='$email'";
	$chk_exe = mysqli_query($conn,$chk_user);
	if($chk_exe)
	{
		if(mysqli_num_rows($chk_exe)>0)
		{
			$response['response'] = "failed";
			$response['user'] = "already member";
		}
		else
		{
			$qr1="insert into example_tbl(name,mobile,email,pswrd) VALUES ('$name','$mobile','$email','$pswrd')";
			$qr2=mysqli_query($conn,$qr1);
			$qr3=mysqli_affected_rows($conn);
			if($qr3)
			{
			
				$response['response'] = "success";
				$response['user'] = "user created";
			}
			else
			{
				$response['response'] = "error";
				$response['user'] = "user not created";
			}
		}
	}
	else
	{
		$response['response'] = "error";
		$response['user'] = "user not created";
	}
	$rjdata = json_encode($response);
	return $rjdata;
}
function adminupdate($Location,$Hospital_Name,$Hospital_Category ,$Hospital_Care_Type,$Discipline_Systems_of_Medicine,$State,$District,$Pincode,
				$Telephone,$Mobile_Number,$Hospital_Primary_Email_Id,$Website,$Specialties,$mobile,$pswrd){
				    global $conn;
	$response = array();

			$qr1="UPDATE `example_tbl` SET `Location`='$Location',`Hospital_Name`='$Hospital_Name',`Hospital_Category`='$Hospital_Category',
						`Hospital_Care_Type`='$Hospital_Care_Type',`Discipline_Systems_of_Medicine`='$Discipline_Systems_of_Medicine',`State`='$State',
						`District`='$District',
						`Pincode`='$Pincode',`Telephone`='$Telephone',`Mobile_Number`='$Mobile_Number',`Hospital_Primary_Email_Id`='$Hospital_Primary_Email_Id',
						`Website`='$Website',`Specialties`='$Specialties' WHERE `mobile`='$mobile'
						and `pswrd`='$pswrd' ";
			$qr2=mysqli_query($conn,$qr1);
			$qr3=mysqli_affected_rows($conn);
			if($qr3)
			{
			
				$response['response'] = "success";
				$response['user'] = "Record Updated";
			}
			else
			{
				$response['response'] = "error";
				$response['user'] = "Record not Updated";
			}
    $rjdata = json_encode($response);
	return $rjdata;


					
}
$baseData = file_get_contents("php://input");
$jdata = json_decode($baseData);
$action = $jdata->baction;
if($action=="register_user")  /* Register User */
{
	$name = $jdata->name;
	$mobile = $jdata->mobile;
	$email = $jdata->email;
	$pswrd = $jdata->pswrd;
	$jrdata = registerUser($name,$mobile,$email,$pswrd);
	echo $jrdata;
}
else if($action=="admin") /* Admin User */
{
	$Location = $jdata->Location;
	$Hospital_Name = $jdata->Hospital_Name;
	$Hospital_Category = $jdata->Hospital_Category;
	$Hospital_Care_Type = $jdata->Hospital_Care_Type;
	$Discipline_Systems_of_Medicine = $jdata->Discipline_Systems_of_Medicine;
	$State = $jdata->State;
	$District = $jdata->District;
	$Pincode = $jdata->Pincode;
	$Telephone = $jdata->Telephone;
	$Mobile_Number = $jdata->Mobile_Number;
	$Hospital_Primary_Email_Id = $jdata->Hospital_Primary_Email_Id;
	$Website = $jdata->Website;
	$Specialties = $jdata->Specialties;
	$mobile = $jdata->mobile;
	$pswrd = $jdata->pswrd;
	$jrdata = adminupdate($Location,$Hospital_Name,$Hospital_Category ,$Hospital_Care_Type,$Discipline_Systems_of_Medicine,$State,$District,$Pincode,
				$Telephone,$Mobile_Number,$Hospital_Primary_Email_Id,$Website,$Specialties,$mobile,$pswrd);
	echo $jrdata;
	
}
else if($action=="login_user") /* Logn User */
{
	$response = array();
	$mobile = $jdata->mobile;
	$pswrd = $jdata->pswrd;
	$lgn_res = loginUser($mobile,$pswrd);
	if($lgn_res)
	{
		if(mysqli_num_rows($lgn_res)>0)
		{
			$response['response'] = "success";
			while($row = mysqli_fetch_assoc($lgn_res))
			{
				$response['data'][] = $row;
			}
		}
		else
		{
			$response['response'] = "failed";
		}
	}
	else
	{
		$response['response'] = "error";
	}
	$jrdata = json_encode($response);
	echo $jrdata;
}

?>
