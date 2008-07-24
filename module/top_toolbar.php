<script type="text/javascript" src="./script/validate.js"></script>
<table align="center">
  <tr>
    <td align="center">
        <a class="Nav" href="index.php">Home</a>
    </td>
    <td align="center">
       <a class="Nav" href="query.php">Search</a>
    </td>
     	
<?php include("toolbar_items.php"); ?>

    <td align="center">
        <form name="toolbar" onsubmit="validate(toolbar)" method="get" action="results.php">
          <input type="hidden" name="query_type" value="default" />
          <input type="hidden" name="and" value="false" />
          <input type="hidden" name="artist" />
          <input type="hidden" name="title" />
          <div class="white" style="text-align: center">
            <strong>
              <em>Quick Search:</em>
            </strong>&nbsp;
            <input type="text" name="album" align="right"/>
          </div>
        </form>
      </td>
  </tr>

</table>
