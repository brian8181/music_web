<script type="text/javascript">
	function on_quick_submit(form) 
	{
		form.elements['artist'].value = form.elements['album'].value;
		form.elements['title'].value = form.elements['album'].value;
	}
</script>
<table align="center">
  <tr>
    <td align="center">
        <a class="Nav" href="index.php">Home</a>
    </td>
    <td align="center">
       <a class="Nav" href="query.php">Search</a>
    </td>
<?php 
include("toolbar_items.php"); 
		?>
  </tr>
</table>
<hr />