<html>
    <head>
         <script src="./contents/jquery.min.js" type="text/javascript"></script>
        </head>
    <body>
        
<?php
    ini_set('display_errors', 1); error_reporting(-1);
    ini_set('error_log', 'files/log.txt');
    ini_set('log_errors_max_len', 0);
    ini_set('log_errors', true);

 include 'prop.php';

if (isset($_POST["hdnbasename"])){
$pbasename = $_POST["hdnbasename"];
}
$pfdate=date('d-M-Y H:i:s');

  if ($_FILES["file1"]["error"] > 0)
  {
  echo "Error: " . $_FILES["file1"]["error"] . "<br>";
  }
else
  {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
             $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      try{
          $tmpname=$_FILES["file1"]["tmp_name"];
          $fname=$_FILES["file1"]["name"];

            
          $handle = fopen($tmpname, "r") or die("Couldn't get handle");
        if ($handle) {
            $stmt=$conn->prepare("insert into tblfeedback (mblno,basename,fdate,custname,state,campaign,dialdate,feedback) values 
            (:pmblno,:pbasename,:pfdate,:pcustname,:pstate,:pcampaign,:pdialdate,:pfeedback)");
            $stmt->bindParam('pmblno',$pmblno);
            $stmt->bindParam('pbasename',$pbasename);
            $stmt->bindParam('pfdate',$pfdate);
            $stmt->bindParam('pcustname',$pcustname);
            $stmt->bindParam('pstate',$pstate);
            $stmt->bindParam('pcampaign',$pcampaign);
            $stmt->bindParam('pdialdate',$pdialdate);
            $stmt->bindParam('pfeedback',$pfeedback);
            $conn->beginTransaction();
 

            while (!feof($handle)) {
                $buffer = fgets($handle, 4096);
                // Process buffer here..
                //echo $buffer . "<br>";
               
                $vals =explode(",",$buffer);

              // echo "<div id='" . $vals[0] . "'>" . $vals[0] . "</div>";
              //$id="";
             

                if (! empty($vals[0]) && $vals[0] != 'Mobile No'){
                     $pmblno=$vals[0];
                    // $pbasename=$vals[2];
                    // $pfdate=$vals[7];
                    $pcustname=$vals[2];
                    $pstate=$vals[3];
                    $pcampaign=$vals[4];
                    $pdialdate=$vals[5];
                    $pfeedback=$vals[6];

                    $stmt->execute();
                   // $insqry= "INSERT IGNORE INTO tblbase(mblno,provider,team,mdate,fname) values('" . $vals[0] . "','" . $vals[2] . "','" . $vals[7] . "','" . $vals[8] . "','" . $fname . "')";
                    //$insqry = $insqry . " Select * from (select '" . $vals[0] . "' ) as tmp where not EXISTS (select mblno from tblbase where mblno='" . $vals[0] . "')";
                    //echo $insqry . "<br>";
                    //$conn->exec($insqry);
                    // $retid = $conn->lastInsertId();
                    // if ($retid != $id){
                    //   //  echo "ok " . "<br>";

                    // }else{
                    //     echo $buffer . " Duplicate or Invalid Record" . "<br>";
                    // }
                    // $id=$retid;

                }


            }
            fclose($handle);
            $conn->commit();

            echo "<div> File Uploaded Successfully !!! You will be redirect shortly </div>";
            
          //  $conn = null;

      }
      
    }
    catch(Exception $e){
        echo 'Caught exception: ',  $e->getMessage(), "\n";
         $conn->rollback();
    }
     $conn = null;
header("Refresh: 6;url=index.html");
      }

    ?>
    
</body>
    </html>