<?php
// Changed to PDO 2018-12-15 by Karsten Maske

$workers=0;
$motherships=0;
$explorers=0;

// get user array
$uID = getUserID();

$q1="SELECT * FROM `user` WHERE `id`=?";
$e1=$DB->prepare($q1);
if($e1->execute(array($uID)))
{
 $z1=$e1->fetch(PDO::FETCH_ASSOC);

 // get Mother Ships
 $q2="SELECT * FROM `unit_table` WHERE (`unit_owner`=?) AND (`unit_destroyed`=0) AND (`unit_model`=1)";
 $e2=$DB->prepare($q2);
 if($e2->execute(array($uID)))
 {
  // get Explorer Probes
  $q3="SELECT * FROM `unit_table` WHERE (`unit_owner`=?) AND (`unit_destroyed`=0) AND (`unit_model`=2)";
  $e3=$DB->prepare($q3);
  if($e3->execute(array($uID)))
  {
   // attribute vars
   $workers = $z1['workers'];
   $motherships = $e2->rowCount();
   $explorers = $e3->rowCount();
  }
  else
  {
exit("FEHLER: resDisplay_engine: #3");
  }
 }
 else
 {
exit("FEHLER: resDisplay_engine: #2");
 }
}
else
{
exit("FEHLER: resDisplay_engine: #1");
}
?>