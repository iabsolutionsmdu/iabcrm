<?php
  ini_set('display_errors', 1); error_reporting(-1);
    ini_set('error_log', 'files/log.txt');
    ini_set('log_errors_max_len', 0);
    ini_set('log_errors', true);
 include 'prop.php';
   
             try{
                   $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
             $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
             $selectqry="SELECT DISTINCT base_name as  fname from mstbase ";
             $sth = $conn->prepare($selectqry);
             $sth->execute();
             $results=$sth->fetchAll(PDO::FETCH_ASSOC);
             $json=json_encode($results);
             echo $json;


             }catch(Exception $e){
                  echo 'Caught exception: ',  $e->getMessage(), "\n";

             }

?>