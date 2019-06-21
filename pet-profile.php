<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);


if(isset($_SESSION['username'])){

  include "includes/db.php";
  include "includes/class.user.php";
  $userob = new user();
  $petob = new pet();

  $username="";
  if(isset($_GET['username']))
    $username = trim($_GET['username']);
  else
    $username = $_SESSION['username'];

  $row = $userob->getUserDetails($username, $con);
  $mypet = $petob->getPetDetails($username, $con);


  $title = $mypet['Pet_Name']."'s Profile";
  include "includes/pet-profile-header.php";


?>



<!--<?php
//$image_show = $mypet['Pet_Picture'];
//echo '<body background=data:image;base64,'.base64_encode($image_show).'">';
?>
-->

<body>
	<div class="container">
		<header>

			<?php
            //$petheader = $mypet['Pet_Header'];
            $uri = 'data:image/png;base64,'.base64_encode($mypet['Pet_Header']);
            ?>

			<section class="row profile-header" style="background-image:url('<?php echo $uri ?>')">
				<a href="bulletin.php" class="btn btn-primary dash" type="submit"><span class="glyphicon glyphicon-menu-left"></span>&nbsp;Dashboard</a>

			</section>
		</header>

		<section class="profile-settings">


					<?php
             	 	$image_show = $mypet['Pet_Picture'];
             	 	echo '<img class="puppyface img-circle img-responsive" src="data:image;base64,'.base64_encode($image_show).'" />';
           		 	?>

					<div class="clearfix"></div>
						<div class="details">
							<h1>@<?php echo $row['username'] ?></h1>
							<h2><?php echo $mypet['Pet_Name'] ?>, <?php echo $mypet['Pet_Age'] ?> Yr Old</h2>
							<h3><?php echo $mypet['Pet_Breed']?>,  <?php echo $mypet['Pet_Type'] ?></h3>
							<h4>Owner: <?php echo $row['First_Name']." ".$row['Last_Name'] ?>, <?php echo $row['User_Age']?> Yr Old</h4>
							<div class="clearfix"></div>
						</div>
				</section>

		<section class="description">
			<div class="pet-description row">
				<p><?php echo $mypet['Pet_Description'] ?> </p>
			</div>
		</section>

		<footer class="row">
			<div class="bottom">
				<p>© Hello Pets, 2018</p>
				<p><a href="#">Contact Us</a></p>
			</div>
		</footer>

	</div>
</body>
</html>
<?php
}

else{
  header("Location:login.php");
}
?>
