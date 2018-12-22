<?php
// Changed to PDO 2018-12-14 by Karsten Maske 

// CHECK IF MAP TILE EXITS OR IS DEFAULT
function isMapThere($x,$y)
{
 // init & includes
 include("includes/dbConnect.php");
 $out = false;
 // get default query & count
 
 $q1="SELECT * FROM `map_default` WHERE (`map_X`=$x) AND (`map_Y`=$y)";
 if($e1=$DB->query($q1))
 {
  // validate default map
  if ($e1->rowCount() > 0)
  {
   // map is default
   $out = true;
  }
  else
  {
   // map is not default > perform search for generated
   // get generated map query
   $q2="SELECT * FROM `map_generated` WHERE (`mapGen_x`=$x) AND (`mapGen_y`=$y)";
   if($e2=$DB->query($q2))
   {
    // validate generated map and gives boolean return
    $out = ($e2->rowCount() > 0) ? TRUE:FALSE;
   }
   else
   {
exit("FEHLER: generator_functions: function isMapThere() #2");
   }
  }
 }
 else
 {
exit("FEHLER: generator_functions: function isMapThere() #1");
 }
 return $out;
}
// ------------------------------------------------------------------------------------------------------------------------------------------------------
// GET MAP TILE IMAGE
function retriveMapTile_img($x,$y)
{
 // init & includes
 include("includes/dbConnect.php");
 $out = null;
 // check if tile exists
 if (!isMapThere($x,$y))
 {
  // map is not there > give default
  $out = "default_tile";
 }
 else
 {
  // map is there > get tile name
  // check if default or generated

  $q1="SELECT * FROM `map_default` WHERE (`map_X`=$x) AND (`map_Y`=$y)";
  if($e1=$DB->query($q1))
  {
   if ($e1->rowCount() > 0)
   {
    // is default
    $z1=$e1->fetch(PDO::FETCH_ASSOC);
    $out = $z1['map_tile'];
   }
   else
   {
    // is generated
    $q2="SELECT * FROM `map_generated` WHERE (`mapGen_x`=$x) AND (`mapGen_y`=$y)";
    if($e2=$DB->query($q2))
    {
     $z2=$e2->fetch(PDO::FETCH_ASSOC);
     $out = $z2['mapGen_tile'];
    }
    else
    {
exit("FEHLER: generator_functions: function retriveMapTile_img() #2");
    }
   }
  }
  else
  {
exit("FEHLER: generator_functions: function retriveMapTile_img() #1");
  }
 }
 return($out);
}
// ------------------------------------------------------------------------------------------------------------------------------------------------------
// IS MAP A DEFAULT MAP
function isMapDefault($x,$y)
{
 // init & includes
 include("includes/dbConnect.php");
 $out = null;
 // query default table
 $q1="SELECT * FROM `map_default` WHERE (`map_X`=$x) AND (`map_Y`=$y)";
 if($e1=$DB->query($q1))
 {
  $out = ($e1->rowCount() > 0) ? TRUE:FALSE;
  return $out;
 }
 else
 {
exit("FEHLER: generator_functions: function isMapDefault()");
 }
}
// ------------------------------------------------------------------------------------------------------------------------------------------------------
// IS THERE A STAR HERE?
function isStarThere($x,$y)
{
 // init & includes
 include("includes/dbConnect.php");
 $out = null;
 // check if map exists
 if(!isMapThere($x,$y))
 {
  // map is not there > end false
  $out = false;
  return $out;
 }
 else
 {
  // map is there > check if default
  if (isMapDefault($x,$y))
  {
   // map is default > get star ID
   $q1="SELECT * FROM `map_default` WHERE (`map_X`=$x) AND (`map_Y`=$y)";
   if($e1=$DB->query($q1))
   {
    $z1=$e1->fetch(PDO::FETCH_ASSOC);
    $out = ($z1['map_star'] >= 1) ? $z1['map_star']:FALSE;
    return $out;
   }
   else
   {
exit("FEHLER: generator_functions: function isStarThere() #1");
   }
  }
  else
  {
   // map is NOT default > get Star ID
   $q2="SELECT * FROM `map_generated` WHERE (`mapGen_x`=$x) AND (`mapGen_y`=$y)";
   if($e2=$DB->query($q2))
   {
    $z2=$e2->fetch(PDO::FETCH_ASSOC);
    $out = ($z2['mapGen_star'] >= 1) ? $z2['mapGen_star']:FALSE;
    return $out;
   }
   else
   {
exit("FEHLER: generator_functions: function isStarThere() #2");
   }
  }
 }
 return $out;
}
// ------------------------------------------------------------------------------------------------------------------------------------------------------
// GENERATE MAP
function generateMap($x,$y)
{
 include("includes/dbConnect.php");
 // verify if map is there
 if (isMapThere($x,$y))
 {
  return false;
 }

 // map is not there > generate
 // get map data > leave star ID & map name to the conclusion of this function to avoid order errors.
 $tileIMG = genMapTileIMG();
 $mapNow = time();
 $userID = getUserID();

 // insert MAP
 $q1="INSERT INTO `map_generated` (`mapGen_x`,`mapGen_y`,`mapGen_tile`,`mapGen_createdAt`,`mapGen_discoveredBy`) VALUES (?,?,?,?,?)";
 $e1=$DB->prepare($q1);
 if($e1->execute(array($x,$y,$tileIMG,$mapNow,$userID)))
 {
  // define MAP ID
//  $mapID = $e1->lastInsertId(); // !! FUNKTIONIERT  N I C H T !!
  $q4="SELECT MAX(`mapGen_id`) FROM `map_generated` WHERE (`mapGen_x`=?) AND (`mapGen_y`=?) AND (`mapGen_tile`=?) AND (`mapGen_createdAt`=?) AND (`mapGen_discoveredBy`=?)";
  $e4=$DB->prepare($q4);
  $e4->execute(array($x,$y,$tileIMG,$mapNow,$userID));
  list($mapID)=$e4->fetch(PDO::FETCH_NUM);

  // verify if star is generated
  if (odds_star())
  {
   // get star name and ID to update on map
   $starID = createStarAndPlanets($x,$y,$mapID);

   $q2 = "SELECT `starGen_ID`,`starGen_name` FROM `star_generated` WHERE `starGen_ID`='".$starID."'";
   if($e2=$DB->query($q2))
   {
    $z2=$e2->fetch(PDO::FETCH_ASSOC);
    $starName = $z2['starGen_name'];
    $systemName = $starName . " System";

    // update data query
    $q3 = "UPDATE `map_generated` SET `mapGen_star`=?, `mapGen_name`=? WHERE `mapGen_id`=?";
    $e3=$DB->prepare($q3);
    if(!$e3->execute(array($starID,$systemName,$mapID))) 
    {
exit("FEHLER: generator_functions: function generateMap() #3");
    }
   }
   else
   {
exit("FEHLER: generator_functions: function generateMap() #2");
   }
  }
 }
 else
 {
exit("FEHLER: generator_functions: function generateMap() #1");
 }
 return;
}
// ------------------------------------------------------------------------------------------------------------------------------------------------------
// CREATE STAR
function createStarAndPlanets($x,$y,$mapID)
{
 include("includes/dbConnect.php");

 // query random model
 $q1="SELECT * FROM star_model ORDER BY RAND() LIMIT 1";
 if($e1=$DB->query($q1))
 {
  $modelA=$e1->fetch(PDO::FETCH_ASSOC);

  // get model diamater
  $modelDiameterParams = explode(";", $modelA['model_diameter_range']);
  $diamMin = $modelDiameterParams[0];
  $diamMax = $modelDiameterParams[1];
  $diam = mt_rand($diamMin,$diamMax);

  // get model heat
  $modelHeatParams = explode(";", $modelA['model_heat_range']);
  $heatMin = $modelHeatParams[0];
  $heatMax = $modelHeatParams[1];
  $heat = mt_rand($heatMin,$heatMax);

  // get gravity
  $gFactor = getSetting(4);
  $gravity = round($diam / $gFactor);

  // get IMG
  $img = genStarIMG();

  // get name
  $name = genStarName();

  // get modelID
  $modelID = $modelA['model_id'];

  // insert query star
  $q2="INSERT INTO `star_generated` (`starGen_name`,`starGen_diameter`,`starGen_heat`,`starGen_gravity`,`starGen_map`,`starGen_model`,`starGen_image`) VALUES (?,?,?,?,?,?,?)";
  $e2=$DB->prepare($q2);
  if($e2->execute(array($name,$diam,$heat,$gravity,$mapID,$modelID,$img)))
  {
//   $id = $e2->lastInsertId(); // !! FUNKTIONIERT  N I C H T !!
   $q4="SELECT MAX(`starGen_id`) FROM `star_generated` WHERE (`starGen_diameter`=?) AND (`starGen_heat`=?) AND (`starGen_gravity`=?) AND (`starGen_map`=?) AND (`starGen_model`=?)";
   $e4=$DB->prepare($q4);
   $e4->execute(array($diam,$heat,$gravity,$mapID,$modelID));
   list($id)=$e4->fetch(PDO::FETCH_NUM);
   return $id;
  }
  else
  {
exit("FEHLER: generator_functions: function createStarAndPlanets() #2");
  }
 }
 else
 {
exit("FEHLER: generator_functions: function createStarAndPlanets() #1");
 }
}
// ------------------------------------------------------------------------------------------------------------------------------------------------------
// GET GENERATED MAP ID BY LOC
function getGeneratedMapID($x,$y)
{
 include("includes/dbConnect.php");

 $q1="SELECT * FROM `map_generated` WHERE (`mapGen_x`=$x) AND (`mapGen_y`=$y)";
 if($e1=$DB->query($q1))
 {
  $z1=$e1->fetch(PDO::FETCH_ASSOC);
  return($z1['mapGen_id']);
 }
 else
 {
exit("FEHLER: generator_functions: function getGeneratedMapID() #1");
 }
}
// ------------------------------------------------------------------------------------------------------------------------------------------------------
// GENERATE RANDOM STAR NAME
function genStarName()
{
 include "includes/star_names_list.php";

 // randomise and pick name from array
 $randomIndex = array_rand($starNamesArray);
 $name = $starNamesArray[$randomIndex];

 // return single name string
 return $name;
}
// ------------------------------------------------------------------------------------------------------------------------------------------------------
// GENERATE RANDOM STAR IMAGE
function genStarIMG()
{
 include("includes/dbConnect.php");
 return("star_model_".mt_rand(1,getSetting(5)));
}
// ------------------------------------------------------------------------------------------------------------------------------------------------------
// CALCULATE ODDS TO GENERATE STAR
function odds_star()
{
 $percent = getSetting(3);
 $negativeOdds = 100 - $percent;
 $counterYES = 0;
 $counterNO = 0;
 $answerArray = array();

 // loop insert YES
 while ($counterYES <= $percent)
 {
  $counterYES++;
  array_push($answerArray, "YES");
 }

 // loop insert NO
 while ($counterNO <= $negativeOdds)
 {
  $counterNO++;
  array_push($answerArray, "NO");
 }

 // define final random answer from percentage array
 $randomIndex = array_rand($answerArray);
 $answer = $answerArray[$randomIndex];

 // format answer to boolean
 $out = ($answer == "YES") ? TRUE:FALSE;

 // return boolean
 return $out;
}
// ------------------------------------------------------------------------------------------------------------------------------------------------------
// GENERATE MAP TILE IMAGE
function genMapTileIMG()
{
 include("includes/dbConnect.php");
 return("Maptile_".mt_rand(1,getSetting(2)));
}
// ------------------------------------------------------------------------------------------------------------------------------------------------------
// MOVE TO TILE
function moveTo($x,$y)
{
 include("includes/dbConnect.php");

 $shipID = getActiveMothership();

 $q1="UPDATE `unit_table` SET `unit_posX`=?, `unit_posY`=? WHERE `unit_id`=?";
 $e1=$DB->prepare($q1);
 if(!$e1->execute(array($x,$y,$shipID)))
 {
exit("FEHLER: generator_functions: function moveTo()");
 }
}
// ------------------------------------------------------------------------------------------------------------------------------------------------------
?>
