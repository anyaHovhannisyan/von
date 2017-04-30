<?php

$fname = $lname = $username = 
$email = $password = $date = 
$gender = $city = $country = $science = $about ="";

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
			$gender, $city, $country, $science,
			$about;
	global $reg_err;
	$fname = db_test_input($_POST["FirstName"]);
	$lname = db_test_input($_POST["LastName"]);
	$username = db_test_input($_POST["Username"]);
	$email = db_test_input($_POST["Email"]);
	$password = db_test_input($_POST["Password"]);
	$month = db_test_input($_POST["Month"]);
	$day = db_test_input($_POST["Day"]);
	$year = db_test_input($_POST["Year"]);
	$science = db_test_input($_POST["Science"]);
	$about = db_test_input($_POST["About"]);
	$date = $year . "-" . $month . "-" . $day;
	$fname = $conn->real_escape_string($fname);
	$lname = $conn->real_escape_string($lname);
	$username = $conn->real_escape_string($username);
	$email = $conn->real_escape_string($email);
	$password = $conn->real_escape_string($password);
	$date = $conn->real_escape_string($date);
	$science = $conn->real_escape_string($science);
	$about = $conn->real_escape_string($about);
	if (!db_check_reg($conn, "username", $username)) {
		$reg_err = 1;
		return;
	}
	if (!db_check_reg($conn, "email", $email)) {
		$reg_err = 2;
		return;
	}
	$quer = "INSERT INTO Users (fname, lname, email, username, password, bday, science, about)VALUES ('$fname', '$lname', '$email', '$username', '$password', '$date', '$science', '$about')";
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
		<div class="acro">
      	<h2 class="acroTitle"> Acronyms </h2> <hr>
		<?php
		db_search_acr($conn, $str);
		?>
		<hr>
		<br>
		</div>
		<div class="term">
      	<h2 class="acroTitle"> Terms </h2> <hr>
		<?php
		db_search_term($conn, $str);
		?>
		<hr>
		<br>
		<?php
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
		<p class = "acroWords6">
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
    	increment_cnum($conn, $user);
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
			<p class = "acroWords6">
			<?php echo "No Comments"; ?>
			</p>
			<br>
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


function db_insert_suggestion($conn) {
	if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user'])) {
		$word = db_test_input($_POST['Word']);
		$meaning = db_test_input($_POST['Meaning']);
		$user = $_SESSION['user'];
		$word = $conn->real_escape_string($word);
		$meaning = $conn->real_escape_string($meaning);
		$quer = "INSERT INTO Suggestions (word, meaning, username)VALUES ('$word', '$meaning', '$user')";
    	mysqli_query($conn, $quer);
    	increment_snum($conn, $user);
	}
}

function db_show_suggestions($conn) {
	$quer = "SELECT * FROM `Suggestions`";
	$res = mysqli_query($conn, $quer);
	if (!$res || mysqli_num_rows($res) == 0) {
		?>
		<hr>
		<br>
		<p class = "acroWords6">
		<?php echo "No Suggestions"; ?>
		</p>
		<?php
	}
	else {
		?>
		<div class="comment">
		<hr>
		<br>
		<?php
		while ($result = mysqli_fetch_array($res)){
			?>
			<span class="commentor"> 
			<i><?php echo $result['username'] ?>: </i> 
			</span> 
			<span class="commentItself"><?php echo $result['word'] ?> - </span>
			<span class="commentItself"><?php echo $result['meaning'] ?> </span><br>
			<?php
		}
		?>
		</div>
		<?php
	}
	
}

function increment_cnum($conn, $user)
{
	$user = $conn->real_escape_string($user);
	$quer = "SELECT * FROM `Users` WHERE `username` LIKE '$user'";
	$res = mysqli_query($conn, $quer);
	$result = mysqli_fetch_array($res);
	$cnum = $result['cnum'] + 1;
	$quer = "UPDATE `Users` SET `cnum` = $cnum WHERE `username` LIKE '$user'";
    mysqli_query($conn, $quer);
    switch($cnum) {
    	case 10:
    		$img = "cb1.png";
    		break;
    	case 50:
    		$img = "cb2.png";
    		break;
    	case 100:
    		$img = "cb3.png";
    		break;
    	case 500:
    		$img = "cb4.png";
    		break;
    	default:
    		return;
    }
    $quer = "UPDATE `Users` SET `cbadge` = '$img' WHERE `username` LIKE '$user'";
    mysqli_query($conn, $quer);
}

function increment_snum($conn, $user)
{
	$user = $conn->real_escape_string($user);
	$quer = "SELECT * FROM `Users` WHERE `username` LIKE '$user'";
	$res = mysqli_query($conn, $quer);
	$result = mysqli_fetch_array($res);
	$snum = $result['snum'] + 1;
	$quer = "UPDATE `Users` SET `snum` = $snum WHERE `username` LIKE '$user'";
    mysqli_query($conn, $quer);
    switch($snum) {
    	case 10:
    		$img = "sb1.png";
    		break;
    	case 50:
    		$img = "sb2.png";
    		break;
    	case 100:
    		$img = "sb3.png";
    		break;
    	case 500:
    		$img = "sb4.png";
    		break;
    	default:
    		return;
    }
    $quer = "UPDATE `Users` SET `sbadge` = '$img' WHERE `username` LIKE '$user'";
    mysqli_query($conn, $quer);
}

?>