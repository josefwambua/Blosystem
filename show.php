<?php 

require "includes/header.php"; 
require "config.php"; 

if(isset($_GET['id'])){
    $id = $_GET['id'];

    $onePost = $conn->query("SELECT * FROM posts WHERE id = '$id'");
    
    if ($onePost) {
        $posts = $onePost->fetch(PDO::FETCH_OBJ);
    } else {
        echo "There was an error" ;
    }
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

<div class="row">
  <form method="POST" id="comment_data">
  <div class="form-floating">
  
  <div class="form-floating">
      <input name="username" type="hidden" value="<?php echo $_SESSION['username']; ?>" class="form-control" id="username">
    </div>


    <div class="form-floating">
      <input name="post_id" type="hidden" value="<?php echo $posts->id; ?>" class="form-control" id="post_id">
    </div>

    <div class="form-floating mt-4">
      <textarea name="comment" rows="20" class="form-control" id="comments" placeholder="comments"></textarea>
      <label for="loatingPassword">Comments</label>
    </div>

    <button name="submit" id="submit" class="w-50 btn btn-lg btn-primary mt-4" type="submit">Comment</button>
  </form>
</div>



<?php require "includes/footer.php"; ?>



<script>
  $(document).ready(function(){
    $(document).on('submit', function(){
      //alert("Form submitted")
      var formdata = $("#comment_data").serialize()+'&submit=submit';

      $.ajax({
        type : 'post',
        url: 'insert-comments.php',
        data:formdata,
        success :function(){
          alert('success');
        }
      })
    });
  });
</script>