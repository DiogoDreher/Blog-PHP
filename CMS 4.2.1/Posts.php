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
  <title>Blog Posts</title>
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

          <h1><i class="fas fa-blog" style="color:gray;"></i> Blog Posts</h1>

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
      <div class="col-lg-12">

        <!-- PHP SCOPE TO CALL FUNCITONS-->
        <?php
        echo ErrorMessage();
        echo SuccessMessage();
         ?>
        <!--END OF PHP SCOPE-->

        <table class="table table-striped table-hover">
          <thead class="thead-dark">

          <tr>
            <th>#</th>
            <th>Title</th>
            <th>Category</th>
            <th>Date&Time</th>
            <th>Author</th>
            <th>Banner</th>
            <th>Comments</th>
            <th>Action</th>
            <th>Live Preview</th>
          </tr>
          </thead>
          <?php
          $ConnectingDB;
          //QUERY WHEN PAGINATION IS ACTIVE
          if (isset($_GET["page"])) {
            $Page = $_GET["page"];
            if ($Page==0 || $Page<1) {
              $ShowPostFrom=0;
            } else {
              $ShowPostFrom=($Page*5)-5;
            }
            $sql = "SELECT * FROM posts ORDER BY id desc LIMIT $ShowPostFrom,5";
            $stmt = $ConnectingDB->query($sql);
          }
          //Default SQL query
          else {
            $sql = "SELECT * FROM posts ORDER BY id desc LIMIT 0,3";
            $stmt = $ConnectingDB->query($sql);
          }
          $Sr = 0;
          while ($DataRows = $stmt->fetch()) {
            $Id         = $DataRows["id"];
            $DateTime   = $DataRows["datetime"];
            $PostTitle  = $DataRows["title"];
            $Category   = $DataRows["category"];
            $Admin      = $DataRows["author"];
            $Image      = $DataRows["image"];
            $PostText   = $DataRows["post"];
            $Sr++;
           ?>
          <tbody>
          <tr>
            <td><?php echo $Sr; ?></td>
            <td>
              <?php if (strlen($PostTitle)>20){$PostTitle= substr($PostTitle,0,18). "..";}
              echo $PostTitle; ?></td>
            <td><?php
                  if (strlen($Category)>8){$Category= substr($Category,0,8). "..";}
                  echo $Category; ?></td>
            <td><?php
                  if (strlen($DateTime)>11){$DateTime= substr($DateTime,0,11). "..";}
                  echo $DateTime; ?></td>
            <td><?php
                  if (strlen($Admin)>6){$Admin= substr($Admin,0,6). "..";}
                  echo $Admin; ?></td>
            <td><img src="Uploads/<?php echo $Image; ?>" width="170px;" height="50px"</td>
            <td>
              <span class="badge badge-success">
                <?php ApproveCommentsAccordingToPost($Id); ?>
              </span>
              <span class="badge badge-danger">
                <?php DisapproveCommentsAccordingToPost($Id); ?>
              </span>
            </td>
            <td>
              <a href="EditPost.php?id=<?php echo $Id; ?>"><span class="btn btn-warning mb-1">Edit</span></a>
              <a href="DeletePost.php?id=<?php echo $Id; ?>"><span class="btn btn-danger mb-1">Delete</span></a>
            </td>
            <td><a href="FullPost.php?id=<?php echo $Id; ?>" target="_blank"><span class="btn btn-primary">Live Preview</span> </a> </td>
          </tr>
          </tbody>
          <?php } ?>
        </table>
        <!--PAGINATION-->
        <nav>
          <ul class="pagination pagination-lg">
            <!--CREATING BACKWARDS BUTTON-->
            <?php
            if (isset($Page)) {
              if ($Page>1) {
             ?>
             <li class="page-item">
               <a href="Posts.php?page=<?php echo $Page-1; ?>" class="page-link">&laquo;</a>
             </li>
           <?php } } ?>
            <?php
            $ConnectingDB;
            $sql = "SELECT COUNT(*) FROM posts";
            $stmt = $ConnectingDB->query($sql);
            $RowPagination = $stmt->fetch();
            $TotalPosts = array_shift($RowPagination);
            $PostPagination = $TotalPosts/5;
            $PostPagination = ceil($PostPagination);
            for ($i=1; $i <= $PostPagination ; $i++) {
              if (isset($Page)) {
                if ($i == $Page) { ?>
                  <li class="page-item active">
                    <a href="Posts.php?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
                  </li>
                <?php
                } else { ?>
                  <li class="page-item">
                    <a href="Posts.php?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
                  </li>


            <?php } } } ?>

            <!--CREATING FOWARD BUTTON-->
            <?php
            if (isset($Page)&&!empty($page)) {
              if ($Page+1<=$PostPagination) {
             ?>
             <li class="page-item">
               <a href="Posts.php?page=<?php echo $Page+1; ?>" class="page-link">&raquo;</a>
             </li>
           <?php } } ?>
          </ul>
        </nav>
        <!--PAGINATION END-->
      </div>
    </div>
  </section>


  <!--MAIN AERA END-->

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
