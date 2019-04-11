<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<?php require_once("Include/Sessions.php"); ?>
<?php
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
Confirm_Login(); ?>
<?php
//Fetching the existing Admin Data
$AdminId = $_SESSION["UserId"];
global $ConnectingDB;
$sql = "SELECT * FROM admins WHERE id='$AdminId'";
$stmt = $ConnectingDB->query($sql);
while ($DataRows = $stmt->fetch()) {
  $ExistingName = $DataRows["aname"];
  $ExistingUsername = $DataRows["username"];
  $ExistingHeadline = $DataRows["aheadline"];
  $ExistingBio = $DataRows["abio"];
  $ExistingImage = $DataRows["aimage"];
}

if (isset($_POST["Submit"])) {
  $AName = $_POST["Name"];
  $AHeadline  = $_POST["Headline"];
  $ABio = $_POST['Bio'];
  $Image     = $_FILES["Image"]["name"];
  $Target    = "Images/".basename($_FILES["Image"]["name"]);

  if (strlen($AHeadline)>30) {
    $_SESSION['ErrorMessage']= "Headline should be less than 30 characters";
    Redirect_to("MyProfile.php");
  } elseif (strlen($ABio)>500) {
    $_SESSION['ErrorMessage']= "Bio should be less than 500 characters";
    Redirect_to("MyProfile.php");
  } else {
    //Query to Update Admin Data in our DataBase
    $ConnectingDB;
    if (!empty($Image)) {
      $sql = "UPDATE admins
              SET aname='$AName', aheadline='$AHeadline', abio='$ABio', aimage='$Image'
              WHERE id='$AdminId'";
    } else {
      $sql = "UPDATE admins
              SET aname='$AName', aheadline='$AHeadline', abio='$ABio'
              WHERE id='$AdminId'";
    }

    $Execute = $ConnectingDB->query($sql);
    move_uploaded_file($_FILES["Image"]["tmp_name"], $Target);
    //
    // var_dump($Execute);

    if ($Execute) {
      $_SESSION["SuccessMessage"]="Details Updated Successfully";
      Redirect_to("MyProfile.php");
    } else {
      $_SESSION['ErrorMessage']= "Something went wrong. Try Again!";
      Redirect_to("MyProfile.php");
    }
  }
} //Ending of Submit Button If-Condition
 ?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="CSS/styles.css">
  <title>My Profile</title>
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
            <a href="MyProfile.php" class="nav-link"><i class="far fa-user"></i> My Profile</a>
          </li>

          <li class="nav-item">
            <a href="Dashboard.php" class="nav-link">Dashboard</a>
          </li>

          <li class="nav-item">
            <a href="Posts.php" class="nav-link">Posts</a>
          </li>

          <li class="nav-item">
            <a href="Categories.php" class="nav-link">Categories</a>
          </li>

          <li class="nav-item">
            <a href="Admins.php" class="nav-link">Manage Admins</a>
          </li>

          <li class="nav-item">
            <a href="Comments.php" class="nav-link">Comments</a>
          </li>

          <li class="nav-item">
            <a href="Blog.php?page=1" class="nav-link">Live Blog</a>
          </li>

        </ul>
        <ul class="navbar-nav ml-auto">
          <li class="nav-item ">
            <a href="Logout.php" class="nav-link text-danger"><i class="fas fa-user-times"></i> Logout</a>
          </li>
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
        <div class="col-md-12">

          <h1><i class="fas fa-user text-sucess mr-2" style="color:gray;"></i> @<?php echo $ExistingUsername; ?></h1>
          <small><?php echo $ExistingHeadline; ?></small>
        </div>
      </div>

    </div>
  </header>

  <!--HEADER END -->

  <!--MAIN AERA-->
  <section class="container py-2 mb-4" style="min-height:700px;">
    <div class="row">
      <!-- LEFT AREA-->
      <div class="col-md-3">
        <div class="card">
          <div class="card-header bg-dark text-light">
            <h3><?php echo htmlentities($ExistingName); ?></h3>
          </div>
          <div class="card-body">
            <img src="Images/<?php echo $ExistingImage; ?>" class="d-block img-fluid mb-3" alt="">
            <div class="">
              <?php echo $ExistingBio; ?>
            </div>
          </div>
        </div>
      </div>
      <!-- LEFT AREA END-->

      <!-- RIGHT AREA-->
      <div class="col-md-9" style="min-height:400px;">

        <!-- PHP SCOPE TO CALL FUNCITONS-->
        <?php
        echo ErrorMessage();
        echo SuccessMessage();
         ?>
        <!--END OF PHP SCOPE-->

        <form class="" action="MyProfile.php" method="post" enctype="multipart/form-data">
          <div class="card bg-dark text-light">
            <div class="card-header bg-secondary text-light">
              <h4>Edit Profile</h4>
            </div>
            <div class="card-body">
              <div class="form-group">
                <input class="form-control" type="text" name="Name" id="name" placeholder="Your Name" value="">
              </div>
              <div class="form-group">
                <input class="form-control" type="text" id="headline" placeholder="Headline" name="Headline">
                <small class="text-muted">Add a professional headline like: "Engineer at XYZ" or "Architect"</small>
                <span class="text-danger">Not more than 30 characters!</span>
              </div>

              <div class="form-group">
                <textarea placeholder="Bio" class="form-control" id="Bio" name="Bio" rows="8" cols="80"></textarea>
              </div>

              <div class="form-group">
                <div class="custom-file">
                  <input class="custom-file-input" type="File" name="Image" id="imageSelect" value="">
                  <label for="imageSelect" class="custom-file-label">Select Image</label>
                </div>
              </div>



              <div class="row">

                <div class="col-lg-6 mb-2">
                  <a href="Dashboard.php" class="btn btn-secondary btn-block"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
                </div>

                <div class="col-lg-6 mb-2">
                  <button type="submit" name="Submit" class="btn btn-secondary btn-block"><i class="fas fa-check"></i> Update</button>
                </div>

              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>

  <!--MAIN AREA END-->

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
