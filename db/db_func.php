<?php

$fname = $lname = $username = 
$email = $password = $date = 
$gender = $city = $country = "";

$lusername = $lpassword = "";

$log_err = 0;
$reg_err = 0;

function db_conn()
{
	$servername = "localhost";
	$db_username = "root";
	$db_password = "";
	$database = "Nasa";
	$conn = mysqli_connect($servername, $db_username, $db_password, $database);
	if (!$conn) {
    	die("Connection failed: " . mysqli_connect_error());
	}
	return $conn;
}

function db_close($conn)
{
	mysqli_close($conn);
}

function db_test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function db_submit($conn) {
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (isset($_POST['LUsername'])) {
			db_login($conn);
			return 1;
		}
		else {
			db_register($conn);
			return 2;
		}
	}
	else {
		return 0;
	}
}

function db_login($conn)
{
	global $lusername , $lpassword;
	global $log_err;
	$lusername = db_test_input($_POST["LUsername"]);
	$lpassword = db_test_input($_POST["LPassword"]);
	$lusername = $conn->real_escape_string($lusername);
	$lpassword = $conn->real_escape_string($lpassword);
	$quer = "SELECT * FROM `Users` WHERE `username` LIKE '$lusername'";
	$res = mysqli_query($conn, $quer);
    if (!$res || mysqli_num_rows($res) == 0) {
    	$log_err = 1;
    	return;
    }
    else {
    	$result = mysqli_fetch_array($res);
        if ($result['password'] != $lpassword) {
            $log_err = 2;
            return;
        }
        else {
        	$_SESSION['user'] = $lusername;
        	header("Location: success.php");
            exit;
        }
    }
}

function db_register($conn)
{
	global $fname, $lname, $username, 
			$email, $password, $date, 
			$gender, $city, $country;
	global $reg_err;
	$fname = db_test_input($_POST["FirstName"]);
	$lname = db_test_input($_POST["LastName"]);
	$username = db_test_input($_POST["Username"]);
	$email = db_test_input($_POST["Email"]);
	$password = db_test_input($_POST["Password"]);
	$fname = $conn->real_escape_string($fname);
	$lname = $conn->real_escape_string($lname);
	$username = $conn->real_escape_string($username);
	$email = $conn->real_escape_string($email);
	$password = $conn->real_escape_string($password);
	if (!db_check_reg($conn, "username", $username)) {
		$reg_err = 1;
		return;
	}
	if (!db_check_reg($conn, "email", $email)) {
		$reg_err = 2;
		return;
	}
	$quer = "INSERT INTO Users (fname, lname, email, username, password)VALUES ('$fname', '$lname', '$email', '$username', '$password')";
    if (mysqli_query($conn, $quer) === TRUE) {
        header("Location: success.php");
        exit;
    } 
}

function db_check_reg($conn, $field, $val) {
	$quer = "SELECT * FROM `Users` WHERE `$field` LIKE '$val'";
    $res = mysqli_query($conn, $quer);
    if (!$res || mysqli_num_rows($res) == 0) {
    	return true;
    }
    else {
    	return false;
    }
}



?>