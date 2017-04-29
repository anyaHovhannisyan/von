<?php
	$page_title = "Dictionary of Earth";
	$css_file = "index";
  	require_once("header.php");
?> 

<div id="foot">
<?php
	db_search($conn);
?>
</div>

<?
  require_once("footer.php");
?> 
  
