<?php
// Changed Location to /Nomads/.... 2018-12-15 by Karsten Maske

// home page redirects
if (($_SERVER['REQUEST_URI'] == "/") OR ($_SERVER['REQUEST_URI'] == "/Nomads/"))
{
 header('Location: /Nomads/?view=splash');
 return;
}
// -----------------------------------------------------------------------------
?>
