<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<?php require_once("Include/Sessions.php"); ?>
<?php
//Fetching Existing DataBase
$SearchQueryParameter = $_GET["username"];
$ConnectingDB;
$sql    = "SELECT aname,aheadline,abio,aimage FROM admins WHERE username=:userName";
$stmt   = $ConnectingDB->prepare($sql);
$stmt   -> bindValue(':userName', $SearchQueryParameter);
$stmt   -> execute();
$Result = $stmt->rowcount();
if ($Result ==1) {
  while ($DataRows = $stmt->fetch()) {
    $ExistingName     = $DataRows["aname"];
    $ExistingBio      = $DataRows["abio"];
    $ExistingHeadline = $DataRows["aheadline"];
    $ExistingImage    = $DataRows["aimage"];
  }
} else {
  $_SESSION["ErrorMessage"]= "Bad Request!";
  Redirect_to("Blog.php?page=1");
}
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
  <title>Profile</title>
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

  <header class="bg-dark text-white py-3">
    <div class="container">
      <div class="row">
        <div class="col-md-6">

          <h1><i class="fas fa-user text-success mr-2" style="color:gray;"></i><?php echo htmlentities($ExistingName); ?></h1>
          <h3><?php echo htmlentities($ExistingHeadline); ?></h3>
        </div>
      </div>

    </div>
  </header>

  <!--HEADER END -->
  <section class="container py-2 mb-4">
    <div class="row">
      <div class="col-md-3">
        <img src="Images/<?php echo htmlentities($ExistingImage); ?>" class="d-block image-fluid mb-3 rounded-circle col-md-12">
      </div>
      <div class="col-md-9" style="min-height:644px">
        <div class="card">
          <div class="card-body">
            <p class="lead"><?php echo htmlentities($ExistingBio); ?></p>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--FOOTER-->
  <footer class="bg-dark text-white py-3">
    <div class="container">
      <div class="row">
        <div class="col">
          <p class="lead text-center">Theme By | Diogo Oliveira | <span id="year"></span> &copy; ----All Rights Reserved</p>
        </div>
      </div>
    </div>
  </footer>
  <div style="height:10px; background:gray;"> </div>


  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  <script>
    $('#year').text(new Date().getFullYear());
  </script>
</body>

</html>
