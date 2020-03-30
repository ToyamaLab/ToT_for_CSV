<? 
include 'header.php'; ?>

<div class="container">
  <div class="row">
    <div class="col-lg-6 col-lg-offset-3">

<?php
  $file=$_POST['file_name'];
?>
        <h1 class="page-header">CSV formatting</h1>
        <form method='post' name='form1' action='./crosstablelisting1a.php'>
         <input type='hidden' name='file_name' value='<?php echo $file; ?>'><a href='javascript:form1[0].submit()'>Cross_table Listing(ver.Java)</a>
      </form>
      <form method='post' name='form1' action='./crosstablelisting1b.php'>
             <input type='hidden' name='file_name' value='<?php echo $file; ?>'><a href='javascript:form1[1].submit()'>Cross_table Listing(ver.Python)</a>
      </form>
       <form method='post' name='form1' action='./table_cutting1.php'>
             <input type='hidden' name='file_name' value='<?php echo $file; ?>'><a href='javascript:form1[2].submit()'>Table Cutting</a>
      </form>
      <form method='post' name='form1' action='./headerreading1.php'>
             <input type='hidden' name='file_name' value='<?php echo $file; ?>'><a href='javascript:form1[3].submit()'>Header Reading</a>
      </form>
      <form method='post' name='form1' action='./tocsvkeep.php'>
             <input type='hidden' name='file_name' value='<?php echo $file; ?>'><a href='javascript:form1[4].submit()'>CSV Skipping</a>
      </form>
      <form method='post' name='form1' action='./tocsvbank.php'>
             <input type='hidden' name='file_name' value='<?php echo $file; ?>'><a href='javascript:form1[5].submit()'>Ready for Conversion</a>
      </form>
       
        <br>
        <a href="./index.php">TOP</a>
        <br>
        <a href="./csv_input4.php">Back to CSV List</a>
        <br>
        <?php

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

