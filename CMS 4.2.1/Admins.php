<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<?php require_once("Include/Sessions.php"); ?>
<?php
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
Confirm_Login(); ?>
<?php
if (isset($_POST["Submit"])) {
  $Username = $_POST["Username"];
  $Name = $_POST["Name"];
  $Password = $_POST["Password"];
  $ConfirmPassword = $_POST["ConfirmPassword"];
  $Admin = $_SESSION["Username"];

  date_default_timezone_set("Europe/Lisbon");
  $CurrentTime = time();
  $DateTime = strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);

  if (empty($Username) || empty($Password) || empty($ConfirmPassword)) {
    $_SESSION['ErrorMessage']= "All fields must be filled out";
    Redirect_to("Admins.php");
  } elseif (strlen($Password)<4) {
    $_SESSION['ErrorMessage']= "Password should be greater than 3 characters";
    Redirect_to("Admins.php");
  } elseif ($Password !== $ConfirmPassword) {
    $_SESSION['ErrorMessage']= "Password and confirmation should match!";
    Redirect_to("Admins.php");
  } elseif (CheckUsernameExistsOrNot($Username)) {
    $_SESSION['ErrorMessage']= "Username already exists, please try another one.";
    Redirect_to("Admins.php");
  } else {
    //Query to insert new admin in our DataBase
    $ConnectingDB;
    $sql = "INSERT INTO admins(datetime, username, password, aname, addedby)";
    $sql .= "VALUES(:dateTime, :userName, :password, :aName, :adminName)";
    $stmt = $ConnectingDB->prepare($sql);
    $stmt->bindValue(':dateTime', $DateTime);
    $stmt->bindValue(':userName', $Username);
    $stmt->bindValue(':password', $Password);
    $stmt->bindValue(':aName', $Name);
    $stmt->bindValue(':adminName', $Admin);

    $Execute = $stmt->execute();

    if ($Execute) {
      $_SESSION["SuccessMessage"]="New Admin added successfully";
      Redirect_to("Admins.php");
    } else {
      $_SESSION['ErrorMessage']= "Something went wrong. Try Again!";
      Redirect_to("Admins.php");
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
  <title>Admin Page</title>
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

          <h1><i class="fas fa-user" style="color:gray;"></i> Manage Admins</h1>

        </div>
      </div>

    </div>
  </header>

  <!--HEADER END -->

  <!--MAIN AERA-->
  <section class="container py-2 mb-4" style="min-height:700px;">
    <div class="row">
      <div class="offset-lg-1 col-lg-10" style="min-height:400px;">

        <!-- PHP SCOPE TO CALL FUNCITONS-->
        <?php
        echo ErrorMessage();
        echo SuccessMessage();
         ?>
        <!--END OF PHP SCOPE-->

        <form class="" action="Admins.php" method="post">
          <div class="card bg-secondary text-light mb-3">

            <div class="card-header">
              <h1>Add New Admin</h1>
            </div>

            <div class="card-body bg-dark">
              <div class="form-group">
                <label for="username"><span class="FieldInfo">Username: </span></label>
                <input class="form-control" type="text" name="Username" id="username" value="">
              </div>
              <div class="form-group">
                <label for="name"><span class="FieldInfo">Name: </span></label>
                <input class="form-control" type="text" name="Name" id="name" value="">
                <small class="text-muted">*Optional</small>
              </div>
              <div class="form-group">
                <label for="password"><span class="FieldInfo">Password: </span></label>
                <input class="form-control" type="password" name="Password" id="password" value="">
              </div>
              <div class="form-group">
                <label for="confirmPassword"><span class="FieldInfo">Confirm Password: </span></label>
                <input class="form-control" type="password" name="ConfirmPassword" id="confirmPassword" value="">
              </div>
              <div class="row">

                <div class="col-lg-6 mb-2">
                  <a href="Dashboard.php" class="btn btn-secondary btn-block"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
                </div>

                <div class="col-lg-6 mb-2">
                  <button type="submit" name="Submit" class="btn btn-secondary btn-block"><i class="fas fa-check"></i> Add Admin</button>
                </div>

              </div>
            </div>
          </div>
        </form>
        <h2>Existing Admins</h2>

        <table class="table table-striped table-hover">
          <thead class="thead-dark">
            <tr>
              <th>No. </th>
              <th>Date&Time</th>
              <th>Username</th>
              <th>Admin Name</th>
              <th>Added By</th>
              <th>Action</th>
            </tr>
          </thead>

        <?php
        $ConnectingDB;
        $sql = "SELECT * FROM admins ORDER BY id desc";
        $Execute= $ConnectingDB->query($sql);
        $SrNo = 0;
        while ($DataRows=$Execute->fetch()) {
          $AdminId = $DataRows["id"];
          $DateTime = $DataRows['datetime'];
          $AdminUsername = $DataRows["username"];
          $AdminName = $DataRows["aname"];
          $AddedBy = $DataRows["addedby"];
          $SrNo++;
         ?>
        <tbody>
          <tr>
            <td><?php echo htmlentities($SrNo); ?></td>
            <td><?php echo htmlentities($DateTime); ?></td>
            <td><?php echo htmlentities($AdminUsername); ?></td>
            <td><?php echo htmlentities($AdminName); ?></td>
            <td><?php echo htmlentities($AddedBy); ?></td>
            <td><a class="btn btn-danger" href="DeleteAdmin.php?id=<?php echo $AdminId; ?>">Delete</a></td>
          </tr>
        </tbody>
        <?php } ?>
        </table>
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
