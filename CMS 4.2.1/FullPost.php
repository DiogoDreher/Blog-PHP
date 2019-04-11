<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<?php require_once("Include/Sessions.php"); ?>
<?php $SearchQueryParameter = $_GET["id"]; ?>
<?php
if (isset($_POST["Submit"])) {
  $Name = $_POST["CommenterName"];
  $Email = $_POST["CommenterEmail"];
  $Comment = $_POST["CommenterThoughts"];
  date_default_timezone_set("Europe/Lisbon");
  $CurrentTime = time();
  $DateTime = strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);

  if (empty($Name) || empty($Email) || empty($Comment)) {
    $_SESSION['ErrorMessage']= "All fields must be filled out";
    Redirect_to("FullPost.php?id=$SearchQueryParameter");
  } elseif (strlen($Comment)>500) {
    $_SESSION['ErrorMessage']= "Comment length should be less than 500 characters.";
    Redirect_to("FullPost.php?id=$SearchQueryParameter");
  }  else {
    //Query to insert comment in our DataBase
    $ConnectingDB;
    $sql = "INSERT INTO comments(datetime, name, email, comment, approvedby, status, post_id)";
    $sql .= "VALUES(:dateTime, :name, :email, :comment, 'Pending', 'OFF', :postIdFromURL)";
    $stmt = $ConnectingDB->prepare($sql);
    $stmt->bindValue(':dateTime', $DateTime);
    $stmt->bindValue(':name', $Name);
    $stmt->bindValue(':email', $Email);
    $stmt->bindValue(':comment', $Comment);
    $stmt->bindValue(':postIdFromURL', $SearchQueryParameter);

    $Execute = $stmt->execute();

    //var_dump($Execute);

    if ($Execute) {
      $_SESSION["SuccessMessage"]="Comment submitted successfully";
      Redirect_to("FullPost.php?id=$SearchQueryParameter");
    } else {
      $_SESSION['ErrorMessage']= "Something went wrong. Try Again!";
      Redirect_to("FullPost.php?id=$SearchQueryParameter");
    }
  }
} //Ending of Submit Button If-Condition
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="CSS/styles.css">
  <title>Full Post</title>
</head>

