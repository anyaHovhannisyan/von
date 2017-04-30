<?php
  $page_title = "User";
  $css_file = "user";
  require_once("header.php");
?>

<div id="foot">
<?php
if (isset($_SESSION['user'])) {
	$lusername = db_test_input($_SESSION['user']);
	$lusername = $conn->real_escape_string($lusername);
	$quer = "SELECT * FROM `Users` WHERE `username` LIKE '$lusername'";
	$res = mysqli_query($conn, $quer);
	$result = mysqli_fetch_array($res);
?>
<?php
if ($result['science'] == 0) {
	$sci = "Teapot";
}
else {
	$sci = "Scientist";
}
?>
<img class="userImage" src="style/img/<?php echo $sci;?>1.png">
<img class="acroImage1" src="style/img/<?php echo $result['cbadge'];?>">
<img class="acroImage2" src="style/img/<?php echo $result['sbadge'];?>">
<h2 class="userName1"> <?php echo $result['fname'] . " " . $result['lname']; ?>  </h2>


<h2 class="userScience"> <?php echo $sci; ?>  </h2> 
<hr>
<h3 class="userAbout"> <?php echo $result['about'];?> </h3>

<?php
}
?>
</div>


<?php
  require_once("footer.php");
?>