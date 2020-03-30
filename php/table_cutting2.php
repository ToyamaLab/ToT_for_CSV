<?php 

include 'header.php';
date_default_timezone_set('Asia/Tokyo');
?>

<div class="container">
  <div class="row">
    <div class="col-lg-6 col-lg-offset-3">
    <h1 class="page-header">Table Cutting</h1>
      <?php
        $file_name=$_POST['file_name'];
        $startrow=$_POST['startrow'];
        $lastrow=$_POST['lastrow'];
        $startcolumn=$_POST['startcolumn'];
        $lastcolumn=$_POST['lastcolumn'];
          $command="java dbtest1/TableCutting ".$file_name." ".$startrow." ".$lastrow." ".$startcolumn." ".$lastcolumn;
          $output=array();
          $return_var=null;
          exec($command, $output, $return_var);
        $dbconn = pg_connect("host=localhost dbname=doi user=doi password=doi");
        $array = explode("/", $file_name);
        $file = explode(".", $array[count($array)-1]);
        $id = $file[0];
        $catalog_site = $array[count($array)-3];
        $conversion_rule = "tablecutting";
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

<? include 'footer.php'; ?>
