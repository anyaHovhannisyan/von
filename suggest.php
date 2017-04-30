<?php
  $page_title = "Suggest";
  $css_file = "suggest";
  require_once("header.php");
  if (isset($_SESSION['user'])) {
    db_insert_suggestion($conn);
  }
?>
<h1 class = "suga">Suggestions</h1>
<?php
  db_show_suggestions($conn);
?> 

<?php 
	if (isset($_SESSION['user'])) {
?>
<div id="foot">
      <div class="sl">
        <h2 class="syw"> &nbsp;Suggest your word</h2><br><br>
        <form id = "register" method = "post" action = "suggest.php">
          <input style='margin-top: 50px;' name='Word' type='text' placeholder="Word"><br>
          <span class = "lastik" id = "register_Word_errorloc"></span><br>
          <textarea placeholder="Meaning" name='Meaning'></textarea><br>
          <span class = "lastik" id = "register_Meaning_errorloc"></span><br>
          
          <input type="submit" value="Suggest">
        </form>
      </div>
</div>
<script type='text/javascript' src='scripts/sug_validate.js'></script>
<?php 
}
else {
  echo "<br>";
}
?>

<?php
  require_once("footer.php");
?>