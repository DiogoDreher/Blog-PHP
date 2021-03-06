<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Sessions.php"); ?>
<?php

function Redirect_to($New_Location){
  header("Location:". $New_Location);
  exit;
}

function CheckUsernameExistsOrNot($Username) {
  global $ConnectingDB;
  $sql = "SELECT username FROM admins WHERE username=:userName";
  $stmt = $ConnectingDB->prepare($sql);
  $stmt->bindValue(':userName', $Username);
  $stmt->execute();
  $Result = $stmt->rowcount();
  if ($Result == 1) {
    return true;
  } else {
    return false;
  }
}

function Login_Attempt($Username,$Password){
  global $ConnectingDB;
  $sql = "SELECT * FROM admins WHERE username =:userName AND password=:passWord LIMIT 1";
  $stmt = $ConnectingDB->prepare($sql);
  $stmt->bindValue(':userName', $Username);
  $stmt->bindValue(':passWord', $Password);
  $stmt->execute();
  $Result = $stmt->rowcount();
  if ($Result==1) {
    return $Found_Account= $stmt->fetch();
  } else {
    return null;
  }
}

function Confirm_Login(){
  if (isset($_SESSION["UserId"])) {
    return true;
  } else {
    $_SESSION["ErrorMessage"]="Login Required!";
    Redirect_to("Login.php");
  }
}

function TotalPosts(){
  global $ConnectingDB;
  $sql = "SELECT COUNT(*) FROM posts";
  $stmt = $ConnectingDB->query($sql);
  $TotalRows = $stmt->fetch();
  $TotalPosts = array_shift($TotalRows);
  echo $TotalPosts;
}

function TotalCategories(){
  global $ConnectingDB;
  $sql = "SELECT COUNT(*) FROM category";
  $stmt = $ConnectingDB->query($sql);
  $TotalRows = $stmt->fetch();
  $TotalCategories = array_shift($TotalRows);
  echo $TotalCategories;
}

function TotalAdmins(){
global $ConnectingDB;
$sql = "SELECT COUNT(*) FROM admins";
$stmt = $ConnectingDB->query($sql);
$TotalRows = $stmt->fetch();
$TotalAdmins = array_shift($TotalRows);
echo $TotalAdmins;
}

function TotalComments(){
global $ConnectingDB;
$sql = "SELECT COUNT(*) FROM comments";
$stmt = $ConnectingDB->query($sql);
$TotalRows = $stmt->fetch();
$TotalComments = array_shift($TotalRows);
echo $TotalComments;
}

function ApproveCommentsAccordingToPost($PostId){
  global $ConnectingDB;
  $sqlApprove = "SELECT COUNT(*) FROM comments WHERE post_id='$PostId' AND status='ON'";
  $stmtApprove = $ConnectingDB->query($sqlApprove);
  $RowsTotal = $stmtApprove->fetch();
  $Total = array_shift($RowsTotal);
  echo $Total;
}

function DisapproveCommentsAccordingToPost($PostId){
global $ConnectingDB;
$sqlDisapprove = "SELECT COUNT(*) FROM comments WHERE post_id='$PostId' AND status='OFF'";
$stmtDisapprove = $ConnectingDB->query($sqlDisapprove);
$RowsTotal = $stmtDisapprove->fetch();
$Total = array_shift($RowsTotal);
echo $Total;
}

 ?>
