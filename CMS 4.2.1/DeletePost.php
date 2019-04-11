<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<?php require_once("Include/Sessions.php"); ?>
<?php
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
Confirm_Login(); ?>
<?php
$SearchQueryParameter = $_GET["id"];
// FETCHING EXISTING CONTENT ACCORDING TO ID
$ConnectingDB;
$sql = "SELECT * FROM posts WHERE id ='$SearchQueryParameter'";
$stmt = $ConnectingDB->query($sql);
while ($DataRows = $stmt->fetch()) {
  $TitleToBeDeleted = $DataRows["title"];
  $CategoryToBeDeleted = $DataRows["category"];
  $ImageToBeDeleted = $DataRows["image"];
  $PostToBeDeleted = $DataRows["post"];
}
if (isset($_POST["Submit"])) {

      //Query to Delete post in our DataBase
    $ConnectingDB;
    $sql = "DELETE FROM posts WHERE id='$SearchQueryParameter'";

    $Execute = $ConnectingDB->query($sql);

    if ($Execute) {
      $target_Path_To_Delete_Image = "Uploads/$ImageToBeDeleted";
      unlink($target_Path_To_Delete_Image);
      $_SESSION["SuccessMessage"]="Post Deleted Successfully";
      Redirect_to("Posts.php");
    } else {
      $_SESSION['ErrorMessage']= "Something went wrong. Try Again!";
      Redirect_to("Posts.php");
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
  <title>Delete Post</title>
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

          <h1><i class="fas fa-edit" style="color:gray;"></i> Delete Post</h1>

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

        <form class="" action="DeletePost.php?id=<?php echo $SearchQueryParameter; ?>" method="post" enctype="multipart/form-data">
          <div class="card bg-secondary text-light mb-3">

            <div class="card-body bg-dark">
              <div class="form-group">
                <label for="title"><span class="FieldInfo">Post Title: </span></label>
                <input disabled class="form-control" type="text" name="PostTitle" id="title" placeholder="Type title here" value="<?php echo $TitleToBeDeleted; ?>">
              </div>
              <div class="form-group">
                <span class="FieldInfo">Existing Category: </span>
                <?php echo $CategoryToBeDeleted; ?>
                <br>

              </div>

              <div class="form-group">
                <span class="FieldInfo">Existing Image: </span>
                <img class="mb-1" src="Uploads/<?php echo $ImageToBeDeleted; ?>" width="170px"; height="70px";>

              </div>

              <div class="form-group">
                <label for="Post"><span class="FieldInfo">Post: </span> </label>
                <textarea disabled class="form-control" id="Post" name="PostDescription" rows="8" cols="80">
                  <?php echo $PostToBeDeleted; ?>
                </textarea>
              </div>

              <div class="row">

                <div class="col-lg-6 mb-2">
                  <a href="Dashboard.php" class="btn btn-secondary btn-block"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
                </div>

                <div class="col-lg-6 mb-2">
                  <button type="submit" name="Submit" class="btn btn-danger btn-block"><i class="fas fa-trash"></i> Delete</button>
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
