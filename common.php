<?php

/**
  * Escapes HTML for output
  *
  */

/*With this function, we can wrap any variable in the escape() function, and the HTML entities will be protected. */
function escape($html) {
  return htmlspecialchars($html, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
}

/*-------------for pagination---------------*/
function current_page($pages){
  return  $page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
    'options' => array(
        'default'   => 1,
        'min_range' => 1,
    ),
)));

}

function offset_query($page, $limit){
  return $offset = ($page - 1) * $limit;
}

function total_nb_rows($sql, $cnx){
  return $cnx->prepare($sql);
}



/*-----------------------------------------*/
?>