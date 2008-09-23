<?php
// Result Table
class table
{
	private $header_html;
	private $row_tmpl;
	private $db;
	
	function __construct($header_html, $row_tmpl, $db) 
	{
    	$this->header_html = $header_html;
		$this->row_tmpl = $row_tmpl; 
		$this->db = $db;
   	}
   	
	// print the table
    public function printOut($sql)
     {
     	// print headers
	   	echo("<table id=\"result\"><tr class=\"header_row\">");
	   	echo($this->header_html);
	    echo("</tr>");
	    
	    $result = mysql_query($sql, $this->db);
	    $len  = mysql_num_fields($result);
	   	   
	   	// print data
	   	while( $row = mysql_fetch_assoc($result) )
		{
			$row_html = $this->row_tmpl;
			for($i = 0; $i < $len; ++$i)
		   	{
				$field = mysql_fetch_field($result, $i);
				$row_html = str_replace("%$field->name%", $row[$field->name], $row_html);
		   	}
		   	echo("<tr id=\"table_row\">$row_html</tr>");
		}
	   	echo("</table>");
    }
}
?>