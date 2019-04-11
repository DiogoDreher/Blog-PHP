<!--SIDE AREA-->
<div class="col-sm-4">
  <div class="card mt-4">
    <div class="card-body">
      <img src="Images/start-blog.png" class="display-block img-fluid mb-3" alt="">
      <div class="text-center">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
      </div>
    </div>
  </div>
  <br>
  <div class="card-header bg-dark text-light">
    <h2 class="lead">Sign Up!</h2>
  </div>
  <div class="card-body">
    <button type="button" class="btn btn-success btn-block text-center text-white mb-4" name="button">Join the Force</button>
    <button type="button" class="btn btn-danger btn-block text-center text-white mb-4" name="button">Login</button>
    <div class="input-group mb-3">
      <input type="text" class="form-control" placeholder="Enter your Email" name="" value="">
      <div class="input-group-append">
        <button type="button" class="btn btn-primary btn-sm text-center text-white" name="button">Subscribe Now!</button>
      </div>
    </div>
  </div>
  <br>
  <div class="card">
    <div class="card-header bg-primary text-light">
      <h2 class="lead">Categories</h2>
      </div>
      <div class="card-body">
        <?php
        $ConnectingDB;
        $sql = "SELECT * FROM category ORDER BY id desc";
        $stmt = $ConnectingDB->query($sql);
        while ($DataRows = $stmt->fetch()) {
          $CategoryId = $DataRows['id'];
          $CategoryName = $DataRows['title'];

         ?>

        <a href="Blog.php?category=<?php echo htmlentities($CategoryName); ?>"> <span class="heading"><?php echo $CategoryName; ?></span></a><br>

        <?php } ?>

    </div>
  </div>
  <br>
  <div class="card">
    <div class="card-header bg-info text-white">
      <h2 class="lead">Recent Posts</h2>
    </div>
    <div class="card-body">
      <?php
      $ConnectingDB;
      $sql = "SELECT * FROM posts ORDER BY id desc LIMIT 0,5";
      $stmt = $ConnectingDB->query($sql);
      while ($DataRows=$stmt->fetch()) {
        $Id = $DataRows['id'];
        $Title = $DataRows['title'];
        $DateTime = $DataRows['datetime'];
        $Image = $DataRows['image'];

       ?>
      <div class="media">
        <img src="Uploads/<?php echo htmlentities($Image); ?>" class="display-block img-fluid alling-self-start" width="90" height="94" alt="">
        <div class="media-body ml-2">
          <a href="FullPost.php?id=<?php echo htmlentities($Id); ?>" target="_blank"><h6 class="lead"><?php echo $Title; ?></h6></a>
          <p class="small"><?php echo htmlentities($DateTime); ?></p>
        </div>
      </div>
      <hr>
      <?php } ?>
    </div>
  </div>
</div>
<!--SIDE AREA END-->
</div>
</div>

<!--HEADER END -->
<br>
<!--FOOTER-->
<footer class="bg-dark text-white py-3 mt-auto">
<div class="container">
<div class="row">
  <div class="col">
    <p class="lead text-center">Theme By | Diogo Oliveira | <span id="year"></span> &copy; ----All Rights Reserved</p>
  </div>
</div>
</div>
</footer>
<div class="" style="height:10px; background:gray;"> </div>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script>
$('#year').text(new Date().getFullYear());
</script>
</body>

</html>
