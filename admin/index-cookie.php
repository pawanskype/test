<?php 	  		
include "header.php";
// echo "checking Database connection <pre>";print_r($con);echo "<pre>";
// $session = new Session();
// die("Debugging this page  ajdjd");

?>
<?php
// if(isset($_SESSION['data'])) {
// 	header('location:'.$adminhome);	
// }
if(isset($_POST['login'])) {
	$email = (isset($_POST['email']) && !empty($_POST['email'])) ?  mysqli_real_escape_string($con, $_POST['email']) : '' ;

	$password = (isset($_POST['password']) && !empty($_POST['password'])) ?  mysqli_real_escape_string($con, $_POST['password']) : '' ;

	$rem = (isset($_POST['remember']) && !empty($_POST['remember'])) ?  mysqli_real_escape_string($con, $_POST['remember']) : '' ;
	
	if($email!='' && $password!='') {
		$sql = mysqli_query($con, "SELECT * FROM users WHERE (username = '$email' OR email = '$email') AND (password = '".md5($password)."')");
		if(mysqli_num_rows($sql)>0) {
			$user_data = mysqli_fetch_array($sql);
			if($user_data['status']==0) {	
				if($rem!='') { 	
					setcookie('email', $email,time() + 7*24*60*60, "/");
					setcookie('password', $password,time() + 7*24*60*60, "/");					
				}
				else{					
					// setcookie('email', 'gone',time() - 7*24*60*60, "/");
					// setcookie('password', 'gone',time() - 7*24*60*60, "/");
					setcookie("email", "", time() - 3600);
					setcookie("password", "", time() - 3600);
				}	
			

     		//Start a new PHP MySQL session
			$phpsessionID = $rand_str;
       setcookie('storelocatorsessionid',$phpsessionID,time()+86400, "/");

				// $_SESSION['login'] = true;
				// $_SESSION['data'] = $user_data;	
				   $user_data['creationTime'] = time();
       		       $s_save_data =  serialize($user_data);
					$session->_write($phpsessionID,$s_save_data);
					

					// print_r($session->_read($phpsessionID));

					// die("Login Successfull data is saved");
       
							
				header('Location:locations.php?adminid=50');
			}else {		
				$_SESSION['msg_error'] = "Your account has been temporary suspended. Please contact administrator";
				
			}
		}else {			
			$_SESSION['msg_error'] = "User does not exits.";
			
		}
	}else{
		$_SESSION['msg_error'] = "Both fields are required";
	}
}
?>
<body class="index-body" print_r($_COOKIE);die();
class="raw">
	<div class="container">
		<div class="form-container">
			<div class="form-container-in jim">			
				<div class="logo"><a href="<?php echo $domainurl; ?>"><img src="<?php echo $adminurl; ?>/defaultimages/logo-restoration.png" /></a></div>
				<div style="display:none" id="my-session-data"><?php print_r($_SESSION); ?></div>				
				<?php if(isset($_SESSION['msg_error'])) { ?>
				<div class="error-msg login-message">
					<div class = "alert alert-danger alert-dismissable">
						<button type = "button" class = "close" data-dismiss = "alert" aria-hidden = "true">&times;</button>
						<?php echo $_SESSION['msg_error']; unset($_SESSION['msg_error']); ?>
					</div>
					<?php } elseif(isset($_SESSION['msg_succ'])) { ?>
					<div class = "alert alert-success alert-dismissable">
						<button type = "button" class = "close" data-dismiss = "alert" aria-hidden = "true">&times;</button>
					<?php echo $_SESSION['msg_succ']; unset($_SESSION['msg_succ']); ?>
					</div>
				</div>
				<?php } ?>
				<form class="index-form" id="login" role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
					<div class="form-group">
						<label class="control-label" for="email">Username or email address</label>
						<input type="text" class="form-control" id="email" name="email" placeholder=" " value="<?php if(isset($_COOKIE['email'])) { echo $_COOKIE['email']; } else { echo ""; } ?>">
					</div>
					<div class="form-group">
						<label class="control-label" for="pwd">Password</label>
						<input type="password" class="form-control" id="pwd" name="password" placeholder="" value="<?php if(isset($_COOKIE['password'])) { echo $_COOKIE['password']; } else { echo ""; } ?>">
					</div>
					<div class="form-group">
						<!--<div class="checkbox">
							<label><input type="checkbox" class="remember-input" name="remember" value="1" <?php if(isset($_COOKIE['email']) && isset($_COOKIE['password'])){ echo "checked"; } else { echo ""; } ?>> Remember</label>
						</div>-->
						<button type="submit" name="login" class="btn btn-login">Login</button>
					</div>
				</form>
				<div class="clearfix"></div>
				<!--<div class="fpass"><a href="javascript:void(0);" data-toggle="modal" data-target="#myModal">Forgot Password?</a></div>-->
			</div>
		</div>
	</div>
	<div class="modal fade" id="myModal" role="dialog">
		<div class="modal-dialog">   
                    <form class="forget-form" action="" method="post" id="forget1" >
					<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Forgot Password</h4>
				</div>
				<div class="forget-container">
					<div class="modal-body">
						<div class="logo"><img src="<?php echo $adminurl; ?>/defaultimages/logo-restoration.png" /></div>
						<div id="messege_forget" style="color:red; padding: 10px 0 0 0; margin-top: 10px;"></div>
						
							<label for="email">Please Enter Your Email</label>
							<input type="text" class="form-control email" name="email" id="email-forget" placeholder="Please Enter Your Email">
						
					</div>
				</div>
				<div class="modal-footer">
					<!--input type="submit" class="btn btn-success" id="submit" value="Send"
 onclick="ga('send', 'event', {
   eventCategory: 'Outbound Link',
  'eventAction': 'click',
 'eventLabel':'trackers'
});"/-->
                                        <input type="submit" class="btn btn-success forget_submit" id="submit" value="Send">
					<a href="#"  class="btn" data-dismiss="modal">Close</a>
                                        </form>
				</div>
			</div>  
		</div>
	</div>
<script>
$(function() {

	$('#forget1').on("submit", function(e){
		e.preventDefault();
		   $.ajax({
		   type: 'POST',
                   url: 'forget.php',
                   data :$('form').serialize(),
                   success: function(data){
                    $('#messege_forget').html(data);
                    $("#email-forget").val('');
                    setTimeout(function(){
                    $(".modal").removeClass("in");
                    $('#messege_forget').html("");
                    $(".modal").fadeOut(100);
                    $(".modal-backdrop").remove();
                    },6000);
	}
 });
});

$('a[data-target="#myModal"]').click(function(){
$('#forget1')[0].reset();	
});
});

</script>
<?php include 'footer.php'; 

?>