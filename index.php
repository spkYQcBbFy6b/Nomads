<?php
// Changed to PDO 2018-12-15 by Karsten Maske

session_start();
date_default_timezone_set('Europe/Berlin');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "engine/redirect.php";
include "common/common_functions.php";
//include "includes/dbConfig.php";
include "includes/dbConnect.php";
?>
<html>
<?php include "includes/head.php";?>

<body>
  <div id="topper">
<?php
//include ("includes/topper.php");
?>
  </div>
<?php
if(!isset($_GET['view']))
{
 $_GET['view']='register';
 $_GET['view']='login';
}
    $view = $_GET['view'];
    switch($view){
      case 'privacy':
        include "views/privacy.php";
        break;
      case 'tos':
        include "views/tos.php";
        break;
      case 'activation':
        include "views/activation.php";
        break;
      case 'splash':
        include "views/splash.php";
        break;
      case 'login':
        include "views/login.php";
        break;
      case 'register':
        include "views/register.php";
        break;
      case 'welcome':
        include "views/welcome.php";
        break;
      case 'recoverPassword':
        include "views/recoverPassword.php";
        break;
      default:
        print "<br><br>404 NOT FOUND";
    }
?>
</body>
<?php include "includes/footer.php"; ?>
</html>