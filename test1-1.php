<form id="logform" method="post">
<div>
<label for="logfiles">Log File</label>
<select id ="logfiles" name="logfiles">
<?php
  function getDirContents($dir) {
      $files = scandir($dir);
      foreach($files as $key => $value){
        $path = realpath($dir.DIRECTORY_SEPARATOR.$value);
        if(!is_dir($path)) {
            yield $path;

        } else if($value != "." && $value != "..") {
           yield from getDirContents($path);
           yield $path;
        }
      }
  }

  $path = "/var/log";
  $files = getDirContents($path);
  foreach ($files as $file)
  {
    if(!is_dir($file)){
      echo "<option>". $file ."</option>";
    }
  }
?>
</select>
<div class="full-width"></br>
  <button type="submit">View Log</button>
</div>
</form>
<?php
if(isset($_POST['logfiles'])) {
  $selectedfile=$_POST['logfiles'];
  echo "<div>";
  echo "<h1>Selected File:" . $selectedfile . "</h1>";
  echo "</div>";

  echo "<pre>";
  passthru("cat " . $selectedfile);
  echo "</pre>";
}
?>
