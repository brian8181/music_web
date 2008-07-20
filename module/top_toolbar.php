<script type="text/javascript" src="/script/validate.js"></script>
<table class="BMenu" align="center">
  <tr>
    <td align="center">
      <div id="test">
      </div>
    </td>
    <td align="center">
      <div id="test">
        <a class="Nav" href="index.php">
          Home
        </a>
      </div>
    </td>
    <td align="center">
      <div id="test">
        <a class="Nav" href="query.php">
         Search
        </a>
      </div>
    </td>
    <td align="center">
      <div id="test">
        <a class="Nav" href="adv_query.php">
          Advanced
        </a>
      </div>
    </td>
    <td align="center">
      <div id="test">
        <a class="Nav" href="browse_artist.php">
          Browse
        </a>
      </div>
    </td>
    <td align="center">
      <div id="test">
        <a class="Nav" href="playlists.php">
          Playlists
        </a>
      </div>
    </td>
    <td align="center">
      <div>
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
      </div>
    </td>
  </tr>
</table>
