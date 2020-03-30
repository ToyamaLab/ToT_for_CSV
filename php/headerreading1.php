<?php 

include 'header.php';

?>

<div class="container">
  <div class="row">
    <div class="col-lg-6 col-lg-offset-3">
      <h1 class="page-header">Header Reading</h1>
<?php
if(!isset($_POST['row'])){
  $file=$_POST['file_name'];
print<<<EOF
      <form action="./headerreading1.php" method="post" enctype="multipart/form-data">
          
        <div class="form-group">
        <label>Select Row Number</label>
        <input type="number" name="row" min="1" required>
        <input type="hidden" name="file_name" value="$file">
        <input type="submit" value="select" class="btn btn-primary col-lg-6 col-lg-offset-3">
        </div>
        </form>
EOF;
}else{
print<<<EOF
    <form action='./headerreading2.php' method='post' enctype='multipart/form-data'>
    <div class="form-group">
    <label>Input Table Information</label>
    <input type="text" name="table" />
    
    </div>
EOF;
      $row = $_POST['row'];
      $file=$_POST['file_name'];
      $fp = fopen($file, "r");
        //配列に変換する
      $count=1;
    while (($data = fgetcsv($fp, 0, ",")) !== FALSE) {
      if($count==$row){
        for($i = 0; $i < count($data);++$i){
          echo "<div class='form-group'>";
          echo("[".$data[$i]."]");
   
print<<<EOF
          <input type="hidden" name="file_name" value="$file">
          <input type="hidden" name="column_name[]" value="$data[$i]">
          <select name='format[]'>
          <option value='varchar' selected>varchar</option>
          <option value='integer'>integer</option>
          </select>
          </div>
EOF;
        }
        
      }
        $count++;

      }

      fclose($fp);

print<<<EOF
 <div class="form-group">
    <input type='submit' value='Create' class='btn btn-primary col-lg-6 col-lg-offset-3'>
    </div>
    </form>
EOF;
}

        print"<div class='form-group'>
          <label>".$file."</label>
        </div>";
        $fp = fopen($file, "r");
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
?>
      	

    	

    </div>
  </div>
</div>

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



<? include 'footer.php'; ?>
