
<?php

class navbar {

  var $numrowsperpage = 10;
  var $str_previous = "Previous page";
  var $str_next = "Next page";

  // These two variables are used internally 
  // by the class' functions
  var $file;
  var $total_records;

  function execute($sql, $db, $type = "mysql") {
    // global variables needed by the function
    global $total_records, $nav_row, $numtoshow; 
    global $result;
    
    // number of records to show at a time
    $numtoshow = $this->numrowsperpage;
    // $nav_row is actually the number of the row of 
    // records (the page number)
    if (!isset($nav_row)) $nav_row = 0;
    
    // the record start number for the SQL query
    $start = $nav_row * $numtoshow;
    // check the database type
    if ($type == "mysql") 
    {
      $result = mysql_query($sql, $db);
      $total_records = mysql_num_rows($result);
      $sql .= " LIMIT $start, $numtoshow";
      $result = mysql_query($sql, $db);
    } 
    elseif ($type == "pgsql")
     {
      $result = pg_Exec($db, $sql);
      $total_records = pg_NumRows($result);
      $sql .= " LIMIT $numtoshow, $start";
      $result = pg_Exec($db, $sql);
      } 
      elseif ($type == "mysqli") 
	  {
		$result = mysqli_query($db, $sql);
		$total_records = mysqli_num_rows($result);
		$sql .= " LIMIT $start, $numtoshow";
		$result = mysqli_query($db, $sql);
      }
    // returns the result set so the user 
    // can handle the data
    return $result;
  }

  function build_geturl()
  {
     // global variables needed by the function
     //global $REQUEST_URI, $REQUEST_METHOD, $HTTP_GET_VARS, $HTTP_POST_VARS;
	global $query_string;
	global $fullfile;
	//global $cgi = array();
	
	// determine what is exactly the current script name
    list($fullfile, $voided) = explode("?", $_SERVER['REQUEST_URI']);
    // remember the script filename for later use
    $this->file = $fullfile;
    // checks the current form method
    $cgi = (($_SERVER['REQUEST_METHOD'] == 'GET') ?  $_GET : $_POST);
    // build the new "GET" type URL to be appended
	reset($cgi);
    while (list($key, $value) = each($cgi)) {
      if ($key != "row")
        $query_string .= "&" . $key . "=" . $value;
    }
    return $query_string;
  }

  function getlinks($option = "all", $show_blank = "off") {
    // global variables needed by the function
    global $total_records, $nav_row, $numtoshow;

    // build the "GET" type URL for the links
    $extra_vars = $this->build_geturl();
    // determine what is exactly the actual script's name
    $file = $this->file;
    // total number of screens
    $number_of_pages = ceil($total_records / $numtoshow);
    // subscript variable for the returned array of links
    $subscript = 0;
    for ($current = 0; $current < $number_of_pages; $current++) {	
      // check if the option asks for this element in the array
      if ((($option == "all") || ($option == "sides")) && ($current == 0)) {
        if ($nav_row != 0)
          $array[0] = '<A HREF="' . $file . '?nav_row=' . ($nav_row - 1) 
                      . $extra_vars . '">' . $this->str_previous . '</A>';
        elseif (($nav_row == 0) && ($show_blank == "on"))
          $array[0] = $this->str_previous;
      }

      if (($option == "all") || ($option == "pages")) {
        if ($nav_row == $current)
          $array[++$subscript] = ($current > 0 ? ($current + 1) : 1);
        else
          $array[++$subscript] = '<A HREF="' . $file . '?nav_row=' . $current 
                            . $extra_vars . '">' . ($current + 1) . '</A>';
      }

      if ((($option == "all") || ($option == "sides")) && ($current == ($number_of_pages - 1))) {
        if ($nav_row != ($number_of_pages - 1))
          $array[++$subscript] = '<A HREF="' . $file . '?nav_row=' . ($nav_row + 1) . $extra_vars 
                            . '">' . $this->str_next . '</A>';
        elseif (($nav_row == ($number_of_pages - 1)) && ($show_blank == "on"))
          $array[++$subscript] = $this->str_next;
      }
    }
    return $array;
  }
}
?>

