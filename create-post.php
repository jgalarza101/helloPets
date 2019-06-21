<?php

session_start();



error_reporting(E_ALL);
ini_set('display_errors', 1);

if(isset($_SESSION['username'])){

 include "includes/db.php";

 $username="";
  if(isset($_GET['username'])) 
    $username = trim($_GET['username']);
  else
    $username = $_SESSION['username'];

	$title = $eventdesc = $typepref = $capacity = $datetime = $address = $city = $state = $zipcode = "";
	$titleErr = $eventdescErr = $typeprefErr = $capacityErr = $datetimeErr = $addressErr = $cityErr = $stateErr = $zipcodeErr = "";

	$postDone = "";

	if(isset($_POST['btn-submit'])){

		if(trim($_POST['Title'])=="")
			$titleErr = "Please enter a title!";
		else
			$title = ucfirst(strtolower(trim($_POST['Title']))); //ucfirst is going to convert first letter of the string to uppercase

		if(trim($_POST['Description'])=="")
			$eventdescErr = "Please enter a description!";
		else
			$eventdesc = ucfirst(strtolower(trim($_POST['Description']))); //ucfirst is going to convert first letter of the string to uppercase

		if(trim($_POST['Type_Preference'])=="")
			$typeprefErr = "Please enter the kind(s) of furry friends you want to invite!";
		else
			$typepref = $_POST['Type_Preference'];

		if(trim($_POST['Capacity'])=="")
			$capacityErr = "Please enter the amount of invitees to your event!";
		else
			$capacity = ucfirst(strtolower(trim($_POST['Capacity'])));

		if(trim($_POST['DateEvent'])=="")
			$datetimeErr = "Please enter the day of your event!";
		else{
			$input = $_POST['DateEvent'];
			$datetime = date('Y-m-d H:i:s', strtotime($input));
		}
			
		
		if(trim($_POST['Address'])=="")
			$addressErr = "Please enter the address of your event!";
		else
			$address = ucfirst(strtolower(trim($_POST['Address'])));

		if(trim($_POST['City'])=="")
			$cityErr = "Please enter the city of your event!";
		else
			$city = ucfirst(strtolower(trim($_POST['City'])));

		if(trim($_POST['State'])=="")
			$stateErr = "Please enter the state of your event!";
		else
			$state = $_POST['State'];

		if(trim($_POST['Zipcode'])=="")
			$zipcodeErr = "Please enter the zipcode of your event!";
		else
			$zipcode = ucfirst(strtolower(trim($_POST['Zipcode'])));
	

		if($titleErr=="" && $eventdescErr=="" && $typeprefErr=="" && $capacityErr=="" && $datetimeErr == "" && $addressErr=="" && $cityErr=="" && $stateErr =="" && $zipcodeErr==""){
		$sql = "insert into playdate_bulletin(Playdate_ID, Title, Description, Type_Preference, Capacity, DateTime, Address, City, State, Zipcode, Username) values (NULL,'$title','$eventdesc','$typepref','$capacity','$datetime','$address','$city','$state','$zipcode','$username')";


		if($con->query($sql) === TRUE ){
			$postDone = "New Post Added Successfully";
			header("Location: bulletin.php");
			$title = $eventdesc = $typepref = $datetime = $capacity = $address = $city = $state = $zipcode = "";

		}

		else{
			echo "Error".$con->error;
		}

		}
	
	

	}
	
	
}
	
	

