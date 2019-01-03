<?php
// Changed to PDO 2018-12-15 by Karsten Maske

// VALIDATE LOGIN DATA AND CREATE SESSION
function loginPlayer()
{
 // init
 $query = null;

 // file
 include("functions/registration_functions.php");
 include("includes/dbConnect.php");

 $user = $_POST['username'];
 $pass = password_encrypt($_POST['password']);

 // query for data
 $q1="SELECT `username`,`password`,`id`,`active` FROM `user` WHERE (`username`=?) AND (`password`=?) AND (`active`=1)";
 $e1=$DB->prepare($q1);
 if(!$e1->execute(array($user,$pass)))
 {
exit("FEHLER: login_functions: function loginPlayer() #1");
 }
 $uCheck=$e1->rowCount();
 $uA=$e1->fetch(PDO::FETCH_ASSOC);
 $uID = $uA['id'];
 $now = time();
 if ($uCheck > 0)
 {
  // verify session server side
  $ip = getIP();

  $q2="SELECT * FROM `user_session` WHERE `session_userID`=?";
  $e2=$DB->prepare($q2);
  if(!$e2->execute(array($uID)))
  {
exit("FEHLER: login_functions: function loginPlayer() #2");
  }
  $sessionNumbers = $e2->rowCount();
  $sessionA = $e2->fetch(PDO::FETCH_ASSOC);
  $sessionID = $sessionA['session_id'];

  // update or create session
  if ($sessionNumbers > 0)
  {
   // update existent session
   $q3="UPDATE user_session SET `session_timestamp`=?, `session_ip`=? WHERE `session_id`=?";
   $e3=$DB->prepare($q3);
   if(!$e3->execute(array($now,$ip,$sessionID)))
   {
exit("FEHLER: login_functions: function loginPlayer() #3");
   }
  }
  else
  {
   // insert new session
   $q4="INSERT INTO `user_session` (`session_userID`,`session_timestamp`,`session_ip`) VALUES (?,?,?)";
   $e4=$DB->prepare($q4);
   if(!$e4->execute(array($uID,$now,$ip)))
   {
exit("FEHLER: login_functions: function loginPlayer() #4");
   }
  }

  // create session php
  $_SESSION['player'] = $uID;
  return(TRUE);
 }
 else
 {
  return(FALSE);
 }
}
?>