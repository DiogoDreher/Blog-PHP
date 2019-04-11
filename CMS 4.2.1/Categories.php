<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<?php require_once("Include/Sessions.php"); ?>
<?php
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
Confirm_Login(); ?>
<?php
if (isset($_POST["Submit"])) {
  $Category = $_POST["CategoryTitle"];
  $Admin = $_SESSION["Username"];

  date_default_timezone_set("Europe/Lisbon");
  $CurrentTime = time();
  $DateTime = strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);

  if (empty($Category)) {
    $_SESSION['ErrorMessage']= "All fields must be filled out";
    Redirect_to("Categories.php");
  } elseif (strlen($Category)<3) {
    $_SESSION['ErrorMessage']= "Category title should be greater than 2 characters";
    Redirect_to("Categories.php");
  } elseif (strlen($Category)>49) {
    $_SESSION['ErrorMessage']= "Category title should be shorter than 50 characters";
    Redirect_to("Categories.php");
  } else {
    //Query to insert category in our DataBase
    $sql = "INSERT INTO category(title, author, datetime)";
    $sql .= "VALUES(:categoryName, :adminName, :dateTime)";
    $stmt = $ConnectingDB->prepare($sql);
    $stmt->bindValue(':categoryName', $Category);
    $stmt->bindValue(':adminName', $Admin);
    $stmt->bindValue(':dateTime', $DateTime);

    $Execute = $stmt->execute();

    if ($Execute) {
      $_SESSION["SuccessMessage"]="Category with id: ".$ConnectingDB->lastInsertId() ." added successfully";
      Redirect_to("Categories.php");
    } else {
      $_SESSION['ErrorMessage']= "Something went wrong. Try Again!";
      Redirect_to("Categories.php");
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
  <title>Categories</title>
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

          <h1><i class="fas fa-edit" style="color:gray;"></i> Manage Categories</h1>

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

        <form class="" action="Categories.php" method="post">
          <div class="card bg-secondary text-light mb-3">

            <div class="card-header">
              <h1>Add New Category</h1>
            </div>

            <div class="card-body bg-dark">
              <div class="form-group">
                <label for="title"><span class="FieldInfo">Category Title: </span></label>
                <input class="form-control" type="text" name="CategoryTitle" id="title" placeholder="Type title here" value="">
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
        <h2>Existing categories</h2>

        <table class="table table-striped table-hover">
          <thead class="thead-dark">
            <tr>
              <th>No. </th>
              <th>Category Name</th>
              <th>Date&Time</th>
              <th>Creator name</th>
              <th>Action</th>
            </tr>
          </thead>

        <?php
        $ConnectingDB;
        $sql = "SELECT * FROM category ORDER BY id desc";
        $Execute= $ConnectingDB->query($sql);
        $SrNo = 0;
        while ($DataRows=$Execute->fetch()) {
          $CategoryId = $DataRows["id"];
          $CategoryDate = $DataRows['datetime'];
          $CategoryName = $DataRows["title"];
          $CreatorName = $DataRows["author"];
          $SrNo++;
         ?>
        <tbody>
          <tr>
            <td><?php echo htmlentities($SrNo); ?></td>
            <td><?php echo htmlentities($CategoryName); ?></td>
            <td><?php echo htmlentities($CategoryDate); ?></td>
            <td><?php echo htmlentities($CreatorName); ?></td>
            <td><a class="btn btn-danger" href="DeleteCategory.php?id=<?php echo $CategoryId ?>">Delete</a></td>
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
