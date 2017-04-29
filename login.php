<?php
  $page_title = "Log In";
  $css_file = "login";
  require_once("header.php");
?> 
    <div id="foot">
      <div class="sl">
        <h2> &nbsp;Register</h2><br><br>
        <form id = "register" method = "post" action = "login.php">
          <input style='margin-top: 50px;' name='FirstName' type='text' placeholder="First Name"><br>
          <span class = "lastik" id = "register_FirstName_errorloc"></span>

          <input name='LastName' type='text' placeholder="Last Name"><br>
          <span class = "lastik" id = "register_LastName_errorloc"></span>

          <input name='Email' type='text' placeholder="Email"><br>
          <span class = "lastik" id = "register_Email_errorloc">
            <?php 
              if ($reg_err == 2) {
                echo "This email is already used";
              }
            ?>
          </span>

          <input name='Username' type='text' placeholder="Username"><br>
          <span class = "lastik" id = "register_Username_errorloc">
            <?php 
              if ($reg_err == 1) {
                echo "This username is already taken";
              }
            ?>
          </span>

          <input name='Password' type='password' placeholder="Password"><br>
          <span class = "lastik" id = "register_Password_errorloc"></span>

          <input name='RePassword' type='password' placeholder="Re-Enter password"><br>
          <span class = "lastik" id = "register_RePassword_errorloc"></span><br />

          <select aria-label="Month" name="Month" title="Month">
            <option value = "month" selected = "true" disabled>Month</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
          </select>

          <select aria-label="Day" name="Day" title="Day">
            <option value="day" selected = "true" disabled>Day</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
            <option value="13">13</option>
            <option value="14">14</option>
            <option value="15">15</option>
            <option value="16">16</option>
            <option value="17">17</option>
            <option value="18">18</option>
            <option value="19">19</option>
            <option value="10">20</option>
            <option value="11">21</option>
            <option value="12">22</option>
            <option value="13">23</option>
            <option value="14">24</option>
            <option value="15">25</option>
            <option value="16">26</option>
            <option value="17">27</option>
            <option value="18">28</option>
            <option value="19">29</option>
            <option value="10">30</option>
            <option value="11">31</option>
          </select>

          <select aria-label="Year" name="Year" title="Year">
            <option value="year" selected = "true" disabled>Year</option>
            <option value="2000">2000</option>
            <option value="1999">1999</option>
            <option value="1998">1998</option>
            <option value="1997">1997</option>
            <option value="1996">1996</option>
            <option value="1995">1995</option>
            <option value="1994">1994</option>
            <option value="1993">1993</option>
            <option value="1992">1992</option>
            <option value="1991">1991</option>
            <option value="1990">1990</option>
            <option value="1989">1989</option>
          </select><br>

          <span class = "lastik" id = "register_Month_errorloc"></span><br />
          <span class = "lastik" id = "register_Day_errorloc"></span><br />
          <span class = "lastik" id = "register_Year_errorloc"></span><br />

<!--
          <select class='gcc' name = 'Gender'>
            <option value="">Gender</option>
            <option value="female">Female</option>
            <option value="male">Male</option>
          </select><br>
          <input name='City' type='text' placeholder="City"><br>

          <select class='gcc' name = 'Country'>
            <option value="">Country...</option>
          </select><br>   -->
          <input type="submit" value="Register">
        </form>
      </div>

      <div class="sl1">
        <h2> &nbsp;  Log In</h2><br><br>
        <form id = "login" method = "post" action = "login.php">
          <input style='margin-top: 50px;' name='LUsername' type='text' placeholder="Username"><br>
          <span class = "lastik" id = "login_LUsername_errorloc">
            <?php 
              if ($log_err == 1) {
                echo "Wrong Username";
                echo "<br />";
              }
            ?>
          </span>

          <input name='LPassword' type='password' placeholder="Password"><br>
          <span class = "lastik" id = "login_LPassword_errorloc">
            <?php 
              if ($log_err == 2) {
                echo "Wrong Password";
              }
            ?>
          </span><br />
          <input type="submit" value="Log In">
        </form>
      </div>
    </div>
    <script type='text/javascript' src='scripts/form_validate.js'></script>

<?php
  require_once("footer.php");
?>