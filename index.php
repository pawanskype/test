<!DOCTYPE html>
<html>
<head>
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400&display=swap" rel="stylesheet">
</head>
<style>
body, html {
  height: 100%;
  margin: 0;
  font-family: 'Roboto', sans-serif;
}

.bgimg {
  background-image: url('images/welcomebg.jpg');
  height: 100%;
  background-position: center;
  background-size: cover; 
  position: relative;
  color: #000;
  font-size: 25px;
}

.middle {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  text-align: center;
}
.middle h1 {
    font-size: 42px;
    line-height: 42px;
}
a.loginbtn {
    color: #fff;
    font-size: 26px;
    background-image: linear-gradient(to right, #eb5436 , #ef4b23);
    padding: 12px 40px;
    border-radius: 30px;
    box-shadow: 0px 2px 8px #0000007a;
    border: 1px solid #fff;
    text-decoration: none;
    margin-top: 10px;
    display: inline-block;
}
</style>
<body>

<div class="bgimg">
  <div class="middle">
    <img src="images/logo.png" alt="logo">
    <h1>Welcome to Store Locator<br>admin area</h1>
	<a href="/store-locator/admin" class="loginbtn">Click here to login.</a>
  </div>
</div>

</body>
</html>
