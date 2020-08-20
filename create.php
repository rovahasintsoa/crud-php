<?php

/**
  * Use an HTML form to create a new entry in the
  * users table.
  *
  */


//Tell the code TO ONLY run if the form has been submitted  
if (isset($_POST['submit'])){
    require "config.php";
    try {
        $connection = new PDO($dsn, $username, $password);
        // insert new user code will go here
        $new_user = array(
            "name" => $_POST['name'],
            "class"  => $_POST['class'],
            "mark"     => $_POST['mark'],
            "location" => $_POST['location']
           );
          $sql = sprintf(
            "INSERT INTO %s (%s) values (%s)",
            "student",
            implode(", ", array_keys($new_user)),
            ":" . implode(", :", array_keys($new_user))
        );

        $statement = $connection->prepare($sql);
        $statement->execute($new_user);

        } catch(PDOException $error) {
            echo $sql . "<br>" . $error->getMessage(); // we need to define the sql action when the submit button is clicked on, i.e we want to insert a user details
        }
}
?>

<!-- We are using the same templates -->

<?php include "templates/header.php";require "../vendor\autoload.php"; require "common.php";?>

<?php if (isset($_POST['submit']) && $statement) { ?>
  <?php echo $_POST['name']; ?> successfully added.
<?php } ?>

    <h2>Add a user</h2>
    <form method="post">
        <label for="name">Name</label>
        <input type="text" name="name" id="name">

        <label for="class">Class</label>
        <input type="text" name="class" id="class">

        <label for="email">Mark</label>
    	<input type="text" name="mark" id="mark">
    
        <label for="location">Location</label>
    	<input type="text" name="location" id="location">
    	
        <input type="submit" name="submit" value="Submit">
    </form>
    <a href="index.php">Back to home</a>


<?php include "templates/footer.php";require "../vendor\autoload.php";?>
