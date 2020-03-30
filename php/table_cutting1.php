<?php 

include 'header.php';

?>


<div class="container">
  <div class="row">
    <div class="col-lg-6 col-lg-offset-3">
      <h1 class="page-header">Table Cutting</h1>
      
<?php

      $file_name=$_POST['file_name']; 
      $fp   = fopen($file_name, "r");
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
print<<<ABC

  <div class='form-group'>
          <label>$file_name</label>
        </div>
    <form action="./table_cutting2.php" method="post" enctype="multipart/form-data">
      <input type="hidden" name="file_name" value="$file_name">
       <div class="form-group">
          <label>行指定</label>
          <input type="number" name="startrow" min="1" max="$i" required>
            ~
          <input type="number" name="lastrow" min="1" max="$i" required>
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
