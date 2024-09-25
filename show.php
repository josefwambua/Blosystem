<?php 

require "includes/header.php"; 
require "config.php"; 
// Check if the user is logged in
if (!isset($_SESSION['username'])) {
  // Optionally, redirect to the login page
  header("Location: login.php");
  exit();
}

if(isset($_GET['id'])){
    $id = $_GET['id'];

    $onePost = $conn->query("SELECT * FROM posts WHERE id = '$id'");
    
    if ($onePost) {
        $posts = $onePost->fetch(PDO::FETCH_OBJ);
    } else {
        echo "There was an error" ;
    }
    $comments = $conn->query("SELECT * FROM comments WHERE post_id = '$id'");
    
    if ($comments) {
        $comment = $comments->fetchAll(PDO::FETCH_OBJ);
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
  <input name="username" type="hidden" value="<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?>" class="form-control" id="username">

</div>


    <div class="form-floating">
      <input name="post_id" type="hidden" value="<?php echo $posts->id; ?>" class="form-control" id="post_id">
    </div>

    <div class="form-floating mt-4">
      <textarea name="comment" rows="20" class="form-control" id="comments" placeholder="comments"></textarea>
      <label for="loatingPassword">Comments</label>
    </div>

    <button name="submit" id="submit" class="w-50 btn btn-lg btn-primary mt-4" type="submit">Comment</button>
    <div id="msg" class="nothing">
    <div id="delete-msg"></div>

  </div>
  </form>
 
</div>


<div class="row">
  <?php foreach ($comment as $singleComment): ?>
<div class="card mt-5">
  <div class="card-body mt-4">
    <h5 class="card-title"><?php echo $singleComment->username; ?></h5>
    <p class="card-text"><?php echo $singleComment->comment; ?></p>
    <?php if(isset($_SESSION['username']) AND $_SESSION['username'] == $singleComment->username) :?>
    <button  id="delete-btn" value="<?php echo $singleComment->id;?>" class="btn btn-lg btn-danger mt-3">Delete Comment</button>
      <?php endif; ?>
  </div>
</div>
<?php endforeach; ?>
</div>




<?php require "includes/footer.php"; ?>


<script>
$(document).ready(function() {
  $('#comment_data').on('submit', function(e) { // Ensure form ID matches
    e.preventDefault();
    var formdata = $(this).serialize() + '&submit=submit';

    $.ajax({
      type: 'post',
      url: 'insert-comments.php',
      data: formdata,
      success: function() {
        $("#comments, #username, #post_id").val(null);
        $("#msg").html("Added successfully").toggleClass("alert alert-success bg-success text-white mt-4");
        fetchComments();
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.error(textStatus, errorThrown);
        alert('An error occurred. Please try again.');
      }
    });
  });

  $('.btn-danger').on('click', function(e) { // Change to class selector
    e.preventDefault();
    var id = $(this).val(); // Get the ID directly

    $.ajax({
      type: 'post',
      url: 'delete-comment.php',
      data: {
        delete: 'delete',
        id: id
      },
      success: function(response) {
        $('#delete-msg').html("Deleted successfully").toggleClass("alert alert-success bg-danger text-white mt-4");
         fetchComments();
        
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.error(textStatus, errorThrown);
        alert('An error occurred. Please try again.');
      }
    });
  });

  function fetchComments() {
    setTimeout(() => {
      $("#comments-container").load("show.php?id=<?php echo $_GET['id']; ?>");
      fetchComments();
    }, 500);
  }
});
</script>
