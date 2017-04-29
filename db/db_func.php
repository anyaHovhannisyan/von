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
	$month = db_test_input($_POST["Month"]);
	$day = db_test_input($_POST["Day"]);
	$year = db_test_input($_POST["Year"]);
	$date = $year . "-" . $month . "-" . $day;
	$fname = $conn->real_escape_string($fname);
	$lname = $conn->real_escape_string($lname);
	$username = $conn->real_escape_string($username);
	$email = $conn->real_escape_string($email);
	$password = $conn->real_escape_string($password);
	$date = $conn->real_escape_string($date);
	if (!db_check_reg($conn, "username", $username)) {
		$reg_err = 1;
		return;
	}
	if (!db_check_reg($conn, "email", $email)) {
		$reg_err = 2;
		return;
	}
	$quer = "INSERT INTO Users (fname, lname, email, username, password, bday)VALUES ('$fname', '$lname', '$email', '$username', '$password', '$date')";
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

function db_search($conn) {
	if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['search'])) {
		$str = db_test_input($_GET['search']);
		$str = $conn->real_escape_string($str);
		?>
      	<h2 class="acroTitle"> Acronyms </h2> <hr>
		<?php
		db_search_acr($conn, $str);
		?>
		<hr>
		<br>
      	<h2 class="acroTitle"> Terms </h2> <hr>
		<?php
		db_search_term($conn, $str);
	}
}


function db_search_term($conn, $str) {
	$quer = "SELECT * FROM `Terms` WHERE `term` LIKE '$str%'";
	$res = mysqli_query($conn, $quer);
	if (!$res || mysqli_num_rows($res) == 0) {
		?>
		<p class = "acroWords">
		<?php echo "Nothing Found"; ?>
		</p>
		<?php
	}
	else {
		while ($result = mysqli_fetch_array($res)){
			?>
			<p class = "acroWords"> 
			<span class="acroMean">
				<a href = "entry.php?db=term&id=<?php echo $result['id']; ?>">
					<?php echo $result['term']; ?>
				</a> 
			</span>
			</p>
			<?php
		}
	}
}

function db_search_acr($conn, $str) {
	$quer = "SELECT * FROM `Acronyms` WHERE `acr` LIKE '$str%'";
	$res = mysqli_query($conn, $quer);
	if (!$res || mysqli_num_rows($res) == 0) {
		?>
		<p class = "acroWords">
		<?php echo "Nothing Found"; ?>
		</p>
		<?php
	}
	else {
		while ($result = mysqli_fetch_array($res)){
			?>
			<p class = "acroWords"> 
			<span class="acroMean">
				<a href = "entry.php?db=acr&id=<?php echo $result['id']; ?>">
					<?php echo $result['acr']; ?>
				</a> 
			</span>
			- 
			<?php echo $result['meaning']; echo "<br />"; ?> 
			</p>
			<?php
		}
	}
}

function db_show($conn) {
	if (isset($_GET['id']) && 
		isset($_GET['db']) ) {
		if ($_GET['db'] == "acr") {
			if (!db_show_acr_by_id($conn, $_GET['id']) ) {
				return 0;
			}
			else {
				return 1;
			}
		}
		if ($_GET['db'] == "term") {
			if (!db_show_term_by_id($conn, $_GET['id']) ) {
				return 0;
			}
			else {
				return 1;
			}
		}
	}
	if (isset($_GET['s'])) {
		if (!db_show_term_by_name($conn, $_GET['s']) ) {
			return 0;
		}
		else {
			return 1;
		}
	}
}

function db_show_term_by_id($conn, $id) {
	$id = db_test_input($id);
	$id = $conn->real_escape_string($id);
	$quer = "SELECT * FROM `Terms` WHERE `id` LIKE '$id'";
	$res = mysqli_query($conn, $quer);
	return db_show_term($res);
}

function db_show_term_by_name($conn, $s) {
	$s = db_test_input($s);
	$quer = "SELECT * FROM `Terms` WHERE `term` LIKE '$s'";
	$res = mysqli_query($conn, $quer);
	if (!$res || mysqli_num_rows($res) == 0) {
		header("Location: entry.php?db=term&id=0");
		exit;
	}
	else {
		$result = mysqli_fetch_array($res);
		header("Location: entry.php?db=term&id=" . $result['id']);
		exit;
	}
}

function db_show_term($res) {
	if (!$res || mysqli_num_rows($res) == 0) {
		?>
		<p class = "acroWords">
		<?php echo "Nothing Found"; ?>
		</p>
		<?php
		return 0;
	}
	else {
		$result = mysqli_fetch_array($res);
		?>
		<h2 class="acroTitle"><?php echo $result['term']; ?>  </h2> <hr>
		<p class = "acroWords"> <?php echo $result['meaning']; ?> </p>
		<?php	
		return 1;
	}
}

function db_show_acr_by_id($conn, $id) {
	$id = db_test_input($id);
	$id = $conn->real_escape_string($id);
	$quer = "SELECT * FROM `Acronyms` WHERE `id` LIKE '$id'";
	$res = mysqli_query($conn, $quer);
	return db_show_acr($res);
}

function db_show_acr($res) {
	if (!$res || mysqli_num_rows($res) == 0) {
		?>
		<p class = "acroWords">
		<?php echo "Nothing Found"; ?>
		</p>
		<?php
		return 0;
	}
	else {
		$result = mysqli_fetch_array($res);
		?>
		<h2 class="acroTitle"><?php echo $result['acr']; ?>  </h2> <hr>
		<p class = "acroWords"> <?php echo $result['meaning']; ?> </p>
		<?php		
		return 1;
	}
}

function db_insert_comment($conn) {
	if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user'])) {
		$db = db_test_input($_GET['db']);
		$db_id = db_test_input($_GET['id']);
		$comm = db_test_input($_POST['Comment']);
		$user = $_SESSION['user'];
		$comm = $conn->real_escape_string($comm);
		$db = $conn->real_escape_string($db);
		$db_id = $conn->real_escape_string($db_id);
		$quer = "INSERT INTO Comments (db, db_id, user, comment)VALUES ('$db', '$db_id', '$user', '$comm')";
    	mysqli_query($conn, $quer);
	}
}

function db_show_comments($conn) {
	if (isset($_GET['id']) && 
		isset($_GET['db']) ) {
		$db = db_test_input($_GET['db']);
		$db_id = db_test_input($_GET['id']);
		$db = $conn->real_escape_string($db);
		$db_id = $conn->real_escape_string($db_id);
		$quer = "SELECT * FROM `Comments` WHERE `db` LIKE '$db' AND `db_id` LIKE '$db_id'";
		$res = mysqli_query($conn, $quer);
		if (!$res || mysqli_num_rows($res) == 0) {
			?>
			<hr>
			<p class = "acroWords">
			<?php echo "No Comments"; ?>
			</p>
			<?php
		}
		else {
			?>
			<div class="comment">
			<hr>
			<?php
			while ($result = mysqli_fetch_array($res)){
				?>
				<span class="commentor"> 
				<i><?php echo $result['user'] ?>: </i> 
				</span> 
				<span class="commentItself"><?php echo $result['comment'] ?> </span><br>
				<?php
			}
			?>
			</div><br>
			<?php
		}
	}
}

?>