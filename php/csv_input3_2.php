<?php 

include 'header.php';

?>

<div class="container">
  <div class="row">
    <div class="col-lg-6 col-lg-offset-3">
      <h1 class="page-header">Setting CSV Crawler</h1>
      
       
        <?php
        $catalog=$_POST['catalog'];
        $period=$_POST['number'];
        $switch=$_POST['switch'];
        if($catalog=='us'){
          $url = 'https://catalog.data.gov/api/3/action/package_search';
        }else if($catalog=='uk'){
          $url = 'https://data.gov.uk/api/3/action/package_search';
        }else if($catalog=='jp'){
          $url = 'https://ckan.open-governmentdata.org/api/3/action/package_search';
        }else if($catalog=='fk'){
          $url = 'https://data.gov.jp/api/3/action/package_search';
        }
        $conn=pg_connect("host=spacia.db.ics.keio.ac.jp dbname=doi user=doi");
        if (!$conn){
            print "error";
            exit;
        }
        $query="SELECT * FROM crawler_control WHERE url=$1";
        $result=pg_prepare($conn,"q1",$query);
        $result=pg_execute($conn,"q1",array($catalog));
        if(pg_num_rows($result)==1){
          print "<div class='form-group'>";
          print "<label>CSV Crawler 設定変更</label>";
          print"</div>";
          $query2="UPDATE crawler_control SET period = $1, switch = $2 WHERE tag = $3";
          $result2=pg_prepare($conn,"update",$query2);
          $result2=pg_execute($conn,"update",array($period,$switch,$catalog));
        }else{
          print "<div class='form-group'>";
          print "<label>CSV Crawler 新規設定</label>";
          print"</div>";
          $query2="INSERT INTO crawler_control(url,tag,period,switch) VALUES($1,$2,$3,$4)";
          $result2=pg_prepare($conn,"q2",$query2);
          $result2=pg_execute($conn,"q2",array($url,$catalog,$period,$switch));
        }
        if($switch=='t'){
          print"CSV Crawler 起動";
        }else{
          print"CSV Crawler 停止";
        }
        // //存在を確認したいディレクトリ（ファイルでもOK）
        // $directory_path = "./metadata/".$catalog; 
        // //この場合、一つ上の階層に「hoge」というディレクトリが存在するか確認
         
        // //「$directory_path」で指定されたディレクトリが存在するか確認
        // if(file_exists($directory_path)){
        //     //存在したときの処理
        //     echo "フォルダは存在します。";
        //     // chmod($directory_path, 0777);
        // }else{
        //     //存在しないときの処理
        //     echo "フォルダは存在しません。";
        //     // mkdir($directory_path, 0777, true);
        //     // chmod($directory_path, 0777);
        //     echo "フォルダを作成しました。";
        // }
        echo "<br>";
        
        ?>
      

    </div>
  </div>
</div>

<? include 'footer.php'; ?>
