<?php require "includes/header.php"; ?>
<?php require "config.php" ?>
<?php 


$select = $conn->query("SELECT * FROM posts");
$select->execute();

$rows = $select->fetchAll(PDO::FETCH_OBJ);



?>


<main class="form-signin w-50 m-auto mt-5">
    <?php foreach ($rows as $row) : ?>
<div class="card mt-4">
  <div class="card-body">
    <h5 class="card-title"><?php echo $row->title; ?></h5>
    <p class="card-text"><?php echo substr( $row->body, 0,255). '.......'; ?></p>
    <a href="show.php?id=<?php echo $row->id;  ?>" class="btn btn-primary">More</a>
  </div>
</div>
<?php endforeach; ?>
</main>

<?php require "includes/footer.php"; ?>
