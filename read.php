<!-- Query user page-->
<?php

if (isset($_POST['submit'])) {
    try {
      require "config.php";
      require "common.php";
  
      $connection = new PDO($dsn, $username, $password);
      $location = $_POST['location'];
      
      // fetch data code will go here
          //-----pagination-----

          // Find out how many items are in the table

        /*$total = "SELECT COUNT(*)
        FROM users"; */
        $nb_rows = $connection->prepare('SELECT COUNT(*)
        FROM student 
        WHERE location = :location
        '); //->fetchColumn();
        $nb_rows->bindParam(':location', $location, PDO::PARAM_STR);

        $nb_rows->execute();
        $total = $nb_rows->fetchColumn();
        //echo("total rows= " .$total);

    // How many items to list per page
    

    // How many pages will there be
    $pages = ceil($total / $limit);

    // What page are we currently on?
    $page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
        'options' => array(
            'default'   => 1,
            'min_range' => 1,
        ),
    )));

    // Calculate the offset for the query
    $offset = ($page - 1)  * $limit;

    // Some information to display to the user
    $start = $offset + 1;
    $end = min(($offset + $limit), $total);

    
          //-----end of pagination ----

        // Prepare the paged query
        $statement = $connection->prepare('
        SELECT *
        FROM student
        WHERE location = :location
        LIMIT
        :limit
    OFFSET
        :offset
    ');
    /*
LIMIT
            :limit
        OFFSET
            :offset
    */
    
    // Bind the query params
    $statement->bindParam(':limit', $limit, PDO::PARAM_INT);
    $statement->bindParam(':offset', $offset, PDO::PARAM_INT);
    $statement->bindParam(':location', $location, PDO::PARAM_STR);

    $statement->execute();
    $result = $statement->fetchAll();
    


    } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
    }
  }
  else {
    try {
      require "config.php";
      require "common.php";
  
      $connection = new PDO($dsn, $username, $password);
          
    //-----pagination-----
    
    // Find out how many items are in the table
    
    /*$total = "SELECT COUNT(*)
        FROM users"; */
    $total = $connection->query('SELECT COUNT(*)
        FROM student')->fetchColumn(); 
    
    
    // How many pages will there be
    $pages = ceil($total / $limit);
    
    // What page are we currently on?
    $page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
        'options' => array(
            'default'   => 1,
            'min_range' => 1,
        ),
    )));

    // Calculate the offset for the query
    $offset = ($page - 1)  * $limit;
 
    // Some information to display to the user
    $start = $offset + 1;
    $end = min(($offset + $limit), $total);


        //-----end of pagination ----


        // Prepare the paged query
    $statement = $connection->prepare('
    SELECT
        *
    FROM
        student
    LIMIT
        :limit
    OFFSET
        :offset
');

// Bind the query params
$statement->bindParam(':limit', $limit, PDO::PARAM_INT);
$statement->bindParam(':offset', $offset, PDO::PARAM_INT);
$statement->execute();
$result = $statement->fetchAll();
    } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
    }

  }
  ?>
<!-- Query user page -- end of the section-->

<?php require "templates/header.php";require "../vendor\autoload.php";?>

<?php
if( !isset($_POST['sumbmit']))
 {// echo "Row count statement ". $statement->rowCount(); ?>

<?php 
  // Define how we want to fetch the results
  $statement->setFetchMode(PDO::FETCH_ASSOC);
  $iterator = new IteratorIterator($statement);
?>

  <h2>Data</h2>

<table>
  <thead>
<tr>
<th>Id</th>
  <th>Name</th>
  <th>Class</th>
  <th>Mark</th>
  <th>Location</th>
</tr>
  </thead>
  <tbody>
   
<?php 
        // Display the results

foreach ($result as $row) { ?>
  <tr>
<td><?php echo escape($row["id"]); ?></td>
<td><?php echo escape($row["name"]); ?></td>
<td><?php echo escape($row["class"]); ?></td>
<td><?php echo escape($row["mark"]); ?></td>
<td><?php echo escape($row["location"]); ?></td>
  </tr>
<?php } ?>
  </tbody>
</table>

<?php 
    // The "back" link
    $prevlink = ($page > 1) ? '<a href="?page=1" title="First page">&laquo;</a> <a href="?page=' . ($page - 1) . '" title="Previous page">&lsaquo;</a>' : '<span class="disabled">&laquo;</span> <span class="disabled">&lsaquo;</span>';

    // The "forward" link
    $nextlink = ($page < $pages) ? '<a href="?page=' . ($page + 1) . '" title="Next page">&rsaquo;</a> <a href="?page=' . $pages . '" title="Last page">&raquo;</a>' : '<span class="disabled">&rsaquo;</span> <span class="disabled">&raquo;</span>';

    // Display the paging information
    echo '<div id="paging"><p>', $prevlink, ' Page ', $page, ' of ', $pages, ' pages, displaying ', $start, '-', $end, ' of ', $total, ' results ', $nextlink, ' </p></div>';

?>

<?php }

//---------------IF Button pushed-----------------------

else if (isset($_POST['submit'])) {
  if ($result && $statement->rowCount() > 0) { ?>

<?php 
  // Define how we want to fetch the results
  $statement->setFetchMode(PDO::FETCH_ASSOC);
  $iterator = new IteratorIterator($statement);
?>
    <h2>Results</h2>

<div>
<table>
      <thead>
<tr>
  <th>Id</th>
  <th>Name</th>
  <th>Class</th>
  <th>Mark</th>
  <th>Location</th>
</tr>
      </thead>
      <tbody>
  <?php echo $iterator; foreach ($iterator as $row) { ?>
      <tr>
<td><?php echo escape($row["id"]); ?></td>
<td><?php echo escape($row["name"]); ?></td>
<td><?php echo escape($row["class"]); ?></td>
<td><?php echo escape($row["mark"]); ?></td>
<td><?php echo escape($row["location"]); ?></td>
      </tr>
    <?php } ?>
      </tbody>
  </table>
</div>


  <?php
  // The "back" link
  $prevlink = ($page > 1) ? '<a href="?page=1" title="First page">&laquo;</a> <a href="?page=' . ($page - 1) . '" title="Previous page">&lsaquo;</a>' : '<span class="disabled">&laquo;</span> <span class="disabled">&lsaquo;</span>';

  // The "forward" link
  $nextlink = ($page < $pages) ? '<a href="?page=' . ($page + 1) . '" title="Next page">&rsaquo;</a> <a href="?page=' . $pages . '" title="Last page">&raquo;</a>' : '<span class="disabled">&rsaquo;</span> <span class="disabled">&raquo;</span>';

  // Display the paging information
  echo '<div id="paging"><p>', $prevlink, ' Page ', $page, ' of ', $pages, ' pages, displaying ', $start, '-', $end, ' of ', $total, ' results ', $nextlink, ' </p></div>';

  ?>


  <?php } else { ?>
    No results found for <?php echo escape($_POST['location']); ?>.
  <?php }
} ?>

<!--
<h2>Find user based on location</h2>




    <form method="post">
        <label for="location">Location</label>
        <input type="text" name="location" id="location">
        <input type="submit" name="submit" value="Submit">
    </form> -->
    <a href="index.php">Back to home</a>

<?php include "templates/footer.php"; require "../vendor\autoload.php";?>