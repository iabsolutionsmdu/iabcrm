<?php
  ini_set('display_errors', 1);
error_reporting(-1);
    ini_set('error_log', '../files/log.txt');
    ini_set('log_errors_max_len', 0);
    ini_set('log_errors', true);
    
    include 'prop.php';
    include "../logger.php";
    
    //include  "../vendor/fpdo/fluentpdo/FluentPDO/FluentPDO.php";

    include '../models/clsuser.php';
    

if (isset($_POST['_username']) && (trim($_POST['_username']) != '')) {
    $n=$_POST['_username'];
} else {
    echo ("Username is must");
    die;
}
if (isset($_POST['_password']) && (trim($_POST['_password']) != '')) {
    $p=$_POST['_password'];
} else {
    echo ("invalid password");
    die;
}

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $fpdo = new FluentPDO($conn);
// $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $ret=new \models\users;
    //$selectqry="SELECT  * from tbluser where name='" . $n . "' and password='" . $p . "' and rec_status='A'";
    $selectqry=$fpdo->from("tbluser")->where(array('emplname' => $n ,'password' => $p , 'rec_status' => 'A'));
     $resultrow=$selectqry->fetch();
 //$sth = $conn->prepare($selectqry);
 

  // echo $selectqry->getQuery() . "\n";
  // print_r($selectqry->getParameters()) . "\n";
   if ($resultrow == false){
       echo ("User name or Password is not correct");
        exit;
   }
    foreach($selectqry as $row){
          $ret->slno = $row['slno'];
          $ret->emplname = $row['emplname'];
          $ret->emailid= $row["emailid"];
          $ret->mobile=$row["mobile"];
          $ret->org_slno=$row["org_slno"];
          $ret->cat_slno=$row["cat_slno"];
          $ret->dept_slno=$row["dept_slno"];
          $ret->rec_status=$row["rec_status"];
          $ret->isadmin=$row["isadmin"];
          break 1;
    }
    // $logtext->addError($ret->emplname);
    //print_r($selectqry->rowCount());
     
// $results=$sth->fetchAll(PDO::FETCH_ASSOC);
            
    // while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
    //       $ret->$slno=$row["slno"];
    //       $ret->$name =$row["name"];
    //       $ret->$emailid=$row["emailid"];
    //       $ret->$mobile=$row["mobile"];
    //       $ret->$org_slno=$row["org_slno"];
    //       $ret->$cat_slno=$row["cat_slno"];
    //       $ret->$rec_status=$row["rec_status"];
    //       break 1;
    // }

    
 //$results ="";
if (session_status() == PHP_SESSION_ACTIVE) {
 session_abort();
 session_destroy();
}
    session_start();
    $_SESSION['user']=json_encode($ret);
    header('Location: ../Index.php');
    exit;
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
   $logtext->addError($e);

    $logger->addError($e);
}
