<?php require "includes/header.php"; ?>
<?php require "config.php" ?>

<?php  


if(isset($_GET['id'])){


    $id = $_GET['id'];

    $onePost = $conn->query("SELECT * FROM posts WHERE id = '$id'");
      $onePost->execute();
      
      
      $posts = $onePost->fetch(PDO::FETCH_OBJ);
}


?>
<div class="row">
<div class="card mt-5">
  <div class="card-body mt-4">
    <h5 class="card-title"><?php echo $posts->title; ?></h5>
    <p class="card-text"><?php echo $posts->body; ?></p>
   
  </div>
</div>
</div>



<?php require "includes/footer.php"; ?>
