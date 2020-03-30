<?php 

include 'header.php';

?>

<div class="container">
  <div class="row">
    <div class="col-lg-6 col-lg-offset-3">
      <h1 class="page-header">Cross Table Listing</h1>
      <form action="./cross_listing2.php" method="post" enctype="multipart/form-data">
       <div class="form-group">
          <label>CSVファイル選択</label>
          <input type="file" name="upfile" />
        </div>
      
      	<div class="form-group">
      	  <input type="submit" value="upload" class="btn btn-primary col-lg-6 col-lg-offset-3">
      	</div>

    	</form>

    </div>
  </div>
</div>

<? include 'footer.php'; ?>