?>
<!DOCTYPE html>
<html>
	<head>
		<title> Create a New Post! </title>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
		<link href="https://fonts.googleapis.com/css?family=Lobster|Raleway|Montserrat" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="css/registrationstyle.css" />
		<style>
		label, .submit-button{
			margin-top: 1em;
		}
		span.error{
			color: red;
			font-style:italic;
		}
		</style>
	</head>
	<body>
		<header>
			<h1 class="text-center"> Hello Pets</h1>
		</header>

		<div class="container-fluid">
			<div section ="registrationpage">   
				<div class="row">
						<h2 class="text-center"> Create a new playdate! </h2>
						<p class="text-center"> Reach out to your furry friends and have the best playdate ever! 😸 </p>
				</div>
			</div>

			<div class="col-sm-6">
				<p class="text-success"> <?php echo $postDone ?></p>
				<form method="post" action="create-post.php"> <!-- enctype is needed when submitting images using the form -->

					<label>Title </label>&nbsp;<span class="error"><?php echo $titleErr ?></span>
					<input type="text" maxlength="20" placeholder="Enter Event Title" name="Title" class="form-control" value="<?php echo $title ?>" />

					<label>Description</label>&nbsp;<span class="error"><?php echo $eventdescErr ?></span>
					<textarea placeholder="Write about what will be happening at the playdate" maxlength="1000" name="Description" class="form-control" value="<?php echo $eventdesc ?>" style="height:150px;"></textarea>

					<label>Type Preference </label>&nbsp;<span class="error"><?php echo $typeprefErr ?></span>
					<select name="Type_Preference" class="form-control">
					<option value="No Pet Type Options Selected">[Choose Option Below]</option>
					<option value="Dog">Dog</option>
					<option value="Cat">Cat</option>
					<option value="Bird">Bird</option>
					<option value="Rabbit">Rabbit</option>
					<option value="Rodent">Rodent</option>
					<option value="Fish">Fish</option>
					<option value="Insect">Insect</option>
					<option value="Amphibian">Amphibian</option>
					</select>

					<label>Capacity </label>&nbsp;<span class="error"><?php echo $capacityErr ?></span>
					<input type="text" placeholder="Enter The Maximum Amount of Attendees to Your Playdate" name="Capacity" maxlength="3" class="form-control" value="<?php echo $capacity ?>" />

					<label>Date & Time</label>&nbsp;<span class="error"><?php echo $datetimeErr ?></span>
					<input type="datetime-local" placeholder="Enter Date & Time of Event" name="DateEvent" class="form-control" value="<?php  echo $input ?>" />

					<label>Address </label>&nbsp;<span class="error"><?php echo $addressErr ?></span>
					<input type="text" placeholder="Enter Event Address" name="Address" class="form-control" value="<?php echo $address ?>" />

					<label>City </label>&nbsp;<span class="error"><?php echo $cityErr ?></span>
					<input type="text" placeholder="Enter Event City" name="City" maxlength="20" class="form-control" value="<?php echo $city ?>" />

					<label>State </label>&nbsp;<span class="error"><?php echo $stateErr ?></span>
					<select name="State" class="form-control">
					<option value="No State">[Choose Option Below]</option>
					<option value="AL">Alabama</option>
					<option value="AK">Alaska</option>
					<option value="AZ">Arizona</option>
					<option value="AR">Arkansas</option>
					<option value="CA">California</option>
					<option value="CO">Colorado</option>
					<option value="CT">Connecticut</option>
					<option value="DE">Delaware</option>
					<option value="DC">District Of Columbia</option>
					<option value="FL">Florida</option>
					<option value="GA">Georgia</option>
					<option value="HI">Hawaii</option>
					<option value="ID">Idaho</option>
					<option value="IL">Illinois</option>
					<option value="IN">Indiana</option>
					<option value="IA">Iowa</option>
					<option value="KS">Kansas</option>
					<option value="KY">Kentucky</option>
					<option value="LA">Louisiana</option>
					<option value="ME">Maine</option>
					<option value="MD">Maryland</option>
					<option value="MA">Massachusetts</option>
					<option value="MI">Michigan</option>
					<option value="MN">Minnesota</option>
					<option value="MS">Mississippi</option>
					<option value="MO">Missouri</option>
					<option value="MT">Montana</option>
					<option value="NE">Nebraska</option>
					<option value="NV">Nevada</option>
					<option value="NH">New Hampshire</option>
					<option value="NJ">New Jersey</option>
					<option value="NM">New Mexico</option>
					<option value="NY">New York</option>
					<option value="NC">North Carolina</option>
					<option value="ND">North Dakota</option>
					<option value="OH">Ohio</option>
					<option value="OK">Oklahoma</option>
					<option value="OR">Oregon</option>
					<option value="PA">Pennsylvania</option>
					<option value="RI">Rhode Island</option>
					<option value="SC">South Carolina</option>
					<option value="SD">South Dakota</option>
					<option value="TN">Tennessee</option>
					<option value="TX">Texas</option>
					<option value="UT">Utah</option>
					<option value="VT">Vermont</option>
					<option value="VA">Virginia</option>
					<option value="WA">Washington</option>
					<option value="WV">West Virginia</option>
					<option value="WI">Wisconsin</option>
					<option value="WY">Wyoming</option>
					</select>

					<label>Zip Code </label>&nbsp;<span class="error"><?php echo $zipcodeErr ?></span>
					<input type="text" placeholder="Enter Zip Code" name="Zipcode" maxlength="5" class="form-control" value="<?php echo $zipcode ?>" />

					
			</div>


				<input type="submit" name="btn-submit" class="btn btn-success form-control submit-button" />
				<p></p>

					</form>
				</div>
			</div>
		</div>
	</body>
</html>