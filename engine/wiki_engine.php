<?php
// Changed to initial 'ship' 2016-12-16 by Karsten Maske

include "functions/wiki_functions.php";

if(!isset($_GET['topic']))
{
 $_GET['topic']='ship';
}

switch($_GET['topic'])
{
 case 'ship':
  include "views/wiki/ship.php"; // setzt $wikiout
  break;

 default:
  $wikiout="<br><br>404 NOT FOUND";
}
?>
