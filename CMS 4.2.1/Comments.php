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
  <title>Comments</title>
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

          <h1><i class="fas fa-comments" style="color:gray;"></i> Manage Comments</h1>

        </div>
      </div>

    </div>
  </header>

  <!--HEADER END -->

  <!--MAIN AREA -->
  <section class="container py-2 mb-4">
    <div class="row" style="min-height:30px;">
      <div class="col-lg-12" style="min-height:400px;">

        <h2>Un-Approved Comments</h2>

        <!-- PHP SCOPE TO CALL FUNCITONS-->
        <?php
        echo ErrorMessage();
        echo SuccessMessage();
         ?>
        <!--END OF PHP SCOPE-->

        <table class="table table-striped table-hover">
          <thead class="thead-dark">
            <tr>
              <th>No. </th>
              <th>Name</th>
              <th>Date&Time</th>
              <th>Comment</th>
              <th>Approve</th>
              <th>Delete</th>
              <th>Details</th>
            </tr>
          </thead>

        <?php
        $ConnectingDB;
        $sql = "SELECT * FROM comments WHERE status='OFF' ORDER BY id desc";
        $Execute= $ConnectingDB->query($sql);
        $SrNo = 0;
        while ($DataRows=$Execute->fetch()) {
          $CommentId = $DataRows["id"];
          $DateTimeOfComment = $DataRows['datetime'];
          $CommenterName = $DataRows["name"];
          $CommentContent = $DataRows["comment"];
          $CommentPostId = $DataRows["post_id"];
          $SrNo++;
          if (strlen($CommenterName)>10) {
            $CommenterName = substr($CommenterName,0,10). '..';
          }

         ?>
        <tbody>
          <tr>
            <td><?php echo htmlentities($SrNo); ?></td>
            <td><?php echo htmlentities($CommenterName); ?></td>
            <td><?php echo htmlentities($DateTimeOfComment); ?></td>
            <td><?php echo htmlentities($CommentContent); ?></td>
            <td><a class="btn btn-success" href="ApproveComment.php?id=<?php echo $CommentId ?>">Approve</a></td>
            <td><a class="btn btn-danger" href="DeleteComment.php?id=<?php echo $CommentId ?>">Delete</a></td>
            <td><a class="btn btn-primary" href="FullPost.php?id=<?php echo $CommentPostId; ?>" target="_blank">Live Preview</a> </td>
          </tr>
        </tbody>
        <?php } ?>
        </table>

        <h2>Approved Comments</h2>

        <!-- PHP SCOPE TO CALL FUNCITONS-->
        <?php
        echo ErrorMessage();
        echo SuccessMessage();
         ?>
        <!--END OF PHP SCOPE-->

        <table class="table table-striped table-hover">
          <thead class="thead-dark">
            <tr>
              <th>No. </th>
              <th>Name</th>
              <th>Date&Time</th>
              <th>Comment</th>
              <th>Revert</th>
              <th>Delete</th>
              <th>Details</th>
            </tr>
          </thead>

        <?php
        $ConnectingDB;
        $sql = "SELECT * FROM comments WHERE status='ON' ORDER BY id desc";
        $Execute= $ConnectingDB->query($sql);
        $SrNo = 0;
        while ($DataRows=$Execute->fetch()) {
          $CommentId = $DataRows["id"];
          $DateTimeOfComment = $DataRows['datetime'];
          $CommenterName = $DataRows["name"];
          $CommentContent = $DataRows["comment"];
          $CommentPostId = $DataRows["post_id"];
          $SrNo++;
          if (strlen($CommenterName)>10) {
            $CommenterName = substr($CommenterName,0,10). '..';
          }

         ?>
        <tbody>
          <tr>
            <td><?php echo htmlentities($SrNo); ?></td>
            <td><?php echo htmlentities($CommenterName); ?></td>
            <td><?php echo htmlentities($DateTimeOfComment); ?></td>
            <td><?php echo htmlentities($CommentContent); ?></td>
            <td><a class="btn btn-warning" href="DisapproveComment.php?id=<?php echo $CommentId ?>">Disapprove</a></td>
            <td><a class="btn btn-danger" href="DeleteComment.php?id=<?php echo $CommentId ?>">Delete</a></td>
            <td><a class="btn btn-primary" href="FullPost.php?id=<?php echo $CommentPostId; ?>" target="_blank">Live Preview</a> </td>
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
