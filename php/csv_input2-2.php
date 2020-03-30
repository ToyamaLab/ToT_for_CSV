<?php 

include 'header.php';

?>

<div class="container">
  <div class="row">
    <div class="col-lg-6 col-lg-offset-3">
    <h1 class="page-header">Table Cutting</h1>
      <?php
          //↓uploadファイルの有り無し確認
        if (is_uploaded_file($_FILES["upfile"]["tmp_name"])) {
        //↓有効なファイルかどうかを検証し、問題なければ名前を変更しアップロード完了
          echo $_FILES["upfile"]["name"];
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
        $startrow=$_POST['startrow'];
        $lastrow=$_POST['lastrow'];
        $startcolumn=$_POST['startcolumn'];
        $lastcolumn=$_POST['lastcolumn'];
          $command="java -classpath ./dbtest1/postgresql-42.2.5.jar: dbtest1/TableCutting /csv/".$_FILES["upfile"]["name"]." ".$startrow." ".$lastrow." ".$startcolumn." ".$lastcolumn;
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
