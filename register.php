<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include "includes/db.php";
$username = $fname = $lname = $userage = $useremail = $password = $petname = $pettype = $petbreed = $petage = $petdescription = "";
$usernameErr = $fnameErr = $lnameErr = $userageErr = $emailErr = $passErr = $petnameErr = $pettypeErr = $petbreedErr = $petageErr = $petdescriptionErr = $img1Err = $img2Err = "";

$registerDone = "";

if(isset($_POST['btn-register'])){
	if(trim($_POST['username']) == "") //trim function removes spaces from left and right
		$usernameErr ="Enter username";
	else{
		$username = strtolower(trim($_POST['username'])); //strtolower function converts string to lowercase;;

		$sqlUsername = "select * from user where username ='$username'";
		$result = $con->query($sqlUsername);
		if($result->num_rows >0)
			$usernameErr = "Username Exists";
	}


	if(trim($_POST['User_Email']) == "") //trim function removes spaces from left and right
		$emailErr ="Enter Email Address"; //Why can it not be $useremailErr?????
	else{
		$useremail = strtolower(trim($_POST['User_Email'])); //strtolower function converts string to lowercase;

		$sqlUseremail = "select * from user where User_Email='$useremail'";
		$resultUseremail = $con->query($sqlUseremail);
		if($resultUseremail->num_rows >0)
			$emailErr = "Email Exists";
	}

	if(trim($_POST['First_Name'])=="")
		$fnameErr = "Enter First Name";
	else
		$fname = ucfirst(strtolower(trim($_POST["First_Name"]))); //ucfirst is going to convert first letter of the string to uppercase

	if(trim($_POST['Last_Name'])=="")
		$lnameErr = "Enter Last Name";
	else
		$lname = ucfirst(strtolower(trim($_POST['Last_Name']))); //ucfirst is going to convert first letter of the string to uppercase

	if(trim($_POST['User_Age'])=="")
		$userageErr = "Enter Your Age";
	else
		$userage = ucfirst(strtolower(trim($_POST['User_Age'])));

	if(trim($_POST['User_Email'])=="")
		$emailErr = "Enter Email";
	else
		$useremail = ucfirst(strtolower(trim($_POST['User_Email'])));

	if(trim($_POST['Password'])=="")
		$passErr = "Enter Password";
	else {
		$password = trim($_POST['Password']); 
		$passwordEncrypt = md5($password);//md5 is used to encrypt the password

	}


	if(trim($_POST['Pet_Name']) == "") //trim function removes spaces from left and right
		$petnameErr ="Enter Your Pet's Name"; 
	else{
		$petname = ucfirst(strtolower(trim($_POST['Pet_Name']))); //strtolower function converts string to lowercase;

	if(trim($_POST['Pet_Type'])=="")
		$pettypeErr = "What Animal Is Your Pet?";
	else
		$pettype = $_POST['Pet_Type'];

	if(trim($_POST['Pet_Breed'])=="") // added an extra ) at the end of this line
		$petbreedErr = "Enter The Type Of Your Pet";
	else
		$petbreed = ucfirst(strtolower(trim($_POST['Pet_Breed']))); //there was an extra ( after the ucfirst, so I deleted that

	if(trim($_POST['Pet_Age'])=="")
		$petageErr = "Enter Your Pet's Age";
	else
		$petage = ucfirst(strtolower(trim($_POST['Pet_Age'])));

	if(trim($_POST['Pet_Description'])=="")
		$petdescriptionErr = "Describe Your Pet";
	else
		$petdescription = ucfirst(strtolower(trim($_POST['Pet_Description'])));
	}

	if(getimagesize($_FILES['Pet_Picture']['tmp_name']) !== false){
		$fileLoc = $_FILES['Pet_Picture']['tmp_name'];
		$img1Content = addslashes(file_get_contents($fileLoc)); // file_get_contents gets the contents of the image to be uploaded to the database
	}
	else
		$img1Err = "Upload a Picture of Your Pet";

	if(getimagesize($_FILES['Pet_Header']['tmp_name']) !== false){
		$fileLoc = $_FILES['Pet_Header']['tmp_name'];
		$img2Content = addslashes(file_get_contents($fileLoc)); // file_get_contents gets the contents of the image to be uploaded to the database
	}
	else
		$img2Err = "Upload Header Image";

	if($usernameErr=="" && $fnameErr=="" && $lnameErr=="" && $userageErr=="" && $emailErr=="" && $passErr=="" && $petnameErr=="" && $pettypeErr=="" && $petbreedErr=="" && $petageErr=="" && $petdescriptionErr=="" && $img1Err=="" && $img2Err==""){
		$sql1 = "insert into user(username, First_Name, Last_Name, User_Age, User_Email, Password) values ('$username','$fname','$lname','$userage','$useremail','$passwordEncrypt')";


		$sql2 = "insert into pet(Owner_Username, Pet_Name, Pet_Type, Pet_Breed, Pet_Age, Pet_Description, Pet_Picture, Pet_Header) values ('$username', '$petname','$pettype','$petbreed','$petage','$petdescription','$img1Content','$img2Content')";


		if($con->query($sql1) === TRUE && $con->query($sql2) === TRUE ){
			$registerDone = "New User and Pet Added Successfully";
			$username=$fname=$lname=$userage=$useremail=$password=$petname=$pettype=$petbreed=$petage=$petdescription="";

		}
	
		else{
			echo "Error".$con->error;

		}
	}
}

