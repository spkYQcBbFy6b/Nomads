<?php
// Changed to PDO 2018-12-15 by Karsten Maske
// Changed Location to /Nomads/.... 2018-12-16 by Karsten Maske

if(!$_SESSION['player'] OR getUserSession() == 0)
{
 header("Location: /Nomads/?view=login");
}
else
{
 $q1="SELECT `id` FROM `user` WHERE `id`=?";
 $e1=$DB->prepare($q1);
 if($e1->execute(array($_SESSION['player'])))
 {
  if($e1->rowCount()<1)
  {
   logout();
  }
 }
 else
 {
exit("FEHLER: lock: #1");
 }
}
?>