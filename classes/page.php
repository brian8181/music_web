<?php
include_once("./config/config.php");
abstract class page
{
	abstract protected function getOptions();
	public function printOptions() {
		echo( getOptions() );
	}
	abstract protected function getHeaders();
	public function printHeaders()
	{
		echo( $this->getHeaders() );
	}
	abstract protected function getFooters();
	public function printFooters()
	{
		echo( $this->getFooters() );
	}
}

class music_page extends page
{
	var $style;
	function __construct($style) {
       $this->$style = $style; 
   	}
   	
	protected function getOptions()
	{
		return "";
	}
	
	protected function getHeaders()
	{
		?><!--  -->
		<head>
    		<title>My Settings</title>
    		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    		<link rel="shortcut icon" href="./favicon.png" />
			<link rel="stylesheet" type="text/css" href="<?php echo( get_style() ); ?>" />
		</head>
		<?php 
	}
	
	protected function getFooters()
	{
	}
}
?>