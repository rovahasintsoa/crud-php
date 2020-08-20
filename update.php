<?php

/**
  * List all users with a link to edit
  */

try {
  require "./config.php";
  require "./common.php";

  $connection = new PDO($dsn, $username, $password);

  $sql = "SELECT * FROM student";

  $statement = $connection->prepare($sql);
  $statement->execute();

  $result = $statement->fetchAll();
  

} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
?>



<?php require "templates/header.php"; ?>

<h2>Update users</h2>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Name</th>
      <th>Class</th>
      <th>Mark</th>
      <th>Location</th>
      <th>Edit</th>
    </tr>
  </thead>
    <tbody>
    <?php foreach ($result as $row) : ?>
      <tr>
      <td><?php echo escape($row["id"]); ?></td>
      <td><?php echo escape($row["name"]); ?></td>
      <td><?php echo escape($row["class"]); ?></td>
      <td><?php echo escape($row["mark"]); ?></td>
      <td><?php echo escape($row["location"]); ?></td>
      <td><a href="update-single.php?id=<?php echo escape($row["id"]); ?>">Edit</a></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>