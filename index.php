<?php
	$page_title = "Dictionary of Earth";
	$css_file = "index";
  	require_once("header.php");
?> 

      <div class="shapka">
        <h1 class="shapkaH1"> Introducing VON </h1>
        <h2 class="shapkaH2">The Dictionary of Earth</h2>
        <h3 class="shapkaH3"> The only source, where you can find all-known systemized terms and acronyms used by NASA scientists.</h3>
      </div>
<div id="foot">
<?php
	db_search($conn);
?>
</div>

<?
  require_once("footer.php");
?> 
  
