<?php
// Changed to PDO 2018-12-14 by Karsten Maske
// Changed Location to /Nomads/.... 2018-12-15 by Karsten Maske

// LOGOUT REACTION
if (isset($_GET['logout']))
{
 if ($_GET['logout'] > 0)
 {
  logout();
  return;
 }
}
// ------------------------------------------------------------------------------------------------------------------------------
// GAMEVIEW CHECKER > REDIRECT IF NONE
function fixGameView()
{
 if (!isset($_GET['gameView']))
 {
  header("Location: /Nomads/game_index.php?gameView=overview");
 }
 return;
}
// ------------------------------------------------------------------------------------------------------------------------------
// LOAD STRING FROM FOLDER
function getString($id)
{
 $fName = "strings/" . $id . ".txt";
 $out = "<!-- STRING FILE ID: ".$id." --!>";
 $out .= file_get_contents($fName);
 return($out);
}
// ------------------------------------------------------------------------------------------------------------------------------
// LOGOUT
function logout()
{
 include("includes/dbConnect.php");

 // vars
 $uID = getUserID();

 // delete SQL session
 $q1="DELETE FROM `user_session` WHERE `session_userID`=$uID";
 if(!$DB->query($q1))
 {
exit("FEHLER: common_functions: function logout()");
 }

 // php session destroyer
 session_destroy();
 session_unset();
 unset($_SESSION['player']);
 // redirect homepage
 header("Location: /Nomads/");
 exit();
}
// ------------------------------------------------------------------------------------------------------------------------------
// GET USER ID
function getUserID()
{
 return($_SESSION['player']);
}
// ------------------------------------------------------------------------------------------------------------------------------
// GET USER EMAIL
function getUserEmail()
{
 include("includes/dbConnect.php");
 $id = $_SESSION['player'];

 $q1="SELECT `email`,`id` FROM `user` WHERE `id`=$id";
 if($e1=$DB->query($q1))
 {
  $z1 = $e1->fetch(PDO::FETCH_ASSOC);
  return($z1['email']);
 }
 else
 {
exit("FEHLER: common_functions: function getUserEmail()");
 }
}
// ------------------------------------------------------------------------------------------------------------------------------
// GENERATE DEFAULT TIME
function getTime()
{
 $now = time();
 $now = date('y-m-d - H:i:s');
 return $now;
}
// ------------------------------------------------------------------------------------------------------------------------------
// GET VISITOR IP
function getIP()
{
 if ( getenv("HTTP_CLIENT_IP") )
 {
  $ip = getenv("HTTP_CLIENT_IP");
 }
 elseif( getenv("HTTP_X_FORWARDED_FOR") )
 {
  $ip = getenv("HTTP_X_FORWARDED_FOR");
  if ( strstr($ip, ',') )
  {
   $tmp = explode(',', $ip);
   $ip = trim($tmp[0]);
  }
 }
 else
 {
  $ip = getenv("REMOTE_ADDR");
 }
 return($ip);
}
// ------------------------------------------------------------------------------------------------------------------------------
// GET SERVER SIDED SESSION
function getUserSession()
{
 include("includes/dbConnect.php");

 $id = getUserID();
 $ip = getIP();

 $q1="SELECT * FROM `user_session` WHERE (`session_userID`='".$id."') AND (`session_ip`='".$ip."')";
 if($e1=$DB->query($q1))
 {
  $sessionCheck = $e1->rowCount();
 }
 else
 {
exit("FEHLER: common_functions: function getUserSession()");
 }

 // validate if there is session
 if ($sessionCheck < 1)
 {
  $sessionID = 0;
 }
 else
 {
  $sessionA = $e1->fetch(PDO::FETCH_ASSOC);
  $sessionID = $sessionA['session_id'];
 }
 return($sessionID);
}
// --------------------------------------------------------------------------------------------------------------------------------------------
// GET GAME SETTINGS
// Changed 2019-01-02 by Karsten Maske
// many changes (also the wrong error message), so commented out the original function for documentation.
/*
function getSetting($settingID)
{
 include("includes/dbConnect.php");

 $q1="SELECT * FROM `game_settings` WHERE `game_setting_id`='".$settingID."'";
 if($e1=$DB->query($q1))
 {
  $settingsArray = $e1->fetch(PDO::FETCH_ASSOC);
  return($settingsArray['game_setting_value']);
 }
 else
 {
exit("FEHLER: common_functions: function getUserSession()");
 }
}
*/
function getSetting($settingName)
{
 include('includes/dbConnect.php');

 $q1="SELECT `v` FROM `game_settings` WHERE `k`='".$settingName."'";
 if($e1=$DB->query($q1))
 {
  $z1=$e1->fetch(PDO::FETCH_NUM);
  return($z1[0]);
 }
 else
 {
exit("FEHLER: common_functions: function getSetting()");
 }
}



// --------------------------------------------------------------------------------------------------------------------------------------------
?>