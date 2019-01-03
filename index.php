<?php
// Changed to PDO 2018-12-15 by Karsten Maske
// Changes 2019-01-02 by Karsten Maske: added defines due to install script and some changes that came with it.
define('INCLUDESDIR','/includes/');
define('CONNECTDATAFILE','dbConnectData.php');
define('CONNECTDBFILE',INCLUDESDIR.CONNECTDATAFILE);
define('CONNECTFILE',INCLUDESDIR.'dbConnect.php');

session_start();
date_default_timezone_set('Europe/Berlin');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "engine/redirect.php";
include "common/common_functions.php";
//include "includes/dbConfig.php";
include('.'.CONNECTDBFILE); // "includes/dbConnect.php";

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
 if ($_POST['login'] != null)
 {
  include ("functions/login_functions.php");
  if (!loginPlayer())
  {
   $loginOutput = getString("wrong_login");
   return;
  }
  else
  {
//   header("Location: /game_index.php?gameView=overview");
   header("Location: /Nomads/game_index.php?gameView=overview");
   return;
  }
 }
}

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
 $_GET['view']='splash';
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