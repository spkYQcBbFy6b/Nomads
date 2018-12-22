<?php
// Changed Location to /Nomads/.... 2018-12-15 by Karsten Maske

// include
include "functions/recoverPassword_functions.php";
// file
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
  if(isset($_POST['recoverPassword'])){
    if(!recoverUserPassword($_POST['email'])){
      $registerOutput = getString("password_reset_error");
      return;
    }
    else{
      $registerOutput = getString("password_reset_ok");
      $registerOutput .= "<br><br>";
      $registerOutput .= "
        <a href='/Nomads/?view=login' class='greenHrefButton'>
          LOGIN
        </a>
      ";
      return;
    }
  }
  return;
}
return;
?>
