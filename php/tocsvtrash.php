<?php 

include 'header.php';

?>

<div class="container">
  <div class="row">
    <div class="col-lg-6 col-lg-offset-3">
      <h1 class="page-header">CSV Skipping</h1>
        <?php
        $file_name=$_POST['file_name'];
        print"<div class='form-group'>
          <label>".$file_name."</label></div>";
        $array = explode("/", $file_name);
        $path="";
        for($i=0;$i<count($array)-2;$i++){
          $path.=$array[$i]."/";
        }
        $path = str_replace('/csv/', '/csv_trash/', $path);
        $move_file = $path.$array[count($array)-1];
        
        // echo $path;
        chmod($path, 0755);
          if (rename($file_name, $move_file)) {
            // コピーが成功した場合に表示される
            echo 'CSV Skipping';     
          }else{
           
            // コピーが失敗した場合に表示される
            echo 'error';
          }  
        
            ?>

            <br><br>
  <a href="./csv_input4.php">2nd Phase: CSV Formatting</a>
      

    </div>
  </div>
</div>

<? include 'footer.php'; ?>
