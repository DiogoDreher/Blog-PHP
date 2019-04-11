<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<?php require_once("Include/Sessions.php"); ?>
<?php
if (isset($_SESSION["UserId"])) {
  Redirect_to("Dashboard.php");
}
if (isset($_POST["Submit"])) {
  $Username = $_POST["Username"];
  $Password = $_POST["Password"];
  if (empty($Username)||empty($Password)) {
    $_SESSION["ErrorMessage"]= "All fields must be filled out!";
    Redirect_to("Login.php");
  } else {
    // CHECK USERNAME AND PASSWORD FROM DATABASE
    $Found_Account = Login_Attempt($Username,$Password);
    if ($Found_Account) {
      $_SESSION["UserId"] = $Found_Account["id"];
      $_SESSION["Username"] = $Found_Account["username"];
      $_SESSION["AdminName"] = $Found_Account["aname"];
      $_SESSION["SuccessMessage"]= "Welcome ". $_SESSION["AdminName"]. "!";
      if (isset($_SESSION["TrackingURL"])) {
        Redirect_to($_SESSION["TrackingURL"]);
      } else {
      Redirect_to("Dashboard.php");
    }} else {
      $_SESSION["ErrorMessage"]= "Incorrect Username/Password";
      Redirect_to("Login.php");
    }
  }
} ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="CSS/styles.css">
  <title>Login</title>
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
        </div>
      </div>

    </div>
  </header>

  <!--HEADER END -->

  <!--MAIN AREA-->
  <section class="container py-2 mb-4">
    <div class="row">
      <div class=" offset-sm-3 col-sm-6" style="min-height:716px;">
        <br><br>

        <!-- PHP SCOPE TO CALL FUNCITONS-->
        <?php
        echo ErrorMessage();
        echo SuccessMessage();
         ?>
        <!--END OF PHP SCOPE-->

        <div class="card bg-secondary text-light">
          <div class="card-header">
            <h4>Welcome Back!</h4>
          </div>
            <div class="card-body bg-dark">
            <form class="" action="Login.php" method="post">
              <div class="form-group">
                <label for="username"><span class="FieldInfo">Username:</span> </label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text text-white bg-info"><i class="fas fa-user"></i> </span>
                  </div>
                  <input type="text" class="form-control" name="Username" id="username" value="">
                </div>
              </div>
              <div class="form-group">
                <label for="password"><span class="FieldInfo">Password:</span> </label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text text-white bg-info"><i class="fas fa-lock"></i> </span>
                  </div>
                  <input type="password" class="form-control" name="Password" id="password" value="">
                </div>
              </div>
              <input type="submit" name="Submit" class="btn btn-info btn-block" value="Login">
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--MAIN AREA END-->

  <br>

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
