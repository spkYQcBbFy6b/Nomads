<?php
// Changed to PDO 2018-12-15 by Karsten Maske
// Changed Image-Location to /Nomads/.... 2018-12-15 by Karsten Maske

// GET ALL AVAILABLE SHIPS > TABLE
function generateShipsTable()
{
 include("includes/dbConnect.php");
 $table = null;

 $q1="SELECT * FROM `unit_model_table` WHERE (`model_active`=1) AND (`model_type`=?)";
 $e1=$DB->prepare($q1);
 if(!$e1->execute(array('ship')))
 {
exit("FEHLER: wiki_functions: function generateShipsTable()");
 }

 $shipColsNum=$e1->columnCount();

 // string before table
 $table .= "<h3>Additional Notes:</h3>";
 $table .= "<span class='wikiHeaderString'>";
 $table .= getString("wiki_ships_header");
 $table .= "</span>";

 // start table
 $table .= "<table class='wikiTable'>";

 // give title to table
 $table .= "
   <tr>
     <td class='wikiTableHeader' colspan='".$shipColsNum."'>
       ALL ACTIVE SHIPS
       <hr>
     </td>
   </tr>
 ";

 // give title to columns
 $table .= "
   <tr>
     <th class='wikiHeader'>
       Image
     </th>
     <th class='wikiHeader'>
       ID
     </th>
     <th class='wikiHeader'>
       Name
     </th>
     <th class='wikiHeader'>
       Hit Points
     </th>
     <th class='wikiHeader'>
       Attack
     </th>
     <th class='wikiHeader'>
       Cargo
     </th>
     <th class='wikiHeader'>
       Speed
     </th>
     <th class='wikiHeader'>
       Workers
     </th>
   </tr>
 ";

 // loop for rows
 WHILE($row = $e1->fetch(PDO::FETCH_ASSOC))
 {
  // get info
  $info = getShipInfo($row['model_id']);

  // rows
  $table .= "
    <tr>
      <td class='wikiTd' style='width:80px;'>
        <div class='popout' onClick='popOut(".$row['model_id'].")'>
          <img src='/Nomads/img/ships/".$row['model_id'].".gif' alt='".$row['model_name']." image' height='75px'/>
          <span class='popuptext' id='".$row['model_id']."'><h3>".$row['model_name']."</h3><hr>".$info."</span>
        </div>
      </td>
      <td class='wikiTd'>
        #".$row['model_id']."
      </td>
      <td class='wikiTd'>
        ".$row['model_name']."
      </td>
      <td class='wikiTd'>
        ".$row['model_hitpoints']."
      </td>
      <td class='wikiTd'>
        ".$row['model_attack']."
      </td>
      <td class='wikiTd'>
        ".$row['model_cargo']."
      </td>
      <td class='wikiTd'>
        ".$row['model_speed']."
      </td>
      <td class='wikiTd'>
        ".$row['model_require_workers']."
      </td>
    </tr>
  ";
 } // ENDE WHILE($row = $e1->fetch(PDO::FETCH_ASSOC))
 return $table;
}
// ---------------------------------------------------------------------------------------------------------------------------------
// GENERATE SHIP DESCRITPION
function getShipInfo($modelID)
{
 include("includes/dbConnect.php");

 $q1="SELECT `model_id`,`model_description` FROM `unit_model_table` WHERE `model_id`=?";
 $e1=$DB->prepare($q1);
 if($e1->execute(array($modelID)))
 {
  $z1=$e1->fetch(PDO::FETCH_ASSOC);
  $out = getString($z1['model_description']);
  return $out;
 }
 else
 {
exit("FEHLER: wiki_functions: function getShipInfo()");
 }
}
// ---------------------------------------------------------------------------------------------------------------------------------
?>