<?php
  ini_set('display_errors', 1); error_reporting(-1);
    ini_set('error_log', 'files/log.txt');
    ini_set('log_errors_max_len', 0);
    ini_set('log_errors', true);
    ini_set('memory_limit','-1');
    include 'prop.php';
 if (isset($_GET["args"])){
        $args=$_GET["args"];
    }
  
    

              try{
               function contains($searchword,$searchstring){
                   return strpos($searchstring,$searchword) !== false;
               }
                 $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                              $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                if (empty($args)){
                
 
             //$selectqry="SELECT slno,mblno,provider,team,mdate from tblbase where fname='vmp.csv'";
             $selectqry="SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA='iab' AND TABLE_NAME='mstbase'";
             $sth = $conn->prepare($selectqry);
             $sth->execute();
            
                $row = $sth->fetchAll(PDO::FETCH_ASSOC);
               // $newrow=array_shift($row);
                $json=json_encode($row);
               // print_r($row);
                echo $json;
                          
                die;
           

             }else{
                  //echo $args;
                  if (contains("select",$args)){
                 $selectqry=$args;     
                  }else{
                 $newargs=$args . "_mapped_colname";
                 $selectqry="SELECT distinct " . $newargs . " from mstbase";
                  }
                 
                 $sth = $conn->prepare($selectqry);
                 $sth->execute();
            
                $row = $sth->fetchAll(PDO::FETCH_ASSOC);
                
                //print count($row);
               // $newrow=array_shift($row);
                $json=json_encode($row);
                //echo json_last_error_msg();
                //print_r($row);
               echo $json;
                          
                die;

                
                 


               
             }
    }
    catch(Exception $e){
                  echo 'Caught exception: ',  $e->getMessage(), "\n";
                  die;

             }

?>