<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<?php require_once("Include/Sessions.php"); ?>
<?php
if (isset($_GET["id"])) {
  $SearchQueryParameter = $_GET["id"];
  $ConnectingDB;
  $Admin = $_SESSION["AdminName"];
  $sql = "UPDATE comments SET status='OFF', approvedby='$Admin' WHERE id='$SearchQueryParameter'";
  $Execute = $ConnectingDB->query($sql);
  if ($Execute) {
    $_SESSION["SuccessMessage"]="Comment Disapproved Successfully!";
    Redirect_to('Comments.php');
  } else {
    $_SESSION["ErrorMessage"]="Something went wrong, try again!";
    Redirect_to('Comments.php');
  }
}
 ?>
