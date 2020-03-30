<?php 

include 'header.php';
date_default_timezone_set('Asia/Tokyo');
?>

<div class="container">
  <div class="row">
    <div class="col-lg-6 col-lg-offset-3">
    <h1 class="page-header">CSV Conversion</h1>
      <?php
        $file_name=$_POST['file_name'];
        $table_name = $_POST['table_name'];
        $num = $_POST['num'];
        $generate = $_POST['new'];
        $dbconn = pg_connect("host=localhost dbname=doi user=doi password=doi");
        if($num!=0){
          $query0="DELETE FROM ".$table_name;
          $result0 = pg_prepare($dbconn, "delete", $query0);
          $result0 = pg_execute($dbconn, "delete", array());
        }
        echo $file_name;
        echo $table_name;
          $command="java -classpath ./dbtest1/postgresql-42.2.5.jar: dbtest1/CSVtoDB ".$file_name." ".$table_name;
          $output=array();
          $return_var=null;
          exec($command, $output, $return_var);
          foreach ($output as $line){
            print $line."<br>\n";
          }
          
          if($return_var==0){echo "complete";}
          echo "*<br>\n";
        
        $array = explode("/", $file_name);
        $file = explode(".", $array[count($array)-1]);
        $id = $file[0];
        $catalog_site = $array[count($array)-2];
        $conversion_rule = "CSVtoDB";
        $formatting_date = strval(date('Y-m-d'));
        $upload_date = '';
        $log = "INSERT INTO operation_log VALUES($1,$2,$3,$4,$5)";
        $result = pg_prepare($dbconn, "operated", $log);
        $result = pg_execute($dbconn, "operated", array($id, $catalog_site, $conversion_rule, $formatting_date, $upload_date));
      ?>

    </div>
  </div>
</div>

<? include 'footer.php'; ?>
