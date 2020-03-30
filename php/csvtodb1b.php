<?php 

include 'header.php';

?>

<div class="container">
  <div class="row">
    <div class="col-lg-6 col-lg-offset-3">
    <h1 class="page-header">CSV Conversion</h1>
      <?php
        $file_name=$_POST['file_name'];
        $table_name = $_POST['table_name'];
        $num = $_POST['num'];
        $fp = fopen($file_name, "r");
      $i=0;
      //配列に変換する
      while (($data = fgetcsv($fp, 0, ",")) !== FALSE) {
        $asins[] = $data;
        $i++;
      }
      $keys1 = array_keys($asins); 
      $n = count($asins[$keys1[0]]);
      // echo "<PRE>";
      // print_r($asins);
      // echo "</PRE>";
      $array = explode("/", $file_name);
      $catalog = $array[count($array)-2];
      $file1 = explode(".", $array[count($array)-1]);
      $file2 = explode("_", $file1[0]);
      $dbconn = pg_connect("host=localhost dbname=doi user=doi password=doi");
      $query = "SELECT * from ".$table_name;
      $result = pg_prepare($dbconn, "column", $query);
      $result = pg_execute($dbconn, "column", array());
      // $num=pg_num_rows($result);
      // $query = "SELECT * FROM operation_log WHERE catalog_site = $1 AND id = $2 AND conversion_rule = 'CSVtoDB'";
      // $result = pg_prepare($dbconn, "operated", $query);
      // $result = pg_execute($dbconn, "operated", array($catalog, $file2[0]));
      // $num=pg_num_rows($result);
      // $table_list= "select relname as TABLE_NAME from pg_stat_user_tables where relname != 'operation_log' AND relname != 'crawler_control'";
      // $result2=pg_prepare($dbconn, "list", $table_list);
      // $result2=pg_execute($dbconn, "list", array());
      // $list_num=pg_num_rows($result2);
print<<<ABC
  <div class='form-group'>
          <label>$file_name</label>
        </div>

         <div class='form-group'>
          <label>$table_name</label>
        </div>
ABC;
      if($num!=0){
        echo "<h5>Already Conversion</h5>";
      }
      //要素の数
     $html1 = "<table border=\"1\" class=\"array\">\n"; 
     //要素名
     $html1 .= "<tr><th>Key</th>";
     for($j=0;$j<pg_num_fields($result);$j++) {
     $html1 .= "<th>".pg_field_name($result, $j)."</th>";
     }
     $html1 .= "</tr>\n</table>\n";
     echo $html1;
print<<<ABC
    <form action="./csvtodb2.php" method="post" enctype="multipart/form-data">
    <input type="radio" name="new" value="new">New Generation
    <input type="radio" name="new" value="overwrite">Overwrite
      <input type="hidden" name="file_name" value="$file_name">
      <input type="hidden" name="num" value="$num">
      <input type="hidden" name="table_name" value="$table_name">
        <div class="form-group">
          <input type="submit" name="conversion" value="conversion" class="btn btn-primary col-lg-6 col-lg-offset-3">
        </div>
        
      </form>
ABC;
  $html = array2table($asins);
  echo $html;
  fclose($fp);
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
