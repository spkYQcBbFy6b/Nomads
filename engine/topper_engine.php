<?php
// Changed to PDO 2018-12-15 by Karsten Maske
// Changed Location to /Nomads/.... 2018-12-16 by Karsten Maske

// init
$topperLogo = "<a href='/Nomads/'>NOMADS</a>";

// includes
include "functions/topper_functions.php";

// topper logged out vars
$time = time();
$time = date("H:i:s");
$timeOut = "Server Time.: " . $time;

// check if logged in
if (isset($_SESSION['player']) AND getUserSession() > 0 AND getUserID() > 0)
{
 // generate logo
 $topperLogo = "<a href='/Nomads/game_index.php'>NOMADS</a>";

 // get logged in user
 $id = getUserID();

 $q1="SELECT * FROM `user` WHERE `id`=?";
 $e1=$DB->prepare($q1);
 if($e1->execute(array($id)))
 {
  $z1=$e1->fetch(PDO::FETCH_ASSOC);
  $username = $z1['username'];

  // get location
  $location = getPlayerLoc($id);

  // design table
  $loggedInTopper = "
    <td>
      ".$username."
    </td>
    <td>
      ".$location."
    </td>
  ";
 }
 else
 {
exit("FEHLER: topper_engine: #1");
 }
}
?>