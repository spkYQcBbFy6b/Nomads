<?php
// Changed to PDO 2018-12-15 by Karsten Maske

// initial prints
print "\n";
print "OUTDATED SESSION KILLER\n";
print "-------------------------\n";
$directory_array = explode('/',__DIR__);
$dir = "/" . $directory_array[1] . "/" . $directory_array[2] . "/" . $directory_array[3] . "/includes/dbConfig.php";

// init
$go = 0;
$nowTS = time();

// includes
include $dir;

// get settings
$q1="SELECT * FROM `game_settings` WHERE `game_setting_name`=?";
$e1=$DB->prepare($q1);
if($e1->execute(array(user_session_validity_minutes)))
{
 $z1=$e1->fetch(PDO::FETCH_ASSOC);
 $validity=$z1['game_setting_value'] * 60;

 // time calculations
 $timeOffset = $nowTS - $validity;

 // get all sessions query
 $q2="SELECT * FROM `user_session` WHERE `session_timestamp` < $timeOffset";
 if($e2=$DB->query($q2))
 {
  // validation
  if ($e2->rowCount() > 0)
  {
   // print
   print "SESSIONS DELETED.: ";

   // loop outdated sessions
   $q3="DELETE FROM user_session WHERE session_id=?";
   $e3=$DB->prepare($q3);
   WHILE($z2 = $e2->fetch(PDO::FETCH_ASSOC))
   {
    $go++;
    if(!$e1->execute(array($z2['session_id'])))
    {
exit("FEHLER: session_killer: #3");
    }
   }
   // end loop
   print $go . "\n";
  }
  else
  {
exit("FEHLER: session_killer: #2");
  }
 }
 else
 {
  // no outdated sessions to delete
  print "NO SESSIONS NEEDED DELETION.\n\n";
 }
}
else
{
exit("FEHLER: session_killer: #1");
}

// final prints
print "SCRIPT WILL NOW TERMINATE.\n";
print "Made By.: Alphabetus\n\n\n";
?>
