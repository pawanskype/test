<!DOCTYPE html>
<html>
    <?php
    require_once('rw_test_header.php');
    ?>
<body>
    Click to <a href="rw_test_login.php" target="_blank">Login</a>
    <br>
    <?php 
    if(isset($_SESSION['sid']) && !empty($_SESSION['sid'])) {
    ?>
    Click to <a href="rw_test_login.php" target="_blank">Logout</a>
    <?php 
    }?>    
</body>
</html>