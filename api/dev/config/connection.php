<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED ^ E_WARNING);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header('Content-Type: application/json; charset=UTF-8');

$_HOST_NAME = "localhost";  
 $_DB_USERNAME ="root";
 $_DB_PASSWORD ="";
$conn = mysqli_connect($_HOST_NAME, $_DB_USERNAME, $_DB_PASSWORD)or die("Unable to connect to MySQLi");
mysqli_select_db($conn,"loanAppDb");
/////////////////////////////////////////////////////////////////
?>

<?php require_once 'function.php'; ?>
<?php require_once 'constant.php'; ?>