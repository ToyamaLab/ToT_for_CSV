<?php 

include 'header.php';

?>

<div class="container">
  <div class="row">
    <div class="col-lg-6 col-lg-offset-3">
      <h1 class="page-header">CSV Bank</h1>
      

        <?php
        $catalog=$_POST['catalog'];
        print"<div class='form-group'>
          <label>".$catalog." Catalog Site</label>
        </div>";
        
        $directory_path="/home/toyama/doi/tot/tot/csv_bank/".$catalog."/";
        if(file_exists($directory_path)){
            //存在したときの処理
            echo $catalog."フォルダは存在します。<br>";
            // chmod($directory_path, 0777);
        }else{
            //存在しないときの処理
            echo $catalog."フォルダは存在しません。<br>";
            // mkdir($directory_path, 0777, true);
            // chmod($directory_path, 0777);
            echo $catalog."フォルダを作成しました。<br>";
        }
        $cmd="ls ".$directory_path." | head -50";
        exec($cmd, $opt);
        $i=0;
        foreach ($opt as $key => $val) {
            ?>
         <form method='post' name='form1' action='csvtodb1.php'>
         <input type='hidden' name='file_name' value='<?php echo $directory_path.$val; ?>'><a href='javascript:form1[<?php echo $i; ?>].submit()'><?php echo $val; ?></a>
  </form>
  <?php
          $i++;
        }
        echo "<br>";
        
        ?>
      

    </div>
  </div>
</div>

<? include 'footer.php'; ?>