?>
<!DOCTYPE html>
<html>
	<head>
		<title> Register to Hello Pets </title>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link href="https://fonts.googleapis.com/css?family=Lobster|Raleway|Montserrat" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
		<link rel="stylesheet" type="text/css" href="css/registrationstyle.css" />
		<style>
			.body{
				background-image: url(image/cat-background.jpg);
				background-repeat: no-repeat;
				background-attachment: fixed;
				background-position: center;
				color: white;
			}

			.container{
				border-radius: 15px;
			}

			.form-control{
				border-radius: 15px;
			}

			label, .submit-button{
				margin-top: 1em;
			}

			span.error{
				color: rgba(241, 169, 160, 1);
				font-style:italic;
			}
		</style>
	</head>
	<body style="background-image: url(image/cat-background.jpg); background-repeat: no-repeat; background-attachment: fixed; background-position: center; color: white;">
		<header style="background-color:rgba(00, 00, 00, .65);">
			<h1 class="text-center"> <a href="login.php" style="color: #c5eff7;"> Hello Pets </a></h1>
		</header>

		<div class="container-fluid" style="background-color:rgba(00, 00, 00, 0.65); border-radius: 15px; margin: 25px;">
			<div section ="registrationpage">   
				<div class="row">
						<h2 class="text-center"> Registration </h2>
						<p class="text-center"> Please fill out the form below to create a Hello Pets account! 😸 </p>
				</div>
			</div>

		<div class="ownerinfo">
			<div class="col-sm-6">
				<p class="text-success"> <?php echo $registerDone ?></p>
				<form method="post" action="register.php" enctype="multipart/form-data"> <!-- enctype is needed when submitting images using the form -->

					<label>Username </label>&nbsp;<span class="error"><?php echo $usernameErr ?></span>
					<input type="text" maxlength="20" placeholder="Enter Username" name="username" class="form-control" value="<?php echo $username ?>" />

					<label>First Name </label>&nbsp;<span class="error"><?php echo $fnameErr ?></span>
					<input type="text" maxlength="20" placeholder="Enter First Name" name="First_Name" class="form-control" value="<?php echo $fname ?>" />

					<label>Last Name </label>&nbsp;<span class="error"><?php echo $lnameErr ?></span>
					<input type="text" maxlength="20" placeholder="Enter Last Name" name="Last_Name" class="form-control" value="<?php echo $lname ?>" />

					<label>Your Age </label>&nbsp;<span class="error"><?php echo $userageErr ?></span>
					<input type="text" maxlength="3" placeholder="Enter Your Age" name="User_Age" class="form-control" value="<?php echo $userage ?>" />

					<label>Email Address </label>&nbsp;<span class="error"><?php echo $emailErr ?></span>
					<input type="text" maxlength="100" placeholder="Enter Email Address" name="User_Email" class="form-control" value="<?php echo $useremail ?>" />

					<label>Password </label>&nbsp;<span class="error"><?php echo $passErr ?></span>
					<input type="password" placeholder="Enter Password" name="Password" class="form-control" value="<?php echo $password ?>" />

			</div>
		</div>  <!--closing for div class ownerinfo-->

		<div class = "petinfo">
			<div class="col-sm-6">
				<p class="text-success"> <?php echo $registerDone ?></p>
				<form method="post" action="register.php" enctype="multipart/form-data"> <!-- enctype is needed when submitting images using the form -->

					<label>Pet Name </label>&nbsp;<span class="error"><?php echo $petnameErr ?></span>
					<input type="text" maxlength="20" placeholder="Enter Pet Name" name="Pet_Name" class="form-control" value="<?php echo $petname ?>" />

					<label>Pet Age </label>&nbsp;<span class="error"><?php echo $petageErr ?></span>
					<input type="text" placeholder="Enter Pet Age" name="Pet_Age" maxlength="3" class="form-control" value="<?php echo $petage ?>" />

					<label>Pet Type </label>&nbsp;<span class="error"><?php echo $pettypeErr ?></span>
					<select name="Pet_Type" class="form-control">
					<option value="No Pet Type Options Selected">[Choose the Pet Type]</option>
					<option value="Dog">Dog</option>
					<option value="Cat">Cat</option>
					<option value="Bird">Bird</option>
					<option value="Rabbit">Rabbit</option>
					<option value="Rodent">Rodent</option>
					<option value="Fish">Fish</option>
					<option value="Insect">Insect</option>
					<option value="Amphibian">Amphibian</option>
					</select>

					<label>Pet Breed </label>&nbsp;<span class="error"><?php echo $petbreedErr ?></span>
					<input type="text" placeholder="Enter Pet Breed" name="Pet_Breed" maxlength="20" class="form-control" value="<?php echo $petbreed ?>" />

					<label>Pet Description </label>&nbsp;<span class="error"><?php echo $petdescriptionErr ?></span>
					<textarea style="height:150px;" placeholder="Enter Pet Description" maxlength="1000" name="Pet_Description" class="form-control" value="<?php echo $petdescription ?>" ></textarea>

					<label> Upload a Picture of Your Pet! 🐶</label>&nbsp;<span class="error">
					<?php echo $img1Err ?></span>
					<input type="file" name="Pet_Picture" />

					<label> Upload Your Header Image</label>&nbsp;<span class="error">
					<?php echo $img2Err ?></span>
					<input type="file" name="Pet_Header" />
			</div>
		</div> <?php//closing div for pet info ?>

				<input type="submit" name="btn-register" class="btn btn-success form-control submit-button" />

				<br><br>Already Have An Account?<a href="login.php" style="color: #c5eff7;"> Login Here </a>
				<br><br>

					</form>
				</div>
			</div>
		</div>
	</body>
</html>