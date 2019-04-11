<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<?php require_once("Include/Sessions.php"); ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="CSS/styles.css">
  <title>Blog Page</title>
  <style media="screen">
  .heading{
    font-family: Bitter, Georgia, "Times New Roman", Times, Serif;
    font-weight: bold;
    color: #005e90;
  }

  .heading:hover{
    color: #0090db;
  }

  </style>
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
        // SQL query when search button is active
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

        } //QUERY WHEN PAGINATION IS ACTIVE
        elseif (isset($_GET["page"])) {
          $Page = $_GET["page"];
          if ($Page==0 || $Page<1) {
            $ShowPostFrom=0;
          } else {
            $ShowPostFrom=($Page*5)-5;
          }
          $sql = "SELECT * FROM posts ORDER BY id desc LIMIT $ShowPostFrom,5";
          $stmt = $ConnectingDB->query($sql);

        } //QUERY WHEN CATEGORY IS ACTIVE ON URL TAB
        elseif (isset($_GET["category"])) {
          $Category = $_GET["category"];
          $sql = "SELECT * FROM posts WHERE category=:categoryName ORDER BY id desc";
          $stmt = $ConnectingDB->prepare($sql);
          $stmt->bindValue(':categoryName', $Category);
          $stmt->execute();
        }
        //Default SQL query
        else {
          $sql = "SELECT * FROM posts ORDER BY id desc LIMIT 0,3";
          $stmt = $ConnectingDB->query($sql);
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
            <span style="float:right;" class="badge badge-dark text-light">Comments <?php ApproveCommentsAccordingToPost($PostId); ?></span>

            <hr>
            <p class="card-text">
              <?php
              if (strlen($PostDescription)>150) {
                $PostDescription = substr($PostDescription,0,150). "...";
              }
              echo htmlentities($PostDescription) ?>
            </p>
            <a href="FullPost.php?id=<?php echo $PostId; ?>" style="float:right;">
              <span class="btn btn-info">Read More >></span>
            </a>

          </div>
        </div>
        <br>
        <?php } ?>
        <!--PAGINATION-->
        <nav>
          <ul class="pagination pagination-lg">
            <!--CREATING BACKWARDS BUTTON-->
            <?php
            if (isset($Page)) {
              if ($Page>1) {
             ?>
             <li class="page-item">
               <a href="Blog.php?page=<?php echo $Page-1; ?>" class="page-link">&laquo;</a>
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
                    <a href="Blog.php?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
                  </li>
                <?php
                } else { ?>
                  <li class="page-item">
                    <a href="Blog.php?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
                  </li>


            <?php } } } ?>

            <!--CREATING FOWARD BUTTON-->
            <?php
            if (isset($Page)&&!empty($page)) {
              if ($Page+1<=$PostPagination) {
             ?>
             <li class="page-item">
               <a href="Blog.php?page=<?php echo $Page+1; ?>" class="page-link">&raquo;</a>
             </li>
           <?php } } ?>
          </ul>
        </nav>
        <!--PAGINATION END-->

      </div>
      <!--MAIN AREA END-->

      <?php require_once("Include/footer.php"); ?>
