<?php 

include 'header.php';

?>

<div class="container">
  <div class="row">
    <div class="col-lg-6 col-lg-offset-3">
      <h1 class="page-header">Operation Log</h1>
      <form action="./log_list.php" method="post" enctype="multipart/form-data">
       <!-- <div class="form-group">
          <label>カタログサイト指定</label>
          <input type="file" name="upfile" />
        </div> -->
        <div class="form-group">
          <label>Select Catalog Site</label>
        <select name="catalog" class="form-control">
          <option value='' disabled selected style='display:none;'>Please select</option>
          <option value="us">US</option>
          <option value="uk">UK</option>
          <option value="jp">JP</option>
          <option value="fk">FK</option>
          <option value="us3">US(ver2)</option>
        </select>
        
        <?php
        // $command='python ./py/exec_from_php.py';
        // if (file_exists('./py/exec_from_php.py')) {
 
        //   // ファイルが存在したら、ファイル名を付けて存在していると表示
        //   echo 'ファイルは存在します。';
         
        // } else {
         
        //   // ファイルが存在していなかったら、見つからないと表示
        //   echo 'ファイルが見つかりません！';
        // }
        // echo "<br>";
        // exec($command,$output);
        // print $output[0]."<br>";
        // print $output[1]."<br>";
        ?>
      	<div class="form-group">
      	  <input type="submit" value="Set" class="btn btn-primary col-lg-6 col-lg-offset-3">
      	</div>

    	</form>

    </div>
  </div>
</div>

<? include 'footer.php'; ?>
