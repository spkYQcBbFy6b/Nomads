<?php
// Changed to PDO 2018-12-14 by Karsten Maske 

// GET PLAYER LOCATION
function getPlayerLoc($userID)
{
 $out = null;
 include("includes/dbConnect.php");

 $q1="SELECT `id`,`location_ship` FROM `user` WHERE `id`=?";
 $e1=$DB->prepare($q1);
 if($e1->execute(array($userID)))
 {
  $z1=$e1->fetch(PDO::FETCH_ASSOC);
  $locID = $z1['location_ship'];

  // lets define location
  if ($locID == 0)
  {
   // no mother ship
   $q2="SELECT * FROM `map_default` WHERE `map_id`=1";
   if($e2=$DB->query($q2))
   {
    $z2=$e2->fetch(PDO::FETCH_ASSOC);
    return($z2['map_name'] . " " . "[ ".$z2['map_X'].":".$z2['map_Y']." ]");
   }
   else
   {
exit("FEHLER: player_functions: function getPlayerLoc() #2");
   }
  }
  else
  {
   // get active location
   $q3="SELECT `unit_id`,`unit_posX`,`unit_posY` FROM `unit_table` WHERE `unit_id`=?";
   $e3=$DB->prepare($q3);
   if($e3->execute(array($locID)))
   {
    $z3=$e3->fetch(PDO::FETCH_ASSOC);
    // pos Vars
    $posX = $z3['unit_posX'];
    $posY = $z3['unit_posY'];

    // check if map is default
    $q4="SELECT * FROM `map_default` WHERE (`map_X`=?) AND (`map_Y`=?)";
    $e4=$DB->prepare($q4);
    if($e4->execute(array($posX,$posY)))
    {
     // validate if map is default, if else gets map generated info
     if ($e4->rowCount() > 0)
     {
      $z4=$e4->fetch(PDO::FETCH_ASSOC);
      $mapName = $z4['map_name'];
     }
     else
     {
      // get gen map data
      $q5="SELECT * FROM `map_generated` WHERE (`mapGen_X`=?) AND (`mapGen_Y`=?)";
      $e5=$DB->prepare($q5);
      if($e5->execute(array($posX,$posY)))
      {
       $z5=$e5->fetch(PDO::FETCH_ASSOC);
       $mapName = $z5['mapGen_name'];
      }
      else
      {
exit("FEHLER: player_functions: function getPlayerLoc() #4");
      }
     }
     // define out
     $out = $mapName . " [ ".$posX.":".$posY." ]";
    }
    else
    {
exit("FEHLER: player_functions: function getPlayerLoc() #4");
    }
   }
   else
   {
exit("FEHLER: player_functions: function getPlayerLoc() #3");
   }
  }
 }
 else
 {
exit("FEHLER: player_functions: function getPlayerLoc() #1");
 }
 return $out;
}
// --------------------------------------------------------------------------------------------------------------------------------------------
// GET PLAYER POSITION X
function getPlayerPosX()
{
 $userID = getUserID();
 $out = null;
 include("includes/dbConnect.php");

 $q1="SELECT `id`,`location_ship` FROM `user` WHERE `id`=?";
 $e1=$DB->prepare($q1);
 if($e1->execute(array($userID)))
 {
  $z1=$e1->fetch(PDO::FETCH_ASSOC);
  $locID = $z1['location_ship'];

  // lets define location
  if ($locID == 0)
  {
   // no mother ship
   $q2="SELECT * FROM `map_default` WHERE `map_id`=1";
   if($e2=$DB->query($q2))
   {
    $z2=$e2->fetch(PDO::FETCH_ASSOC);
    return($z2['map_X']);
   }
   else
   {
exit("FEHLER: player_functions: function getPlayerPosX() #2");
   }
  }
  else
  {
   // get active location
   $q3="SELECT `unit_id`,`unit_posX` FROM `unit_table` WHERE `unit_id`=?";
   $e3=$DB->prepare($q3);
   if($e3->execute(array($locID)))
   {
    $z3=$e3->fetch(PDO::FETCH_ASSOC);
    return($z3['unit_posX']);
   }
   else
   {
exit("FEHLER: player_functions: function getPlayerPosX() #3");
   }
  }
 }
 else
 {
exit("FEHLER: player_functions: function getPlayerPosX() #1");
 }
}
// --------------------------------------------------------------------------------------------------------------------------------------------
// GET PLAYER POSITION Y
function getPlayerPosY()
{
 $userID = getUserID();
 $out = null;
 include("includes/dbConnect.php");

 $q1="SELECT `id`,`location_ship` FROM `user` WHERE `id`=?";
 $e1=$DB->prepare($q1);
 if($e1->execute(array($userID)))
 {
  $z1=$e1->fetch(PDO::FETCH_ASSOC);
  $locID = $z1['location_ship'];

  // lets define location
  if ($locID == 0)
  {
   // no mother ship
   $q2="SELECT * FROM `map_default` WHERE `map_id`=1";
   if($e2=$DB->query($q2))
   {
    $z2=$e2->fetch(PDO::FETCH_ASSOC);
    return($z2['map_Y']);
   }
   else
   {
exit("FEHLER: player_functions: function getPlayerPosY() #2");
   }
  }
  else
  {
   // get active location
   $q3="SELECT `unit_id`,`unit_posY` FROM `unit_table` WHERE `unit_id`=?";
   $e3=$DB->prepare($q3);
   if($e3->execute(array($locID)))
   {
    $z3=$e3->fetch(PDO::FETCH_ASSOC);
    return($z3['unit_posY']);
   }
   else
   {
exit("FEHLER: player_functions: function getPlayerPosY() #3");
   }
  }
 }
 else
 {
exit("FEHLER: player_functions: function getPlayerPosY() #1");
 }
}
// --------------------------------------------------------------------------------------------------------------------------------------------
// GET PLAYER MOTHERSHIPS
function getMotherShips_total()
{
 include("includes/dbConnect.php");
 $id = getUserID();

 $q1="SELECT * FROM `unit_table` WHERE (`unit_owner`=?) AND (`unit_model`=1) AND (`unit_destroyed`=0)";
 $e1=$DB->prepare($q1);
 if($e1->execute(array($id)))
 {
  return($e1->rowCount());
 }
 else
 {
exit("FEHLER: player_functions: function getMotherShips_total()");
 }
}
// --------------------------------------------------------------------------------------------------------------------------------------------
// GET PLAYER UNIT TOTALS
function getTotalUnitsByID($id)
{
 include("includes/dbConnect.php");

 $uID = getUserID();
 $q1="SELECT * FROM unit_table WHERE (`unit_owner`=?) AND (`unit_model`=?) AND (`unit_destroyed`=0)";
 $e1=$DB->prepare($q1);
 if($e1->execute(array($uID,$id)))
 {
  return($e1->rowCount());
 }
 else
 {
exit("FEHLER: player_functions: function getTotalUnitsByID()");
 }
}
// --------------------------------------------------------------------------------------------------------------------------------------------
// GET PLAYER GOLD
function getPlayerGold()
{
 include("includes/dbConnect.php");

 $id = getUserID();

 $q1="SELECT `id`,`gold` FROM `user` WHERE `id`=?";
 $e1=$DB->prepare($q1);
 if($e1->execute(array($id)))
 {
  $z1=$e1->fetch(PDO::FETCH_ASSOC);
  return($z1['gold']);
 }
 else
 {
exit("FEHLER: player_functions: function getPlayerGold()");
 }
}
// --------------------------------------------------------------------------------------------------------------------------------------------
// ALTER LAST ACTION FIELD
function updateLastAction()
{
 include("includes/dbConnect.php");

 $id = getUserID();
 $ip = getIP();
 $now = getTime();
 $time = time();

 $q1="UPDATE `user` SET `lastAction`=? WHERE `id`=?";
 $e1=$DB->prepare($q1);
 if($e1->execute(array($now,$id)))
 {
  $q2="UPDATE `user_session` SET `session_timestamp`=? WHERE (`session_userID`=?) AND (`session_ip`=?)";
  $e2=$DB->prepare($q2);
  if(!$e2->execute(array($time,$id,$ip)))
  {
exit("FEHLER: player_functions: function updateLastAction() #2");
  }
 }
 else
 {
exit("FEHLER: player_functions: function updateLastAction() #1");
 }
}
// --------------------------------------------------------------------------------------------------------------------------------------------
// ASSIGN MOTHER SHIP AUTOMATICALLY
function assignMotherShip()
{
 include("includes/dbConnect.php");

 $id = getUserID();

 // Query to user table to check if location ship is 0

 $q1="SELECT `id`,`location_ship` FROM `user` WHERE (`id`=?) AND (`location_ship`=0)";
 $e1=$DB->prepare($q1);
 if($e1->execute(array($id)))
 {
  // validate results
  if ($e1->rowCount() > 0)
  {
   // there is no mothership assigned. lets check if he has one.
   if (getMotherShips_total() > 0)
   {
     // he has at least one.
    $q2="SELECT * FROM `unit_table` WHERE (`unit_owner`=?) AND (`unit_model`=1) ORDER BY `unit_id` LIMIT 1";
    $e2=$DB->prepare($q2);
    if($e2->execute(array($id)))
    {
     $z2=$e2->fetch(PDO::FETCH_ASSOC);
     $motherShipID = $z2['unit_id'];

     // write new ship query
     $q3="UPDATE `user` SET `location_ship`=? WHERE `id`=?";
     $e3=$DB->prepare($q3);
     if(!$e3->execute(array($motherShipID,$id)))
     {
exit("FEHLER: player_functions: function assignMotherShip() #3");
     }
    }
    else
    {
exit("FEHLER: player_functions: function assignMotherShip() #2");
    }
   }
  }
 }
 else
 {
exit("FEHLER: player_functions: function assignMotherShip() #1");
 }
}
// --------------------------------------------------------------------------------------------------------------------------------------------
// GET PLAYER ACTIVE MOTHERSHIP
function getActiveMothership()
{
 include("includes/dbConnect.php");
 $uID = getUserID();

 // query to get active ship loc.
 $q1="SELECT `id`,`location_ship` FROM `user` WHERE `id`=?";
 $e1=$DB->prepare($q1);
 if($e1->execute(array($uID)))
 {
  $z1=$e1->fetch(PDO::FETCH_ASSOC);
  return($z1['location_ship']);
 }
 else
 {
exit("FEHLER: player_functions: function getActiveMothership()");
 }
}
// --------------------------------------------------------------------------------------------------------------------------------------------
?>
