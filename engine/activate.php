<?php
// Changed to PDO 2018-12-15 by Karsten Maske
// Changed Location to /Nomads/.... 2018-12-15 by Karsten Maske

include ("functions/registration_functions.php");

$token = $_GET['token'];
$q1="SELECT * FROM user_token WHERE token_token=?";
$e1=$DB->prepare($q1);
if($e1->execute(array($token)))
{
 $tokenCount = $e1->rowCount();

 // init
 $output = null;

 // activate engine
 if ($tokenCount < 1)
 {
  //token was not found
  $output = getString("error_activation_token");
  $output .= "<br><br>";
  $output .= "
    <center>
      <a href='/Nomads/?view=login' class='greenHrefButton'>
        LOGIN
      </a>
    </center>
  ";
  return;
 }
 else
 {
  // token was found
  if (!activateUser($token))
  {
   $output = getString("error_fatal_activation_token");
  }
  else
  {
   $output = getString("account_activated");
   $output .= "<br><br>";
   $output .= "
     <center>
       <a href='/Nomads/?view=login' class='greenHrefButton'>
         LOGIN
       </a>
     </center>
   ";
  }
 }
}
else
{
exit("FEHLER: activate: #1");
}
?>