<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<?php require_once("Include/Sessions.php"); ?>
<?php
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
Confirm_Login(); ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="CSS/styles.css">
  <title>Dashboard</title>
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

          <h1><i class="fas fa-cog" style="color:gray;"></i> Dashboard</h1>

        </div>
        <div class="col-lg-3 mb-2">
          <a href="AddNewPost.php" class="btn btn-primary btn-block">
            <i class="fas fa-edit"></i> Add New Post
          </a>
        </div>
        <div class="col-lg-3 mb-2">
          <a href="Categories.php" class="btn btn-info btn-block">
            <i class="fas fa-folder-plus"></i> Add New Category
          </a>
        </div>
        <div class="col-lg-3 mb-2">
          <a href="Admins.php" class="btn btn-warning btn-block">
            <i class="fas fa-user-plus"></i> Add New Admin
          </a>
        </div>
        <div class="col-lg-3 mb-2">
          <a href="Comments.php" class="btn btn-success btn-block">
            <i class="fas fa-check"></i> Approve Comments
          </a>
        </div>
      </div>

    </div>
  </header>

  <!--HEADER END -->

  <!--MAIN AERA-->
  <section class="container py-2 mb-4">
    <div class="row">

      <!-- PHP SCOPE TO CALL FUNCITONS-->
      <?php
      echo ErrorMessage();
      echo SuccessMessage();
       ?>
      <!--END OF PHP SCOPE-->

      <!--LEFT SIDE AREA START-->
      <div class="col-lg-2 d-none d-md-block">
        <div class="card text-center bg-dark text-white mb-3">
          <div class="card-body">
            <h1 class="lead">Posts</h1>
            <h4 class="display-5">
              <i class="fab fa-readme"></i>
              <?php TotalPosts(); ?>
            </h4>
          </div>
        </div>

        <div class="card text-center bg-dark text-white mb-3">
          <div class="card-body">
            <h1 class="lead">Categories</h1>
            <h4 class="display-5">
              <i class="fas fa-folder"></i>
              <?php TotalCategories(); ?>
            </h4>
          </div>
        </div>

        <div class="card text-center bg-dark text-white mb-3">
          <div class="card-body">
            <h1 class="lead">Admins</h1>
            <h4 class="display-5">
              <i class="fas fa-users"></i>
              <?php TotalAdmins(); ?>
            </h4>
          </div>
        </div>

        <div class="card text-center bg-dark text-white mb-3">
          <div class="card-body">
            <h1 class="lead">Comments</h1>
            <h4 class="display-5">
              <i class="fas fa-comments"></i>
              <?php TotalComments(); ?>
            </h4>
          </div>
        </div>
      </div>
      <!--LEFT SIDE AREA END-->

      <!--RIGHT SIDE AREA-->
      <div class="col-lg-10">
        <h1>Top Posts</h1>
        <table class="table table-striped table-hover">
          <thead class="thead-dark">
            <tr>
              <th>No.</th>
              <th>Title</th>
              <th>Date&Time</th>
              <th>Author</th>
              <th>Comments</th>
              <th>Details</th>
            </tr>
          </thead>
          <?php
          $SrNo = 0;
          $ConnectingDB;
          $sql = "SELECT * FROM posts ORDER BY id desc LIMIT 0,5";
          $stmt = $ConnectingDB->query($sql);
          while ($DataRows = $stmt->fetch()) {
            $PostId = $DataRows["id"];
            $DateTime = $DataRows["datetime"];
            $Author = $DataRows["author"];
            $Title = $DataRows["title"];
            $SrNo++;

           ?>
          <tbody>
            <tr>
              <td><?php echo $SrNo; ?></td>
              <td><?php echo $Title; ?></td>
              <td><?php echo $DateTime; ?></td>
              <td><?php echo $Author; ?></td>
              <td>
                <span class="badge badge-success">
                  <?php ApproveCommentsAccordingToPost($PostId); ?>
                </span>
                <span class="badge badge-danger">
                  <?php DisapproveCommentsAccordingToPost($PostId); ?>
                </span>
              </td>
              <td><a target="_blank" href="Fullpost.php?id=<?php echo $PostId; ?>"><span class="btn btn-info">Preview</span></a> </td>
            </tr>
          </tbody>
          <?php } ?>
        </table>
      </div>
      <!--RIGHT SIDE AREA END-->

    </div>
  </section>


  <!--MAIN AERA END-->

  <!--FOOTER-->
  <footer class="bg-dark text-white py-3 fixed-bottom">
    <div class="container">
      <div class="row">
        <div class="col">
          <p class="lead text-center">Theme By | Diogo Oliveira | <span id="year"></span> &copy; ----All Rights Reserved</p>
        </div>
      </div>
    </div>
  </footer>
  <div class="fixed-bottom" style="height:10px; background:gray;"> </div>


  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  <script>
    $('#year').text(new Date().getFullYear());
  </script>
</body>

</html>
