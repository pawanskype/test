<!DOCTYPE html>
<html>
    <?php
        require_once('rw_test_header.php');
    ?>
<body>
    <?php
    if(isset($_POST['loginsbmit'])) {
        $uid = $_POST['userid'];
        $pw = $_POST['password'];
        if($uid == 'ravi' and $pw == 'ravi90') {    
            //session_start();
            $session = new Session();
            //$_SESSION['sid']=session_id();
            $session->_write($rand_str,'userData');
            setcookie('storelocatorsessionid',$rand_str,time()+3600,'/');
            header('location:rw_test_dashboard.php');            
        }else {
            echo "Username password not matched";
        }
    }
    ?> 
    <form method="post" action="">
        User Id: <input type="text" name="userid"><br>
        Password: <input type="password" name="password"><br>
        <input type="submit" name="loginsbmit" value="Login">
    </form> 
</body>
</html>