<?php
// Changed to PDO 2018-12-15 by Karsten Maske
// Changed Image-Location to /Nomads/.... 2018-12-15 by Karsten Maske

// GENERATE BUY TABLE
function genBuyTable()
{
 include("includes/dbConnect.php");
 $table = null;

 // query
 $q1="SELECT * FROM `galactic_market_buy_table` ORDER BY `listing_table`, `listing_currency`, `listing_value`";
 if(!$e1=$DB->query($q1))
 {
exit("FEHLER: galactic_market_functions: function genBuyTable() #1");
 }

 $itemsFieldNum=$e1->columnCount();

 // design table start
 $table .= "<table class='wikiTable'>";

 // give title to table
 $table .= "
   <tr>
     <td class='wikiTableHeader' colspan='".$itemsFieldNum."'>
       ALL ACTIVE LISTINGS
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
       Name
     </th>
     <th class='wikiHeader'>
       Cost
     </th>
     <th class='wikiHeader'>
       Market Limit
     </th>
     <th class='wikiHeader'>
       &nbsp;
     </th>
   </tr>
 ";

 // loop
 WHILE($row=$e1->fetch(PDO::FETCH_ASSOC))
 {
  $existentItemNumber = null;
  $id = $row['listing_model'];
  $db = $row['listing_table'];
  $db .= "_model_table";

  $q2="SELECT * FROM `".$db."` WHERE `model_id`='".$id."'";
  if(!$e2=$DB->query($q2))
  {
exit("FEHLER: galactic_market_functions: function genBuyTable() #2");
  }
  $itemInfo = $e2->fetch(PDO::FETCH_ASSOC);
  $name = $itemInfo['model_name'];
  $info = getString($itemInfo['model_description']);
  $formatedValue = number_format($row['listing_value']);

  // get number of existent items
  switch($row['listing_table'])
  {
   case 'unit':
     $existentItemNumber = getTotalUnitsByID($id);
     break;

   default:
     print "<br><br>" . getString("error_fatal_galactic_market");
     return;
  }

  // format output strings
  $limitsOut = $existentItemNumber. " / " .$row['listing_limit'];

  // paint numbers accordingly
  if ($existentItemNumber < $row['listing_limit'])
  {
   $limitsOut = "<span class='greenText'>" . $limitsOut . "</span>";
  }
  else
  {
   $limitsOut = "<span class='errorOutput'>" . $limitsOut . "</span>";
  }

  // table gen
  $table .= "
    <tr>
      <td class='wikiTd' style='width:80px;'>
        <div class='popout' onClick='popOut(".$row['listing_id'].")'>
          <img src='/Nomads/img/ships/".$row['listing_model'].".gif' alt='Item Image' height='75px'/>
          <span class='popuptext' id='".$row['listing_id']."'><h3>".$name."</h3><hr>".$info."</span>
        </div>
      </td>
      <td class='wikiTd'>
        ".$name."
      </td>
      <td class='wikiTd'>
        ".$formatedValue."&nbsp;".$row['listing_currency']."
      </td>
      <td class='wikiTd'>
        ".$limitsOut."
      </td>
      <td class='wikiTd'>
        ".genBuyButton($row['listing_id'])."
      </td>
    </tr>
  ";
 } // ENDE WHILE
 
 $table .= "</table>";
 return $table;
}
// ------------------------------------------------------------------------------------------------------------------------------------------------------
// GENERATE BUY BUTTONS AFTER VALIDATIONS
function genBuyButton($listingID)
{
 include("includes/dbConnect.php");

 $disabledTag = validateBuy_button($listingID);
 if ($disabledTag == "disabled")
 {
   $buttonName = "Blocked";
   $buttonClass = "button_notok";
 }
 else
 {
   $buttonName = "Buy";
   $buttonClass = "button_ok";
 }
 $out = "
   <form method='POST'>
     <input type='hidden' name='buy' value='".$listingID."'/>
     <input type='submit' value='".$buttonName."' class='".$buttonClass."' ".$disabledTag."/>
   </form>
 ";
 return $out;
}
// ------------------------------------------------------------------------------------------------------------------------------------------------------
// VALIDATE BUY BUTTON ACCORDING TO RESOURCES AND LIMITS FROM GALACTIC MARKET
function validateBuy_button($listingID)
{
 include("includes/dbConnect.php");

 // init checks
 $checkCost = null;
 $checkLimit = null;

 // file
 $uID = getUserID();

 // query item
 $q1="SELECT * FROM `galactic_market_buy_table` WHERE `listing_id`=?";
 $e1=$DB->prepare($q1);
 if(!$e1->execute(array($listingID)))
 {
exit("FEHLER: galactic_market_functions: function validateBuy_button() #1");
 }
 $z1=$e1->fetch(PDO::FETCH_ASSOC);

 // get item data
 $limit = $z1['listing_limit'];
 $cost  = $z1['listing_value'];
 $model = $z1['listing_model'];
 $model_table = $z1['listing_table'] . "_table";
 $currency = $z1['listing_currency'];

 // query user
 $q2="SELECT * FROM `user` WHERE `id`=?";
 $e2=$DB->prepare($q2);
 if(!$e2->execute(array($uID)))
 {
exit("FEHLER: galactic_market_functions: function validateBuy_button() #2");
 }
 $userA=$e2->fetch(PDO::FETCH_ASSOC);

 // query existant items
 $q3="SELECT * FROM `".$model_table."` WHERE (`unit_owner`=?) AND (`unit_model`=?) AND (`unit_destroyed`=0)";
 $e3=$DB->prepare($q3);
 if(!$e3->execute(array($uID,$model)))
 {
exit("FEHLER: galactic_market_functions: function validateBuy_button() #3");
 }
 $existentNum=$e3->rowCount();

 // get user needed data
 $valueHeld = $userA[$currency];

 // compare costs
 $checkCost=($cost <= $valueHeld) ? TRUE:FALSE;

 // compare limit
 $checkLimit=($existentNum < $limit) ? TRUE:FALSE;

 // final validation of checks
 $out = (($checkCost)AND($checkLimit)) ? '':'disabled';
 return $out;
}
// ------------------------------------------------------------------------------------------------------------------------------------------------------
// BUY ITEM
function buyItem($listingID)
{
 // init
 $out = false;

 // includes
 include("includes/dbConnect.php");
 $uID = getUserID();

 // query item
 $q1="SELECT * FROM `galactic_market_buy_table` WHERE `listing_id`=?";
 $e1=$DB->prepare($q1);
 if(!$e1->execute(array($listingID)))
 {
exit("FEHLER: galactic_market_functions: function buyItem() #1");
 }
 $itemA=$e1->fetch(PDO::FETCH_ASSOC);

 // get item data
 $cost = $itemA['listing_value'];
 $currency = $itemA['listing_currency'];

 // query user
 $q2="SELECT * FROM `user` WHERE `id`=?";
 $e2=$DB->prepare($q2);
 if(!$e2->execute(array($uID)))
 {
exit("FEHLER: galactic_market_functions: function buyItem() #2");
 }
 $userA=$e2->fetch(PDO::FETCH_ASSOC);

 // get user needed data
 $valueHeld = $userA[$currency];

 // compare
 if ($cost > $valueHeld)
 {
  // no resources > abort
  return(FALSE);
 }
 else
 {
  // query item model
  $modelID = $itemA['listing_model'];

  $q3="SELECT * FROM `unit_model_table` WHERE `model_id`=?";
  $e3=$DB->prepare($q3);
  if(!$e3->execute(array($modelID)))
  {
exit("FEHLER: galactic_market_functions: function buyItem() #3");
  }
  $itemModelA=$e3->fetch(PDO::FETCH_ASSOC);
  $item_name = $itemModelA['model_name'];

  // enough resources > proceed with charging resources
  $newValueHeld = $valueHeld - $cost;

  $q4="UPDATE `user` SET `".$currency."`=? WHERE `id`=?";
  $e4=$DB->prepare($q4);
  if(!$e4->execute(array($newValueHeld,$uID)))
  {
exit("FEHLER: galactic_market_functions: function buyItem() #4");
  }

  $q5="INSERT INTO `unit_table` (`unit_model`,`unit_owner`,`unit_name`) VALUES (?,?,?)";
  $e5=$DB->prepare($q5);
  if(!$e5->execute(array($modelID,$uID,$item_name)))
  {
exit("FEHLER: galactic_market_functions: function buyItem() #5");
  }

  return(TRUE);
 }
}
// ------------------------------------------------------------------------------------------------------------------------------------------------------
?>