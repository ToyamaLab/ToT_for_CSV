<?php 

include 'header.php';

?>

<div class="container">
  <div class="row">
    <div class="col-lg-6 col-lg-offset-3">
    <h1 class="page-header">Cross Table Listing</h1>
      <?php
        //↓uploadファイルの有り無し確認
        if (is_uploaded_file($_FILES["upfile"]["tmp_name"])) {
        //↓有効なファイルかどうかを検証し、問題なければ名前を変更しアップロード完了
          echo $_FILES["upfile"]["tmp_name"];
          echo "<br>\n";
        if (move_uploaded_file($_FILES["upfile"]["tmp_name"], "csv/".$_FILES["upfile"]["name"])) {
          echo "csv/".$_FILES["upfile"]["name"];
          echo "<br>\n";
        chmod("csv/".$_FILES["upfile"]["name"], 0644); //パーミッション設定
        echo $_FILES["upfile"]["name"]."をアップロードしました。";
        } else {
        echo "ファイルをアップロードできません。";
        }
        } else {
        echo "ファイルが選択されていません。";
        }
        $com='which python';
        exec($com, $test);
        echo "テスト結果<br>";
        foreach ($test as $memo){
          print $memo."<br>\n";
        }
        $command="python ./py/pandas_cross3.py -d csv/".$_FILES["upfile"]["name"]." 2>&1";
        if (file_exists('./py/pandas_cross3.py')) {
 
          // ファイルが存在したら、ファイル名を付けて存在していると表示
          echo 'ファイルは存在します。';
         
        } else {
         
          // ファイルが存在していなかったら、見つからないと表示
          echo 'ファイルが見つかりません！';
        }
        echo "<br>";
        $output=array();
        $return_var=null;
        exec($command, $output, $return_var);
        foreach ($output as $line){
          print $line."<br>\n";
        }
        echo $return_var;
        echo "*<br>\n";
          
      ?>
      
      

    

    </div>
  </div>
</div>

<? include 'footer.php'; ?>
