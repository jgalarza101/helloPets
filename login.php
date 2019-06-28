<?php



session_start(); //this needs to exist when using $_SESSION

if(isset($_SESSION['username']))
	header("Location: bulletin.php");//header function is used to redirect to other php files

include "includes/db.php";

$username = $password = "";
$usernameErr = $passErr = "";
$loginErr = "";

if(isset($_POST['btn-login'])){
	if(trim($_POST['Username'])=="")
		$usernameErr = "enter username";
	else
		$username = strtolower(trim($_POST['Username']));


	if(trim($_POST['Password'])=="")
		$passErr = "enter password";
	else {
		$password = trim($_POST['Password']);
		$passwordEncrypt = md5($password);
	}

	if($usernameErr == "" && $passErr==""){
		$sql = "select * from user where Username='$username' and Password='$passwordEncrypt'";
		$result = $con->query($sql);

		if($result->num_rows > 0){
			$_SESSION['username'] = $username;
			header("Location: bulletin.php");
		}
		else{
			$loginErr = "Error logging in, please try again";
		}
	}

}


$title="Login for your next Playdate!";
include "includes/header.php";

?>


<body class="body" style="background-image: url(image/petbackground.jpg); background-repeat: no-repeat; background-attachment: fixed; background-position: center;">
	<div class="container container-login" style="margin-bottom: 20px;">

		<div class="boxed img-responsive">
		<header class="text-center">
			<h1 style="background-color:rgba(49, 72, 84, .8); ">Hello Pets</h1>
			<img src="image/Login1.png">
			<h2>Come Play With Me!</h2>
		</header>
			  <div class="userinput img-responsive">
			  	<form method="post" action="login.php">
					<p class="text-danger"> <?php echo $loginErr ?></p>
				    <label for="Username"><b>Username</b></label>&nbsp;<span class="text-danger"><?php echo $usernameErr ?></span>
				    <input class="ip2" type="text" placeholder="Enter Username" name="Username" value="<?php echo $username ?>" required>

				    <label for="Password"><b>Password</b></label>&nbsp;<span class="text-danger"><?php echo $passErr ?></span>
				    <input class="ip2" type="password" placeholder="Enter Password" name="Password" value="<?php echo $password ?>" required>

				    <!--<button name="btn-login" type="submit">Login</button>-->

				    <input type="submit" name="btn-login" class="button"/>
				    </form>
				    <a href="register.php"><button type="register" class="btn-success">Register Here</button></a>

				    <label>

				    <input type="checkbox" checked="checked" name="remember"/> Remember me
				    </label>
				  </div>

				  <div class="forgotpassword">
				  <span class="psw">Forgot<a href="#"> Password?</a></span>
			  		</div>


		</div>
	</div>
</body>
</html>
