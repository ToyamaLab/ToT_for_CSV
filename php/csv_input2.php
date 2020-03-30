<?php 

include 'header.php';

?>


<div class="container">
  <div class="row">
    <div class="col-lg-6 col-lg-offset-3">
      <h1 class="page-header">Table Cutting</h1>
<?php
if(!isset($_POST['select'])){
print<<<EOF
      <form action="./csv_input2.php" method="post" enctype="multipart/form-data">
       <div class="form-group">
          <label>CSVファイル選択</label>
          <input type="file" name="upfile" />
        </div>
        <div class="form-group">
          <input type="submit" name="select" value="output" class="btn btn-primary col-lg-6 col-lg-offset-3">
        </div>
      </form>
EOF;
}else{
if (is_uploaded_file($_FILES["upfile"]["tmp_name"])) {
  $file_tmp_name = $_FILES["upfile"]["tmp_name"];
  $file_name = $_FILES["upfile"]["name"];
  echo $file_name;
  //拡張子を判定
  if (pathinfo($file_name, PATHINFO_EXTENSION) != 'csv') {
    $err_msg = 'CSVファイルのみ対応しています。';
  } else {
    //ファイルをdataディレクトリに移動
    if (move_uploaded_file($file_tmp_name, "./data/uploaded/".$file_name)) {
      //後で削除できるように権限を644に
      chmod("./data/uploaded/".$file_name, 0644);
      $msg = $file_name . "をアップロードしました。";
      $file = './data/uploaded/'.$file_name;
      $fp   = fopen($file, "r");

      //配列に変換する
      while (($data = fgetcsv($fp, 0, ",")) !== FALSE) {
        $asins[] = $data;
      }
      $keys1 = array_keys($asins); 
      $n = count($asins[$keys1[0]]);   
      // echo "<PRE>";
      // print_r($asins);
      // echo "</PRE>";
      $html = array2table($asins);
      echo $html;
      fclose($fp);
      //ファイルの削除
      unlink('./data/uploaded/'.$file_name);
    } else {
      $err_msg = "ファイルをアップロードできません。";
    }
  }
} else {
  $err_msg = "ファイルが選択されていません。";
}
echo "<br><br>";
print<<<ABC
    <form action="./csv_input2-2.php" method="post" enctype="multipart/form-data">
    <div class="form-group">
          <label>CSVファイル選択</label>
          <input type="file" name="upfile" />
        </div>
       <div class="form-group">
          <label>行指定</label>
          <input type="number" name="startrow" min="1" max="$n" required>
            ~
          <input type="number" name="lastrow" min="1" max="$n" required>
      </div> 
      <div class="form-group">
          <label>列指定</label>
          <input type="number" name="startcolumn"min="1" max="$n"  required>
            ~
          <input type="number" name="lastcolumn" min="1" max="$n"  required>
      </div> 
        <div class="form-group">
          <input type="submit" name="cutting" value="cutting" class="btn btn-primary col-lg-6 col-lg-offset-3">
        </div>
        <input type="hidden" name="upfile1" value="$file_tmp_name">
        <input type="hidden" name="upfile2" value="$file_name">
      </form>
ABC;
}

?>

    </div>
  </div>
</div>

<? include 'footer.php'; ?>

<?php
function array2table($arr) {
     if (!is_array($arr)) return FALSE;            //配列がない
     $keys1 = array_keys($arr);                       //1次元目のキー取得
     $keys2 = array_keys($arr[$keys1[0]]);            //2次元目のキー取得
     if (is_array($arr[$keys1[0]][$keys2[0]]))   return FALSE;    //3次元以上
     $n = count($arr[$keys1[0]]);                
     //要素の数
     $html = "<table border=\"1\" class=\"array\">\n"; 
     //要素名
     $html .= "<tr><th>Key</th>";
     for ($i = 0; $i < $n; $i++) {
        $key1=intval($keys2[$i]);
        $key1++;
         $html .= "<th>$key1</th>";
     }
     $html .= "</tr>\n";
 
     //配列本体
     foreach ($arr as $key=>$arr1) {
        $key2=intval($key);
        $key2++;
         $html .= "<tr><th>$key2</th>";
         for ($i = 0; $i < $n; $i++) {
             $html .= "<td>{$arr1[$keys2[$i]]}</td>";
         }
     }
     $html .= "</tr>\n</table>\n"; 
     return $html;
 }

?>
