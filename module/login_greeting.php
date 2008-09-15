<?php
if( isset( $enable_security ) && $enable_security == true )
{
	?>
<table class="LogIcon"> 
	<tr>
		<td align="left">
		<img src="./image/user.gif" alt="user" />
		</td>
		<td>
		<?php
		if( isset( $_SESSION['_USER'] ) )
		{
			$local_user = $_SESSION['_USER'];
			echo( "<b>$local_user</b>&nbsp;<a href=\"logout.php\"><b>Logout</b></a>" );	
		}
		else
		{
			echo( "<a href=\"login.php\"><b>Login&nbsp;</b></a>&nbsp;<a href=\"./admin/create_account.php\"><b>(create&nbsp;account)</b></a>" );
		}
			?>	
		</td>
	</tr>
</table>
<?php
}
	?>
