<?php 

include 'header.php';

?>

<div class="container">
  <div class="row">
    <div class="col-lg-6 col-lg-offset-3">
      <h1 class="page-header">Ready for conversion</h1>
        <?php
        $file_name=$_POST['file_name'];
        print"<div class='form-group'>
          <label>".$file_name."</label></div>";
        $array = explode("/", $file_name);
        $path="";
        for($i=0;$i<count($array)-2;$i++){
          $path.=$array[$i]."/";
        }
        
        $path = str_replace('/csv/', '/csv_bank/', $path);
        $move_file = $path.$array[count($array)-1];
        $file = explode(".", $array[count($array)-1]);
        // echo $path;
        chmod($path, 0755);
        $cmd = 'find '.$path.' -name "'.$file[0].'*" | wc -l';
        $num = exec($cmd);
        if($num==0){
          if(rename($file_name, $move_file)){
            // コピーが成功した場合に表示される
            echo 'Ready for conversion<br>';
          }else{
            // コピーが失敗した場合に表示される
            echo 'error';
          }
        }else{
          $file = explode(".csv", $move_file);
          $move_file = $file[0]."_".$num.".csv";
          if(rename($file_name, $move_file)){
            // コピーが成功した場合に表示される
            echo 'Ready for conversion<br>';     
          }else{           
            // コピーが失敗した場合に表示される
            echo 'error';
          }  

        }
        
            ?>
  <a href="./csv_input5.php">3rd Phase: CSV Conversion</a>
      

    </div>
  </div>
</div>

<? include 'footer.php'; ?>
