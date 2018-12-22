<?php
// Changed Location to /Nomads/.... 2018-12-16 by Karsten Maske

// init
$loginOutput = null;
// includes
include ("engine/login_player.php");
?>
<head>
  <title>
    N Login
  </title>
</head>
<div class="mainContainer">
  <div class="splashBoundaries">
    <div class="registerBox">
      <table class="centeredFull">
        <tr>
          <th colspan="2">
            <b><h1>NOMADS - LOGIN</h1></b>
          </th>
        </tr>
        <tr>
          <td class="tableCenter">
            <form method="POST" action="">
              <input type="hidden" name="login" value="1"/>
              <input class="regFormInput" type="text" name="username" placeholder="Username" required/><br>
              <br>
              <input class="regFormInput" type="password" name="password" placeholder="Password" required/><br>
              <br>
              <input class="button_register" type="submit" value="LOGIN"/>
            </form>
          </td>
        </tr>
        <tr>
          <td class="tableCenter">
            <a href="/Nomads/?view=recoverPassword">recover password</a>
          </td>
        </tr>
      </table>
      <br>
      <center>
        <span class="errorOutput">
          <b>
            <?php
              print $loginOutput;
            ?>
          </b>
        </span>
      </center>
    </div>
  </div>
</div>
