<?php require "includes/header.php"; ?>
<?php require "config.php"; ?>

<?php 

if(!isset($_SESSION['username'])) {
  header("location: index.php");
}




  if(isset($_POST['submit'])) {

    if($_POST['title'] == '' OR $_POST['body'] == '') {
      echo "some inputs are empty";
      
    } else {


      $title = $_POST['title'];
      $body = $_POST['body'];
      $username = $_SESSION['username'];

      $insert = $conn->prepare("INSERT INTO posts (title, body, username) 
       VALUES (:title, :body, :username)");

       $insert->execute([
        ':title' => $title,
        ':body' => $body,
        ':username' => $username ,
       ]);

       header("Location:index.php");
    }
  }



?>

<main class="form-signin w-50 m-auto">
  <form method="POST" action="create.php">
    <!-- <img class="mb-4 text-center" src="/docs/5.2/assets/brand/bootstrap-logo.svg" alt="" width="72" height="57"> -->
    <h1 class="h3 mt-5 fw-normal text-center">Create Post</h1>

    <div class="form-floating">
      <input name="title" type="text" class="form-control" id="floatingInput" placeholder="title">
      <label for="floatingInput">Title</label>
    </div>


    <div class="form-floating mt-4">
    <textarea name="body" rows="50" cols= "100" class="form-control" placeholder="body"></textarea>
    <label for="loatingPassword">Body</label>
    </div>

    <button name="submit" class="w-50 btn btn-lg btn-primary mt-4" type="submit">Create Post</button>

  </form>
</main>

<?php require "includes/footer.php"; ?>
