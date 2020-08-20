<!-- Query user page-->
<?php

if (isset($_POST['submit'])) {
    try {
      require "config.php";
      require "common.php";
  
      $connection = new PDO($dsn, $username, $password);
          // fetch data code will go here
          //-----pagination-----
          $location = $_POST['location'];
          // Find out how many items are in the table

        $nb_rows = total_nb_rows('SELECT COUNT(*) 
        FROM student WHERE location = :location', $connection); 
        $nb_rows->bindParam(':location', $location, PDO::PARAM_STR);
        

        $nb_rows->execute();
        $total = $nb_rows->fetchColumn();
        

        // How many pages will there be
        $pages = ceil($total / $limit);
        echo "Total: " .$total;
        echo "pages: " .$pages;
        echo "limit: " .$limit;
        // What page are we currently on?
        
        $page = current_page($pages);


        // Calculate the offset for the query
        $offset = offset_query($pages, $limit);
        echo "offset: " .$offset;
        

        // Some information to display to the user
        $start = $offset + 1;
        $end = min(($offset + $limit), $total);

    
          //-----end of pagination ----

        // Prepare the paged query
        $statement = $connection->prepare('
        SELECT *
        FROM student
        WHERE location = :location
        
   
    ');

    $statement->bindParam(':location', $location, PDO::PARAM_STR);
    //$statement->bindParam(':offset', $offset, PDO::PARAM_INT);
    //$statement->bindParam(':limit', $limit, PDO::PARAM_INT);
    
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
if (isset($_POST['submit']) ) {
  if ($result && $statement->rowCount() > 0) { ?>
    <?php 
  // Define how we want to fetch the results
  //$statement->setFetchMode(PDO::FETCH_ASSOC);
  //$iterator = new IteratorIterator($statement);


?>


    <h2>Results</h2>
    <table>
      <thead>
<tr>
  <th>#</th>
  <th>First Name</th>
  <th>Last Name</th>
  <th>Email Address</th>
  <th>Age</th>
  <th>Location</th>
  <th>Date</th>
</tr>
      </thead>
      <tbody>
  <?php foreach ($result as $row) { ?>
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
  <?php } else { ?>
     No results found for <?php echo escape($_POST['location']); ?>.
  <?php }
} ?>

<h2>Find user based on location</h2>

<form method="post">
  <label for="location">Location</label>
  <input type="text" id="location" name="location">
  <input type="submit" name="submit" value="View Results">
</form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>