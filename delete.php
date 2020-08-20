<?php

/**
  * Delete a user
  */

require "./config.php";
require "./common.php";

if (isset($_GET["id"])) {
  try {
    $connection = new PDO($dsn, $username, $password);

    $id = $_GET["id"];

    $sql = "DELETE FROM student WHERE id = :id";

    $statement = $connection->prepare($sql);
    $statement->bindValue(':id', $id);
    $statement->execute();

    $success = "User successfully deleted";
  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }
}

try {
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

<h2>Delete users</h2>

<?php if ($success) echo $success; ?>

<table>
  <thead>
    <tr>
      <th>#</th>
      <th>Name</th>
      <th>Class</th>
      <th>Mark</th>
      <th>Location</th>
      <th>Delete</th>
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
      <td><a href="delete.php?id=<?php echo escape($row["id"]); ?>">Delete</a></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>