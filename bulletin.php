<?php

session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);


if(isset($_SESSION['username'])){

  include "includes/db.php";
  include "includes/class.user.php";
  $userob = new user();
  $petob = new pet();
  $otherpetob = new pet();
  $commentpetob = new pet();
  $bulletinob = new bulletin();

  $username="";
  if(isset($_GET['username']))
    $username = trim($_GET['username']);
  else
    $username = $_SESSION['username'];

  $row = $userob->getUserDetails($username, $con);
  $mypet = $petob->getPetDetails($username, $con);


$title="Find your next Playdate!";
include "includes/bulletin-header.php";

?>

		<header>
			<nav class="navbar navbar-default ">
				<div class="container-fluid">
					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
            <?php
              $image_show = $mypet['Pet_Picture'];
              echo '<img class="pull-left img-circle" style="height: 35px; width: 35px;" alt="HelloPets Logo" src="data:image;base64,'.base64_encode($image_show).'" />';
            ?>
						<a class="navbar-brand" href="#">HelloPets</a>
					</div>

					<form class="navbar-form navbar-left">
						<div class="input-group">
							<input type="text" class="form-control" placeholder="Search for...">
							<span class="input-group-btn">
								<button class="btn btn-default" type="button">Go!</button>
							</span>
						</div><!-- /input-group -->
					</form>

					<!-- Collect the nav links, forms, and other content for toggling -->

					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="nav navbar-nav navbar-right">
							
							<li><button class="btn btn-default" style="margin: 0.5em 0.5em;" ><a href="create-post.php">New Post</a></button></li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $row['username'] ?> <span class="caret"></span></a>
								<ul class="dropdown-menu">
									<li><a href="pet-profile.php">View Profile</a></li>
									<li><a href="logout.php">Log Out</a></li>
								</ul>
							</li>
						</ul>
					</div><!-- /.navbar-collapse -->
				</div><!-- /.container-fluid -->
			</nav>
		</header>
		<div class="container">
			<section>
				<article class="col-sm-12">
					<div class="bulletin">
						<nav class="bulletin-top-nav">
							<ul class="nav nav-pills" role="tablist">
								<li role="presentation" class="active"><a href="#homeScreenPage" aria-control="homeScreenPage" data-toggle="pill">Home</a></li>
								<li role="presentation"><a href="#myPostsPage" aria-control="myPostsPage" data-toggle="pill">My Posts</a></li>
								<li role="presentation"><a href="#myFavoritesPage" aria-control="myFavoritesPage" data-toggle="pill">My Favorites</a></li>
                <li role="presentation"><a href="#myJoinsPage" aria-control="myJoinsPage" data-toggle="pill">My Joins</a></li>
							</ul>
						</nav>

              <!-- start of home screen page -->
							<div class="tab-content">
								<div role="tabpanel" class="tab-pane active container-fluid bulletin-content" style="padding: 1em; background-color: #2e3742; height: 600px; overflow-y: scroll; border-radius: 10px;" id="homeScreenPage">
                  <div>
                  <?php
                  $result = $bulletinob->getOtherUserBulletinDetails($username, $con);
                  $navCounter = 0;

                  if ($result->num_rows > 0) {
                    // output data of each row
                    while($rowOther = $result->fetch_assoc()) {

                          $rowOtherPlaydateBulletinID = $rowOther["Playdate_ID"];
                          $rowOtherUserId = $rowOther["Username"];
                          $rowOtherPlaydateTitle = $rowOther["Title"];
                          $rowOtherPlaydateDescription = $rowOther["Description"];
                          $rowOtherPetTypePreference = $rowOther["Type_Preference"];
                          $rowOtherPlaydateMaxCapacity = $rowOther["Capacity"];
                          $rowOtherPlaydateDateTime = $rowOther["DateTime"];
                          $rowOtherPlaydateAddress = $rowOther["Address"];
                          $rowOtherPlaydateCity = $rowOther["City"];
                          $rowOtherPlaydateState = $rowOther["State"];
                          $rowOtherPlaydateZipCode = $rowOther["Zipcode"];
                          $rowOtherPlaydateTimestamp = $rowOther["Timestamp"];

                          $otherpet = $otherpetob->getPetDetails($rowOtherUserId, $con);
                          $otherPetPicture = $otherpet["Pet_Picture"];
                   ?>

                  <!-- Start of Bulletin Card Posts-->
									<div class="bulletin-card">
										<div class="small-header">
											<div class="pet-img">
                        <?php
                          echo '<img class="pull-left img-circle" style="height: 35px; width: 35px;" alt="User Pet Img" src="data:image;base64,'.base64_encode($otherPetPicture).'" />';
                        ?>
											</div>
											<div class="userName-info">
												<p>Posted by user: <a href="pet-profile.php?username=<?php echo $rowOtherUserId ?>"><?php echo $rowOtherUserId ?> </a> on <span class="glyphicon glyphicon-time" style="margin: 0;"></span> <?php echo $rowOtherPlaydateTimestamp ?><p>
											</div>
										</div>
										<span class="clearfix"></span>
										<div class="bulletin-card-content">
											<h3><strong>Event Title: </strong><?php echo $rowOtherPlaydateTitle ?></h3>
											<p><strong>Event Description: </strong><?php echo $rowOtherPlaydateDescription ?></p>
											<p><strong>Event Location: </strong><?php echo $rowOtherPlaydateAddress.', '.$rowOtherPlaydateCity.', '.$rowOtherPlaydateState.', '.$rowOtherPlaydateZipCode ?></p>
                      <p><strong>Event Date and Time: </strong><?php echo $rowOtherPlaydateDateTime ?></p>
											<P><strong>Pet Type Preferred: </strong><?php echo $rowOtherPetTypePreference ?></p>
                      <p><strong>Max Capacity: </strong><?php echo $rowOtherPlaydateMaxCapacity ?></p>
											<p><strong>Availability: </strong> Yes (Feature to be implemented)</p>
										</div>
										<div id="share-buttons">
											<a href="#" data-toggle="modal" data-target=".bulletinDetails-<?php echo $rowOtherPlaydateBulletinID ?>">
												<img src="image/bulletin-comment.png" alt="Comment Icon" />
												Comments
											</a>

                      <?php
                        $isliked = $userob->isFavorited($username, $rowOtherPlaydateBulletinID, $con);
                      ?>
											<a href="#" id="bookmark-<?php echo $rowOtherPlaydateBulletinID ?>" class="bookmark <?php if($isliked>0) { ?> unlike <?php } ?>">

                        <?php if($isliked>0) echo '<img src="image/icon-heart-red.png" alt="Red Favorite Icon" />Remove from Favorites'; else echo '<img src="image/bulletin-heart.png" alt="Favorite Icon" />Add to Favorites'; ?>
											</a>
                      <span id="nolikes-<?php echo $rowOtherPlaydateBulletinID ?>">
                        (<?php echo $bulletinob->numOfFavorites($rowOtherPlaydateBulletinID, $con); ?>)
                      </span>

                      <?php
                        $isjoined = $userob->isJoined($username, $rowOtherPlaydateBulletinID, $con);
                      ?>
											<a href="#" id="joins-<?php echo $rowOtherPlaydateBulletinID ?>" class="join <?php if($isjoined>0) { ?> unlike <?php } ?>">
                        <?php if($isjoined>0) echo '<img src="image/icon-exit.png" alt="Unjoin Icon" />Unjoin Playdate'; else echo '<img src="image/icon-add.png" alt="Join Icon" />Join Playdate'; ?>
											</a>
                      <span id="nojoins-<?php echo $rowOtherPlaydateBulletinID ?>">
                        (<?php echo $bulletinob->numOfJoins($rowOtherPlaydateBulletinID, $con); ?>)
                      </span>
										</div>
									</div>

                  <!-- My Info Modal -->
                  <div class="modal fade bulletinDetails-<?php echo $rowOtherPlaydateBulletinID ?>"  role="dialog">
                    <div class="modal-dialog modal-lg">
                      <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">
                              <?php
                                echo '<img class="pull-left img-circle" style="height: 35px; width: 35px; margin-right: 0.5em;" alt="User Pet Img" src="data:image;base64,'.base64_encode($otherPetPicture).'" />';
                              ?>
                              Event Stats (lol):
                            </h4>
                            <p>Posted by user: <a href="pet-profile.php?username=<?php echo $rowOtherUserId ?>"><?php echo $rowOtherUserId ?> </a> on <span class="glyphicon glyphicon-time" style="margin: 0;"></span> <?php echo $rowOtherPlaydateTimestamp ?><p>

                            <h3><strong>Event Title: </strong><?php echo $rowOtherPlaydateTitle ?></h3>
      											<p><strong>Event Description: </strong><?php echo $rowOtherPlaydateDescription ?></p>
      											<p><strong>Event Location: </strong><?php echo $rowOtherPlaydateAddress.', '.$rowOtherPlaydateCity.', '.$rowOtherPlaydateState.', '.$rowOtherPlaydateZipCode ?></p>
                            <p><strong>Event Date and Time: </strong><?php echo $rowOtherPlaydateDateTime ?></p>
                            <P><strong>Pet Type Preferred: </strong><?php echo $rowOtherPetTypePreference ?></p>
                            <p><strong>Max Capacity: </strong><?php echo $rowOtherPlaydateMaxCapacity ?></p>
      											<p><strong>Availability: </strong> Yes (Feature to be implemented)</p>
                          </div>

                          <div class="modal-body" style="background-color: grey">
                            <?php
                            $playdateComments = $bulletinob->getBulletinComments($rowOtherPlaydateBulletinID, $con);
                            $numOfComments = $playdateComments->num_rows;
                            if($numOfComments > 0){
                              while($rowComments = $playdateComments->fetch_assoc()) {

                                $rowCommentsCommentID = $rowComments["Comment_ID"];
                                $rowCommentsUserCommentContent = $rowComments["User_Comment"];
                                $rowCommentsUserCommentDatetime = $rowComments["Date_Time"];
                                $rowCommentsCommentUsernameID = $rowComments["Comment_Username"];
                                $rowCommentsCommentPlaydateId = $rowComments["Comment_Playdate_ID"];

                                $commentPet = $commentpetob->getPetDetails($rowCommentsCommentUsernameID, $con);
                                $commentPetPicture = $commentPet["Pet_Picture"];


                             ?>
                            <div class="tweet">
                            <div class="bulletin-card">
                              <div class="media">
                                <div class="media-left">
                                  <a href="pet-profile.php?username=<?php echo $rowCommentsCommentUsernameID ?>">
                                    <?php
                                      echo '<img class="media-object img-circle user-img" alt="Comment User Pet Img" src="data:image;base64,'.base64_encode($commentPetPicture).'" />';
                                    ?>
                                  </a>
                                </div>
                                <div class="media-body">
                                  <div class="containerTextMessage" style="width: auto; height:100px;">
                                    <div class="chat-body clearfix">
                                      <div class="header">
                                        <small class="text-muted pull-right"><span class="glyphicon glyphicon-time"></span><?php echo $rowCommentsUserCommentDatetime ?></small>
                                        <strong class="pull-left" style="color: black"><?php echo $rowCommentsCommentUsernameID ?></strong>
                                      </div>
                                      <span class="clearfix"></span>
                                      <?php if($rowCommentsCommentUsernameID == $rowOtherUserId){ ?>
                                      <p>
                                        <strong>Bulletin Owner: </strong><?php echo $rowCommentsUserCommentContent ?>
                                      </p>
                                    <?php }else{?>
                                      <p>
                                        <strong>Bulletin Peasant: </strong><?php echo $rowCommentsUserCommentContent ?>
                                      </p>
                                    <?php } ?>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <span class="clearfix"></span>
                            </div>

                          </div>
                          <?php
                              }
                            }else{
                                echo "0 results";
                            }
                          ?>
                        </div> <!-- End of modal body -->
                          <div class="modal-footer">
                            <!--
                            <label>Type a comment: </label>
                            <input type="text" maxlength="400" placeholder="Enter comment" name="" class="form-control">
                            <button type="submit" class="btn btn-primary" data-dismiss="modal">Submit</button>
                          -->
                            <h4>Type a comment:</h4>
                            <p class="error"></p>
                            <textarea id="tweet" class="form-control"></textarea>
                            <br>
                            <a class="btn btn-primary tweetButton" href="#" id="<?php echo $rowOtherPlaydateBulletinID ?>2"> Tweet </a>
                          </div>
                        </div>
                    </div>
                  </div><!-- End of modal -->

                <?php
                    }
                  }else{
                      echo "0 results";
                  }
                ?>
                  </div>
							  </div><!-- end of home tab-->

                <!-- start of my posts page-->
								<div role="tabpanel" class="tab-pane container-fluid bulletin-content" style="padding: 1em; background-color: black; height: 600px; overflow-y: scroll; border-radius: 10px;" id="myPostsPage">
                  <?php
                  $result = $bulletinob->getUserBulletinDetails($username, $con);
                  //$navCounter = 0;

                  if ($result->num_rows > 0) {
                    // output data of each row
                    while($rowOther = $result->fetch_assoc()) {

                          $rowOtherPlaydateBulletinID = $rowOther["Playdate_ID"];
                          $rowOtherUserId = $rowOther["Username"];
                          $rowOtherPlaydateTitle = $rowOther["Title"];
                          $rowOtherPlaydateDescription = $rowOther["Description"];
                          $rowOtherPetTypePreference = $rowOther["Type_Preference"];
                          $rowOtherPlaydateMaxCapacity = $rowOther["Capacity"];
                          $rowOtherPlaydateDateTime = $rowOther["DateTime"];
                          $rowOtherPlaydateAddress = $rowOther["Address"];
                          $rowOtherPlaydateCity = $rowOther["City"];
                          $rowOtherPlaydateState = $rowOther["State"];
                          $rowOtherPlaydateZipCode = $rowOther["Zipcode"];
                          $rowOtherPlaydateTimestamp = $rowOther["Timestamp"];

                          $otherpet = $otherpetob->getPetDetails($rowOtherUserId, $con);
                          $otherPetPicture = $otherpet["Pet_Picture"];
                   ?>

                  <!-- Start of Bulletin Card Posts-->
									<div class="bulletin-card">
										<div class="small-header">
											<div class="pet-img">
                        <?php
                          echo '<img class="pull-left img-circle" style="height: 35px; width: 35px;" alt="User Pet Img" src="data:image;base64,'.base64_encode($otherPetPicture).'" />';
                        ?>
											</div>
											<div class="userName-info">
												<p>Posted by user: <a href="pet-profile.php?username=<?php echo $rowOtherUserId ?>"><?php echo $rowOtherUserId ?> </a> on <span class="glyphicon glyphicon-time" style="margin: 0;"></span> <?php echo $rowOtherPlaydateTimestamp ?><p>
											</div>
										</div>
										<span class="clearfix"></span>
										<div class="bulletin-card-content">
											<h3><strong>Event Title: </strong><?php echo $rowOtherPlaydateTitle ?></h3>
											<p><strong>Event Description: </strong><?php echo $rowOtherPlaydateDescription ?></p>
											<p><strong>Event Location: </strong><?php echo $rowOtherPlaydateAddress.', '.$rowOtherPlaydateCity.', '.$rowOtherPlaydateState.', '.$rowOtherPlaydateZipCode ?></p>
											<P><strong>Pet Type Preferred: </strong><?php echo $rowOtherPetTypePreference ?></p>
                      <p><strong>Max Capacity: </strong><?php echo $rowOtherPlaydateMaxCapacity ?></p>
											<p><strong>Availability: </strong> Yes (Feature to be implemented)</p>
										</div>
										<div id="share-buttons">
											<a href="#" data-toggle="modal" data-target=".bulletinDetails-<?php echo $rowOtherPlaydateBulletinID ?>">
												<img src="image/bulletin-comment.png" alt="Comment Icon" />
												Comments
											</a>

										</div>
									</div>

                  <!-- My Info Modal -->
                  <div class="modal fade bulletinDetails-<?php echo $rowOtherPlaydateBulletinID ?>"  role="dialog">
                    <div class="modal-dialog modal-lg">
                      <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">
                              <?php
                                echo '<img class="pull-left img-circle" style="height: 35px; width: 35px; margin-right: 0.5em;" alt="User Pet Img" src="data:image;base64,'.base64_encode($otherPetPicture).'" />';
                              ?>
                              Event Stats (lol):
                            </h4>
                            <p>Posted by user: <a href="pet-profile.php?username=<?php echo $rowOtherUserId ?>"><?php echo $rowOtherUserId ?> </a> on <span class="glyphicon glyphicon-time" style="margin: 0;"></span> <?php echo $rowOtherPlaydateTimestamp ?><p>

                            <h3><strong>Event Title: </strong><?php echo $rowOtherPlaydateTitle ?></h3>
      											<p><strong>Event Description: </strong><?php echo $rowOtherPlaydateDescription ?></p>
      											<p><strong>Event Location: </strong><?php echo $rowOtherPlaydateAddress.', '.$rowOtherPlaydateCity.', '.$rowOtherPlaydateState.', '.$rowOtherPlaydateZipCode ?></p>
      											<P><strong>Pet Type Preferred: </strong><?php echo $rowOtherPetTypePreference ?></p>
                            <p><strong>Max Capacity: </strong><?php echo $rowOtherPlaydateMaxCapacity ?></p>
      											<p><strong>Availability: </strong> Yes (Feature to be implemented)</p>
                          </div>

                          <div class="modal-body" style="background-color: grey">
                            <div class="bulletin-card">
                              <div class="media">
                                <div class="media-left">
                                  <a href="#" class="messagesBoxPopUp">
                                    <img class="media-object img-circle user-img" src="image/Jessica-Jones.jpg" alt="Message Recipient Img">
                                  </a>
                                </div>
                                <div class="media-body">
                                  <div class="containerTextMessage" style="width: auto; height:100px;">
                                    <div class="chat-body clearfix">
                                      <div class="header">
                                        <small class="text-muted pull-right"><span class="glyphicon glyphicon-time"></span>11/29/18 9:28 AM</small>
                                        <strong class="pull-left" style="color: black">Jessica Jones</strong>
                                      </div>
                                      <span class="clearfix"></span>
                                      <p>
                                        <strong>You sent: </strong>I know
                                      </p>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <span class="clearfix"></span>
                            </div>
                            <div class="bulletin-card">
                              <div class="media">
                                <div class="media-left">
                                  <a href="#" class="messagesBoxPopUp">
                                    <img class="media-object img-circle user-img" src="image/Jessica-Jones.jpg" alt="Message Recipient Img">
                                  </a>
                                </div>
                                <div class="media-body">
                                  <div class="containerTextMessage" style="width: auto; height:100px;">
                                    <div class="chat-body clearfix">
                                      <div class="header">
                                        <small class="text-muted pull-right"><span class="glyphicon glyphicon-time"></span>11/29/18 9:28 AM</small>
                                        <strong class="pull-left" style="color: black">Jessica Jones</strong>
                                      </div>
                                      <span class="clearfix"></span>
                                      <p>
                                        <strong>You sent: </strong>I know
                                      </p>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <span class="clearfix"></span>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <label>Type a comment: </label>
                            <input type="text" placeholder="Enter comment" name="" class="form-control">
                            <button type="submit" class="btn btn-primary" data-dismiss="modal">Submit</button>
                          </div>
                        </div>
                    </div>
                  </div>
                  <?php
                      }
                    }else{
                        echo "0 results";
                    }
                  ?>
							  </div><!-- end of my posts tab-->

                <!-- Start of My favorites tab-->
								<div role="tabpanel" class="tab-pane container-fluid bulletin-content" style="padding: 1em; background-color: black; height: 600px; overflow-y: scroll; border-radius: 10px;" id="myFavoritesPage">
                  <div>
                  <?php
                  $result = $bulletinob->getUserBulletinFavorites($username, $con);
                  $navCounter = 0;

                  if ($result->num_rows > 0) {
                    // output data of each row
                    while($rowOther = $result->fetch_assoc()) {

                          $rowOtherPlaydateBulletinID = $rowOther["Playdate_ID"];
                          $rowOtherUserId = $rowOther["Username"];
                          $rowOtherPlaydateTitle = $rowOther["Title"];
                          $rowOtherPlaydateDescription = $rowOther["Description"];
                          $rowOtherPetTypePreference = $rowOther["Type_Preference"];
                          $rowOtherPlaydateMaxCapacity = $rowOther["Capacity"];
                          $rowOtherPlaydateDateTime = $rowOther["DateTime"];
                          $rowOtherPlaydateAddress = $rowOther["Address"];
                          $rowOtherPlaydateCity = $rowOther["City"];
                          $rowOtherPlaydateState = $rowOther["State"];
                          $rowOtherPlaydateZipCode = $rowOther["Zipcode"];
                          $rowOtherPlaydateTimestamp = $rowOther["Timestamp"];

                          $otherpet = $otherpetob->getPetDetails($rowOtherUserId, $con);
                          $otherPetPicture = $otherpet["Pet_Picture"];
                   ?>

                  <!-- Start of Bulletin Card Posts-->
									<div class="bulletin-card">
										<div class="small-header">
											<div class="pet-img">
                        <?php
                          echo '<img class="pull-left img-circle" style="height: 35px; width: 35px;" alt="User Pet Img" src="data:image;base64,'.base64_encode($otherPetPicture).'" />';
                        ?>
											</div>
											<div class="userName-info">
												<p>Posted by user: <a href="pet-profile.php?username=<?php echo $rowOtherUserId ?>"><?php echo $rowOtherUserId ?> </a> on <span class="glyphicon glyphicon-time" style="margin: 0;"></span> <?php echo $rowOtherPlaydateTimestamp ?><p>
											</div>
										</div>
										<span class="clearfix"></span>
										<div class="bulletin-card-content">
											<h3><strong>Event Title: </strong><?php echo $rowOtherPlaydateTitle ?></h3>
											<p><strong>Event Description: </strong><?php echo $rowOtherPlaydateDescription ?></p>
											<p><strong>Event Location: </strong><?php echo $rowOtherPlaydateAddress.', '.$rowOtherPlaydateCity.', '.$rowOtherPlaydateState.', '.$rowOtherPlaydateZipCode ?></p>
                      <p><strong>Event Date and Time: </strong><?php echo $rowOtherPlaydateDateTime ?></p>
											<P><strong>Pet Type Preferred: </strong><?php echo $rowOtherPetTypePreference ?></p>
                      <p><strong>Max Capacity: </strong><?php echo $rowOtherPlaydateMaxCapacity ?></p>
											<p><strong>Availability: </strong> Yes (Feature to be implemented)</p>
										</div>
										<div id="share-buttons">
											<a href="#" data-toggle="modal" data-target=".bulletinDetails-<?php echo $rowOtherPlaydateBulletinID ?>1">
												<img src="image/bulletin-comment.png" alt="Comment Icon" />
												Comments
											</a>

											<a href="#" >
												<img src="image/bulletin-share.png" alt="Share Icon" />
												Recommend
											</a>

										</div>
									</div>

                  <!-- My Info Modal -->
                  <div class="modal fade bulletinDetails-<?php echo $rowOtherPlaydateBulletinID ?>1"  role="dialog">
                    <div class="modal-dialog modal-lg">
                      <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">
                              <?php
                                echo '<img class="pull-left img-circle" style="height: 35px; width: 35px; margin-right: 0.5em;" alt="User Pet Img" src="data:image;base64,'.base64_encode($otherPetPicture).'" />';
                              ?>
                              Event Stats (lol):
                            </h4>
                            <p>Posted by user: <a href="pet-profile.php?username=<?php echo $rowOtherUserId ?>"><?php echo $rowOtherUserId ?> </a> on <span class="glyphicon glyphicon-time" style="margin: 0;"></span> <?php echo $rowOtherPlaydateTimestamp ?><p>

                            <h3><strong>Event Title: </strong><?php echo $rowOtherPlaydateTitle ?></h3>
      											<p><strong>Event Description: </strong><?php echo $rowOtherPlaydateDescription ?></p>
      											<p><strong>Event Location: </strong><?php echo $rowOtherPlaydateAddress.', '.$rowOtherPlaydateCity.', '.$rowOtherPlaydateState.', '.$rowOtherPlaydateZipCode ?></p>
                            <p><strong>Event Date and Time: </strong><?php echo $rowOtherPlaydateDateTime ?></p>
                            <P><strong>Pet Type Preferred: </strong><?php echo $rowOtherPetTypePreference ?></p>
                            <p><strong>Max Capacity: </strong><?php echo $rowOtherPlaydateMaxCapacity ?></p>
      											<p><strong>Availability: </strong> Yes (Feature to be implemented)</p>
                          </div>

                          <div class="modal-body" style="background-color: grey">
                            <div class="tweet">
                            <div class="bulletin-card">
                              <div class="media">
                                <div class="media-left">
                                  <a href="#" class="messagesBoxPopUp">
                                    <img class="media-object img-circle user-img" src="image/Jessica-Jones.jpg" alt="Message Recipient Img">
                                  </a>
                                </div>
                                <div class="media-body">
                                  <div class="containerTextMessage" style="width: auto; height:100px;">
                                    <div class="chat-body clearfix">
                                      <div class="header">
                                        <small class="text-muted pull-right"><span class="glyphicon glyphicon-time"></span>11/29/18 9:28 AM</small>
                                        <strong class="pull-left" style="color: black">Jessica Jones</strong>
                                      </div>
                                      <span class="clearfix"></span>
                                      <p>
                                        <strong>You sent: </strong>I know
                                      </p>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <span class="clearfix"></span>
                            </div>
                            <div class="bulletin-card">
                              <div class="media">
                                <div class="media-left">
                                  <a href="#" class="messagesBoxPopUp">
                                    <img class="media-object img-circle user-img" src="image/Jessica-Jones.jpg" alt="Message Recipient Img">
                                  </a>
                                </div>
                                <div class="media-body">
                                  <div class="containerTextMessage" style="width: auto; height:100px;">
                                    <div class="chat-body clearfix">
                                      <div class="header">
                                        <small class="text-muted pull-right"><span class="glyphicon glyphicon-time"></span>11/29/18 9:28 AM</small>
                                        <strong class="pull-left" style="color: black">Jessica Jones</strong>
                                      </div>
                                      <span class="clearfix"></span>
                                      <p>
                                        <strong>You sent: </strong>I know
                                      </p>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <span class="clearfix"></span>
                            </div>
                          </div>
                        </div> <!-- End of modal body -->
                          <div class="modal-footer">
                            <!--
                            <label>Type a comment: </label>
                            <input type="text" maxlength="400" placeholder="Enter comment" name="" class="form-control">
                            <button type="submit" class="btn btn-primary" data-dismiss="modal">Submit</button>
                          -->
                            <h4>Type a comment:</h4>
                            <p class="error"></p>
                            <textarea class="form-control"></textarea>
                            <br>
                            <a class="btn btn-primary" href="#" > Tweet </a>
                          </div>
                        </div>
                    </div>
                  </div><!-- End of modal -->

                <?php
                    }
                  }else{
                      echo "0 results";
                  }
                ?>
                  </div>
							  </div><!-- end of my favorites tab-->

                <!-- Start of My Joins tab-->
								<div role="tabpanel" class="tab-pane container-fluid bulletin-content" style="padding: 1em; background-color: black; height: 600px; overflow-y: scroll; border-radius: 10px;" id="myJoinsPage">
                  <div>
                  <?php
                  $result = $bulletinob->getUserBulletinJoins($username, $con);
                  $navCounter = 0;

                  if ($result->num_rows > 0) {
                    // output data of each row
                    while($rowOther = $result->fetch_assoc()) {

                          $rowOtherPlaydateBulletinID = $rowOther["Playdate_ID"];
                          $rowOtherUserId = $rowOther["Username"];
                          $rowOtherPlaydateTitle = $rowOther["Title"];
                          $rowOtherPlaydateDescription = $rowOther["Description"];
                          $rowOtherPetTypePreference = $rowOther["Type_Preference"];
                          $rowOtherPlaydateMaxCapacity = $rowOther["Capacity"];
                          $rowOtherPlaydateDateTime = $rowOther["DateTime"];
                          $rowOtherPlaydateAddress = $rowOther["Address"];
                          $rowOtherPlaydateCity = $rowOther["City"];
                          $rowOtherPlaydateState = $rowOther["State"];
                          $rowOtherPlaydateZipCode = $rowOther["Zipcode"];
                          $rowOtherPlaydateTimestamp = $rowOther["Timestamp"];

                          $otherpet = $otherpetob->getPetDetails($rowOtherUserId, $con);
                          $otherPetPicture = $otherpet["Pet_Picture"];
                   ?>

                  <!-- Start of Bulletin Card Posts-->
									<div class="bulletin-card">
										<div class="small-header">
											<div class="pet-img">
                        <?php
                          echo '<img class="pull-left img-circle" style="height: 35px; width: 35px;" alt="User Pet Img" src="data:image;base64,'.base64_encode($otherPetPicture).'" />';
                        ?>
											</div>
											<div class="userName-info">
												<p>Posted by user: <a href="pet-profile.php?username=<?php echo $rowOtherUserId ?>"><?php echo $rowOtherUserId ?> </a> on <span class="glyphicon glyphicon-time" style="margin: 0;"></span> <?php echo $rowOtherPlaydateTimestamp ?><p>
											</div>
										</div>
										<span class="clearfix"></span>
										<div class="bulletin-card-content">
											<h3><strong>Event Title: </strong><?php echo $rowOtherPlaydateTitle ?></h3>
											<p><strong>Event Description: </strong><?php echo $rowOtherPlaydateDescription ?></p>
											<p><strong>Event Location: </strong><?php echo $rowOtherPlaydateAddress.', '.$rowOtherPlaydateCity.', '.$rowOtherPlaydateState.', '.$rowOtherPlaydateZipCode ?></p>
                      <p><strong>Event Date and Time: </strong><?php echo $rowOtherPlaydateDateTime ?></p>
											<P><strong>Pet Type Preferred: </strong><?php echo $rowOtherPetTypePreference ?></p>
                      <p><strong>Max Capacity: </strong><?php echo $rowOtherPlaydateMaxCapacity ?></p>
											<p><strong>Availability: </strong> Yes (Feature to be implemented)</p>
										</div>
										<div id="share-buttons">
											<a href="#" data-toggle="modal" data-target=".bulletinDetails-<?php echo $rowOtherPlaydateBulletinID ?>2">
												<img src="image/bulletin-comment.png" alt="Comment Icon" />
												Comments
											</a>

											<a href="#" >
												<img src="image/bulletin-share.png" alt="Share Icon" />
												Recommend
											</a>

										</div>
									</div>

                  <!-- My Info Modal -->
                  <div class="modal fade bulletinDetails-<?php echo $rowOtherPlaydateBulletinID ?>2"  role="dialog">
                    <div class="modal-dialog modal-lg">
                      <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">
                              <?php
                                echo '<img class="pull-left img-circle" style="height: 35px; width: 35px; margin-right: 0.5em;" alt="User Pet Img" src="data:image;base64,'.base64_encode($otherPetPicture).'" />';
                              ?>
                              Event Stats (lol):
                            </h4>
                            <p>Posted by user: <a href="pet-profile.php?username=<?php echo $rowOtherUserId ?>"><?php echo $rowOtherUserId ?> </a> on <span class="glyphicon glyphicon-time" style="margin: 0;"></span> <?php echo $rowOtherPlaydateTimestamp ?><p>

                            <h3><strong>Event Title: </strong><?php echo $rowOtherPlaydateTitle ?></h3>
      											<p><strong>Event Description: </strong><?php echo $rowOtherPlaydateDescription ?></p>
      											<p><strong>Event Location: </strong><?php echo $rowOtherPlaydateAddress.', '.$rowOtherPlaydateCity.', '.$rowOtherPlaydateState.', '.$rowOtherPlaydateZipCode ?></p>
                            <p><strong>Event Date and Time: </strong><?php echo $rowOtherPlaydateDateTime ?></p>
                            <P><strong>Pet Type Preferred: </strong><?php echo $rowOtherPetTypePreference ?></p>
                            <p><strong>Max Capacity: </strong><?php echo $rowOtherPlaydateMaxCapacity ?></p>
      											<p><strong>Availability: </strong> Yes (Feature to be implemented)</p>
                          </div>

                          <div class="modal-body" style="background-color: grey">
                            <div class="tweet">
                            <div class="bulletin-card">
                              <div class="media">
                                <div class="media-left">
                                  <a href="#" class="messagesBoxPopUp">
                                    <img class="media-object img-circle user-img" src="image/Jessica-Jones.jpg" alt="Message Recipient Img">
                                  </a>
                                </div>
                                <div class="media-body">
                                  <div class="containerTextMessage" style="width: auto; height:100px;">
                                    <div class="chat-body clearfix">
                                      <div class="header">
                                        <small class="text-muted pull-right"><span class="glyphicon glyphicon-time"></span>11/29/18 9:28 AM</small>
                                        <strong class="pull-left" style="color: black">Jessica Jones</strong>
                                      </div>
                                      <span class="clearfix"></span>
                                      <p>
                                        <strong>You sent: </strong>I know
                                      </p>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <span class="clearfix"></span>
                            </div>
                            <div class="bulletin-card">
                              <div class="media">
                                <div class="media-left">
                                  <a href="#" class="messagesBoxPopUp">
                                    <img class="media-object img-circle user-img" src="image/Jessica-Jones.jpg" alt="Message Recipient Img">
                                  </a>
                                </div>
                                <div class="media-body">
                                  <div class="containerTextMessage" style="width: auto; height:100px;">
                                    <div class="chat-body clearfix">
                                      <div class="header">
                                        <small class="text-muted pull-right"><span class="glyphicon glyphicon-time"></span>11/29/18 9:28 AM</small>
                                        <strong class="pull-left" style="color: black">Jessica Jones</strong>
                                      </div>
                                      <span class="clearfix"></span>
                                      <p>
                                        <strong>You sent: </strong>I know
                                      </p>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <span class="clearfix"></span>
                            </div>
                          </div>
                        </div> <!-- End of modal body -->
                          <div class="modal-footer">
                            <!--
                            <label>Type a comment: </label>
                            <input type="text" maxlength="400" placeholder="Enter comment" name="" class="form-control">
                            <button type="submit" class="btn btn-primary" data-dismiss="modal">Submit</button>
                          -->
                            <h4>Type a comment:</h4>
                            <p class="error"></p>
                            <textarea class="form-control"></textarea>
                            <br>
                            <a class="btn btn-primary" href="#" > Tweet </a>
                          </div>
                        </div>
                    </div>
                  </div><!-- End of modal -->

                <?php
                    }
                  }else{
                      echo "0 results";
                  }
                ?>
                  </div>
							  </div><!-- end of my joins tab-->

              </div><!-- end of tab content-->

					</div>
				</article>
			</section>
		</div><!-- container-fluid -->


		<footer>
			<p>Copyright 2018 by HelloPets Group</p>
		</footer>
		<!--JavaScript Link-->
		<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.js"></script>
    <script>
    $('.bookmark').click(function(e){
      e.preventDefault();

      var bulletinid = $(this).attr('id');
      var bulletinidsend = bulletinid.split("-");

      $.ajax({
        method:"POST",
        url:"includes/functions.php",
        data:{bookmarkPlaydateId: bulletinidsend[1], option: "likeBulletin"},
        async: false
      }).done(function(msg){
        msg = msg.split("-");

        if($.trim(msg[0]) == 'inserted'){
          $('#'+bulletinid).addClass('unlike');
          $('#'+bulletinid).html('<img src="image/icon-heart-red.png" alt="Red Favorite Icon" />Remove from Favorites');
        }
        else if($.trim(msg[0]) == 'deleted'){
          $('#'+bulletinid).removeClass('unlike');
          $('#'+bulletinid).html('<img src="image/bulletin-heart.png" alt="Favorite Icon" />Add to Favorites');
        }

        $('#nolikes-'+bulletinidsend[1]).html('('+msg[1]+')');
      });
    });

    $('.join').click(function(e){
      e.preventDefault();

      var bulletinid = $(this).attr('id');
      var bulletinidsend = bulletinid.split("-");

      $.ajax({
        method:"POST",
        url:"includes/functions.php",
        data:{joinPlaydateId: bulletinidsend[1], option: "joinBulletin"},
        async: false
      }).done(function(msg){
        msg = msg.split("-");

        if($.trim(msg[0]) == 'inserted'){
          $('#'+bulletinid).addClass('unlike');
          $('#'+bulletinid).html('<img src="image/icon-exit.png" alt="Unjoin Icon" />Unjoin Playdate');
        }
        else if($.trim(msg[0]) == 'deleted'){
          $('#'+bulletinid).removeClass('unlike');
          $('#'+bulletinid).html('<img src="image/icon-add.png" alt="Join Icon" />Join Playdate');
        }

        $('#nojoins-'+bulletinidsend[1]).html('('+msg[1]+')');
      });
    });


    $('.tweetButton').click(function(e){
          var tweetMessage = $('#tweet').val();
          //document.write(tweetMessage);
          var bulletinid = $(this).attr('id');
          bulletinid = bulletinid.slice(0, -1);
          bulletinid = parseInt(bulletinid, 10);
          //document.write(bulletinid);

          if($.trim(tweetMessage)==""){
            $('.error').html("please enter something to tweet");
          }
          else{
            $.ajax({
              method: "POST",
              url: "includes/functions.php",
              data: {tweetMessage: tweetMessage, commentPlaydateId: bulletinid, option: "tweetforuser"}
            }).done(function(msg){
              var message = msg.split("-");

              if($.trim(message[0])=='yayy'){

                var pimage = $('.profileimage').html();

                var today = new Date();
                var todayDate = today.getMonth()+1+"/"+today.getDate()+"/"+today.getFullYear();
                $('.tweets').prepend('<div class="tweet"><div class="col-sm-1">'+pimage+'</div><div class="col-sm-11"><p class="lead">'+tweetMessage+'</p><small>'+todayDate+'</small></div><div class="clearfix"></div>');
                $('.error').html(message[0]+'. your tweet has been successfully posted.');
                $('#tweet').val("");

                $('.noTweets').html(message[1]);

              }
              else{
                $('.error').html('there was an error, try again');
              }

            });
          }
        });

    </script>
	</body>
</html>
<?php
}
else{
  header("Location:login.php");
}

?>