<body>
  <!-- NAVBAR -->
  <div style="height:10px; background:gray;"> </div>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a href="#" class="navbar-brand">DIOGO_OLIVEIRA.COM</a>
      <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapseCMS">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarcollapseCMS">

        <ul class="navbar-nav mr-auto">

          <li class="nav-item">
            <a href="Blog.php" class="nav-link">Home</a>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">About Us</a>
          </li>

          <li class="nav-item">
            <a href="Blog.php" class="nav-link">Blog</a>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">Contact Us</a>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">Features</a>
          </li>

        </ul>
        <ul class="navbar-nav ml-auto">
          <form class="form-inline d-none d-sm-block" action="Blog.php">
            <div class="form-group">
              <input class="form-control mr-2" type="text" name="Search" placeholder="Search Here" value="">
              <button class="btn btn-primary mr-2" name="SearchButton">Go!</button>
            </div>
          </form>
        </ul>

      </div>
    </div>

  </nav>
  <div style="height:10px; background:gray;"> </div>
  <!--NAVBAR END -->

  <!--HEADER-->

  <div class="container" style="min-height:765px;">
    <div class="row mt-4">

      <!--MAIN AREA-->
      <div class="col-sm-8">
        <h1>The Complete Responsive CMS Blog</h1>
        <h1 class="lead">The Complete Blog by Using PHP by Diogo Oliveira</h1>

        <!-- PHP SCOPE TO CALL FUNCITONS-->
        <?php
        echo ErrorMessage();
        echo SuccessMessage();
         ?>
        <!--END OF PHP SCOPE-->

        <?php

        $ConnectingDB;
        // AQL query when search button is active
        if (isset($_GET["SearchButton"])) {
          $Search = $_GET["Search"];
          $sql = "SELECT * FROM posts
          WHERE datetime LIKE :search
          OR category LIKE :search
          OR title LIKE :search
          OR post LIKE :search";
          $stmt = $ConnectingDB->prepare($sql);
          $stmt ->bindValue(':search','%'.$Search."%");
          $stmt->execute();

        } //Default SQL query
        else {
          $PostIdFromURL = $_GET["id"];
          if (!isset($PostIdFromURL)) {
            $_SESSION["ErrorMessage"] = "Bad Request!";
            Redirect_to("Blog.php");
          }
          $sql = "SELECT * FROM posts WHERE id= '$PostIdFromURL'";
          $stmt = $ConnectingDB->query($sql);
          $Result = $stmt->rowcount();
          if ($Result != 1) {
            $_SESSION["ErrorMessage"] = "Bad Request!";
            Redirect_to("Blog.php?page=1");
          }
        }
        while ($DataRows = $stmt->fetch()) {
          $PostId = $DataRows["id"];
          $DateTime = $DataRows["datetime"];
          $PostTitle = $DataRows["title"];
          $Category = $DataRows["category"];
          $Admin = $DataRows["author"];
          $Image = $DataRows["image"];
          $PostDescription = $DataRows["post"];
         ?>

        <div class="card">
          <img src="Uploads/<?php echo htmlentities($Image); ?>" style="max-height:450px;" class="img-fluid card-img-top">
          <div class="card-body">
            <h4 class="card-title"><?php echo htmlentities($PostTitle); ?></h4>
            <small class="text-muted">Category: <a href="Blog.php?category=<?php echo htmlentities($Category); ?>"><span class="text-dark"> <?php echo htmlentities($Category); ?></span></a> | Written by <a href="Profile.php?username=<?php echo htmlentities($Admin); ?>"><span class="text-dark"><?php echo htmlentities($Admin); ?></span></a> on <span class="text-dark"><?php echo htmlentities($DateTime); ?></span></small>

            <hr>
            <p class="card-text">
              <?php echo nl2br($PostDescription); ?>
            </p>

          </div>
        </div>

        <?php } ?>

        <!-- COMMENT PART START-->

        <!--FETCHING EXISTING COMMENTS START-->
        <br>
        <div class="card">
          <div class="card-header bg-secondary">
            <h5 class="FieldInfo">Comments:</h5>
          </div>
        </div>

        <br><br>
        <?php
        $ConnectingDB;
        $sql = "SELECT * FROM comments
                WHERE post_id='$SearchQueryParameter'
                AND status='ON'";
        $stmt = $ConnectingDB->query($sql);
        while ($DataRows = $stmt->fetch()) {
          $CommentDate = $DataRows["datetime"];
          $CommenterName = $DataRows["name"];
          $CommentContent = $DataRows["comment"];
        ?>

        <div>
          <div class="bg-light media">
            <img class="d-block img-fluid align-self-start" style="max-height:120px;" src="images/comment.png" alt="">
            <div class="media-body ml-2">
              <h6 class="lead"><?php echo htmlentities($CommenterName) ?></h6>
              <p class="small"><?php echo htmlentities($CommentDate) ?></p>
              <p><?php echo htmlentities($CommentContent) ?></p>
            </div>
          </div>
        </div>
        <hr>

        <?php } ?>
        <!--FETCHING EXISTING COMMENTS END-->
        <div>
          <form class="" action="FullPost.php?id=<?php echo $SearchQueryParameter ?>" method="post">
            <div class="card mb-3">
              <div class="card-header bg-dark">
                <h5 class="FieldInfo">Share your thoughts about this post.</h5>
              </div>
              <div class="card-body">

                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-user"></i> </span>
                    </div>
                    <input class="form-control" type="text" name="CommenterName" placeholder="Name" value="">
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-envelope"></i> </span>
                    </div>
                    <input class="form-control" type="email" name="CommenterEmail" placeholder="Email" value="">
                  </div>
                </div>
                <div class="form-group">
                  <textarea class="form-control" name="CommenterThoughts" rows="6" cols="80"></textarea>
                </div>
                <div class="">
                  <button type="submit" name="Submit" class="btn btn-primary">Submit</button>
                </div>

              </div>
            </div>
          </form>
        </div>
        <!-- COMMENT PART END-->
      </div>
      <!--MAIN AREA END-->


            <?php require_once("Include/footer.php"); ?>
