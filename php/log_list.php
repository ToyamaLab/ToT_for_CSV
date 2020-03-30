<?php 

include 'header.php';

?>

<div class="container">
  <div class="row">
    <div class="col-lg-6 col-lg-offset-3">
      <h1 class="page-header">Operation Log</h1>
      

        <?php
        $catalog=$_POST['catalog'];
        $directory_path="/home/toyama/doi/tot/tot/csv/".$catalog."/";
        $com=$directory_path."*";
        foreach (glob($com) as $value){
          $date_directory[]=$value;
        }
        print"<div class='form-group'>
          <label>".$catalog." Catalog Site</label>
        </div>";
        $dbconn = pg_connect("host=localhost dbname=doi user=doi password=doi");
        $query = "SELECT * FROM operation_log WHERE catalog_site = $1 AND conversion_rule!='CSVtoDB'";
        $result = pg_prepare($dbconn, "operated", $query);
        $result = pg_execute($dbconn, "operated", array($catalog));
        $num=pg_num_rows($result);
        $j=0;
        for($i=0;$i<$num;$i++){
          $row = pg_fetch_assoc($result,$i);
          $id = $row['id'];
          $conversion_rule = $row['conversion_rule'];
          $formatting_date = $row['formatting_date'];
          $upload_date = $row['upload_date'];
          $place = '';
          $check = '';
          // echo strcmp($directory_path.$upload_date, '/home/toyama/doi/tot/tot/csv/us3/2019-11-10');

          foreach($date_directory as $date){
            if(strcmp($directory_path.$upload_date, $date)<0){
              $check="*";
              $place.=$date." ";
            }else{
              continue;
            }
          }

          if($check=='*'){
            $command="find ".$place." -name ".$id.".csv | wc -l";
            // echo $command;
            $call=exec($command);
            // echo $call;
            if($call!=0){
              $command2="find ".$place." -name ".$id.".csv";
              exec($command2,$array);
              $last=end($array);
              // echo $last;
  ?>
              <form method='post' name='form1' action='csv_menu.php'>
              <input type='hidden' name='file_name' value='<?php echo $last; ?>'><a href='javascript:form1[<?php echo $j; ?>].submit()'><?php echo $id; ?></a><h6>[<?php echo $conversion_rule."/".$formatting_date."/".$upload_date;?>]</h6>
              </form>
<?php
              $j++;
            }else{
              echo $id;
              echo "<h6>[".$conversion_rule."/".$formatting_date."/".$upload_date."]</h6>";
              
            }
          }else{
            echo $id;
            echo "<h6>[".$conversion_rule."/".$formatting_date."/".$upload_date."]</h6>";
            
          }    
        }
        

        ?>
      

    </div>
  </div>
</div>

<? include 'footer.php'; ?>
