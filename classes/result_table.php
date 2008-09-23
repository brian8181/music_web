<?php
// Result Table
class table
{
	private $columns;
	private $template;
	private $db;
	
	function __construct($columns, $template, $db) 
	{
    	$this->columns = $columns;
		$this->template = $template; 
		$this->db = $db;
   	}
   	
	// print the table
    public function printOut($sql)
     {
	   	//$this->getOptions();
	   	echo("<table id=\"result\"><tr class=\"header_row\">");
	   	$result = mysql_query($sql, $this->db);
	   	$len  = mysql_num_fields($result);
		
	   	// print headers
	   	for($i = 0; $i < $len; ++$i)
	   	{
			$field = mysql_fetch_field($result, $i);
			if( in_array($field->name, $this->columns) )
			{
				echo("<th>$field->name</th>");
			}
	   	}
	   	echo("</tr>");
	   	// print data
	   	while( $row = mysql_fetch_assoc($result) )
		{
			$html_row = "<td>%id%</td><td>%track%</td><td>%year%</td>";
			for($i = 0; $i < $len; ++$i)
		   	{
				$field = mysql_fetch_field($result, $i);
				$html_row = str_replace("%$field->name%", $row[$field->name], $html_row);
		   	}
		   	echo("<tr id=\"table_row\">$html_row</tr>");
		}
	   	echo("</table>");
    }
}
?>