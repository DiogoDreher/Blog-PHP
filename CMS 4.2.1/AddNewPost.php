<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<?php require_once("Include/Sessions.php"); ?>
<?php
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
Confirm_Login(); ?>
<?php
if (isset($_POST["Submit"])) {
  $PostTitle = $_POST["PostTitle"];
  $Category  = $_POST["Category"];
  $Image     = $_FILES["Image"]["name"];
  $Target    = "Uploads/".basename($_FILES["Image"]["name"]);
  $PostText  = $_POST["PostDescription"];
  $Admin     = $_SESSION["Username"];

  date_default_timezone_set("Europe/Lisbon");
  $CurrentTime = time();
  $DateTime = strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);

  if (empty($PostTitle)) {
    $_SESSION['ErrorMessage']= "Title can't be empty!";
    Redirect_to("AddNewPost.php");
  } elseif (strlen($PostTitle)<5) {
    $_SESSION['ErrorMessage']= "Post title should be greater than 5 characters";
    Redirect_to("AddNewPost.php");
  } elseif (strlen($PostText)>9999) {
    $_SESSION['ErrorMessage']= "Post description should be less than 10000 characters";
    Redirect_to("AddNewPost.php");
  } else {
    //Query to insert post in our DataBase
    $sql = "INSERT INTO posts(datetime, title, category, author, image, post)";
    $sql .= "VALUES(:dateTime, :postTitle, :categoryName, :adminName, :imageName, :postDescription)";
    $stmt = $ConnectingDB->prepare($sql);
    $stmt->bindValue(':dateTime', $DateTime);
    $stmt->bindValue(':postTitle', $PostTitle);
    $stmt->bindValue(':categoryName', $Category);
    $stmt->bindValue(':adminName', $Admin);
    $stmt->bindValue(':imageName', $Image);
    $stmt->bindValue(':postDescription', $PostText);

    $Execute = $stmt->execute();
    move_uploaded_file($_FILES["Image"]["tmp_name"], $Target);

    if ($Execute) {
      $_SESSION["SuccessMessage"]="Post with id: ".$ConnectingDB->lastInsertId() ." added successfully";
      Redirect_to("AddNewPost.php");
    } else {
      $_SESSION['ErrorMessage']= "Something went wrong. Try Again!";
      Redirect_to("AddNewPost.php");
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
  <title>New Post</title>
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

          <h1><i class="fas fa-edit" style="color:gray;"></i> Add New Post</h1>

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

        <form class="" action="AddNewPost.php" method="post" enctype="multipart/form-data">
          <div class="card bg-secondary text-light mb-3">

            <div class="card-body bg-dark">
              <div class="form-group">
                <label for="title"><span class="FieldInfo">Post Title: </span></label>
                <input class="form-control" type="text" name="PostTitle" id="title" placeholder="Type title here" value="">
              </div>
              <div class="form-group">
                <label for="CategoryTitle"><span class="FieldInfo">Choose Category </span></label>
                <select class="form-control" id="CategoryTitle" name="Category">
                  <?php
                  //Fetching all the categories from category table
                  $ConnectingDB;
                  $sql = "SELECT id,title FROM category";
                  $stmt = $ConnectingDB->query($sql);
                  while ($DataRows = $stmt->fetch()) {
                    $Id = $DataRows["id"];
                    $CategoryName = $DataRows["title"];

                   ?>
                  <option><?php echo $CategoryName; ?></option>
                <?php } ?>
                </select>
              </div>

              <div class="form-group">
                <div class="custom-file">
                  <input class="custom-file-input" type="File" name="Image" id="imageSelect" value="">
                  <label for="imageSelect" class="custom-file-label">Select Image</label>
                </div>
              </div>

              <div class="form-group">
                <label for="Post"><span class="FieldInfo">Post: </span> </label>
                <textarea class="form-control" id="Post" name="PostDescription" rows="8" cols="80"></textarea>
              </div>

              <div class="row">

                <div class="col-lg-6 mb-2">
                  <a href="Dashboard.php" class="btn btn-secondary btn-block"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
                </div>

                <div class="col-lg-6 mb-2">
                  <button type="submit" name="Submit" class="btn btn-secondary btn-block"><i class="fas fa-check"></i> Publish</button>
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
