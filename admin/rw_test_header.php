<head> 
    <?php 
//session_start(); 
error_reporting(E_ALL);
ini_set('display_errors', '1');
include("database_class.php");	//Include MySQL database class
include("mysql_sessions.php");	//Include PHP MySQL sessions
$session = new Session();	//Start a new PHP MySQL session

function random_str($length = 32)
{
    return bin2hex(openssl_random_pseudo_bytes($length / 2));
}
 
$length = 32;
$rand_str = random_str($length);

 $currentPage = basename($_SERVER['PHP_SELF']);
    
    if($currentPage != "rw_test_login.php") {
        if(!isset($_COOKIE['storelocatorsessionid'])){
            echo 'cookie is set';die;
        }
    }

echo "Here are your details <pre>";print_r($_SESSION);echo "</pre>";
?>
    <title>Common Page</title>    
</head>