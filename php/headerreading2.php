<?php 

include 'header.php';
date_default_timezone_set('Asia/Tokyo');
?>

<div class="container">
  <div class="row">
    <div class="col-lg-6 col-lg-offset-3">
      <h1 class="page-header">Header Reading</h1>
<?php
        $file_name = $_POST['file_name'];
        $table_name = $_POST['table'];
        $format = $_POST['format'];
        $column_name = $_POST['column_name'];
        $n=count($column_name);
        $query = "CREATE TABLE ".$table_name." \(";
        for($i=0;$i<$n;$i++){
          $column_name[$i]=str_replace('(', '\(', $column_name[$i]);
          $column_name[$i]=str_replace(')', '\)', $column_name[$i]);
          $query .= "\\\"".$column_name[$i]."\\\"";
          $query .= " ";
          $query .= $format[$i];
          $query .= " ,";
        }
        $query = substr($query, 0, -1);
        $query .= "\)\;";

        $command="java -classpath ./dbtest1/postgresql-42.2.5.jar: dbtest1/HeaderReading ".$query;
          $output=array();
          $return_var=null;
          exec($command, $output, $return_var);
        $dbconn = pg_connect("host=localhost dbname=doi user=doi password=doi");
        $array = explode("/", $file_name);
        $file = explode(".", $array[count($array)-1]);
        $id = $file[0];
        $catalog_site = $array[count($array)-3];
        $conversion_rule = "headerreading";
        $formatting_date = strval(date('Y-m-d'));
        $upload_date = $array[count($array)-2];
        $log = "INSERT INTO operation_log VALUES($1,$2,$3,$4,$5)";
        $result = pg_prepare($dbconn, "operated", $log);
        $result = pg_execute($dbconn, "operated", array($id, $catalog_site, $conversion_rule, $formatting_date, $upload_date));
         
print<<<ABC
        <form method='post' name='form1' action='./csv_menu.php'>
                     <input type='hidden' name='file_name' value=$file_name><a href='javascript:form1[0].submit()'>Continue formatting</a>
              </form>
              <form method='post' name='form1' action='./tocsvbank.php'>
                     <input type='hidden' name='file_name' value=$file_name><a href='javascript:form1[1].submit()'>Ready for Conversion</a>
              </form>
ABC;
          foreach ($output as $line){
            print $line."<br>\n";
          }
          echo $return_var;
          echo "*<br>\n";
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
