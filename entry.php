<?php
	$page_title = "Dictionary of Earth";
	$css_file = "entry";
  	require_once("header.php");
?> 

<div id="foot">
<?php
db_insert_comment($conn);
if (db_show($conn)) {
	db_show_comments($conn);
 	if(isset($_SESSION['user'])) {?>
		<form id = "comment" method = "post" action="?db=<?php echo $_GET['db']?>&id=<?php echo $_GET['id']?>" >
    		<textarea placeholder="Comment..." name='Comment'></textarea><br>
    		<input type="submit" value="Comment">
		</form>
	<?php }
	else {?>
		<p class = "acroWords"> If you want to leave a comment please <a href="login.php">Log In</a>
		</p>
	<?php } 
}?>

</div>

<?
  require_once("footer.php");
?> 
  
