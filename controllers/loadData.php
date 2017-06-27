<?php
  ini_set('display_errors', 1); error_reporting(-1);
    ini_set('error_log', 'files/log.txt');
    ini_set('log_errors_max_len', 0);
    ini_set('log_errors', true);
   
    include 'prop.php';
     include "../logger.php";
   session_start();
   include '../models/clsuser.php';

$ret=new \models\users;
if (array_key_exists('user',$_SESSION) && !empty($_SESSION['user']) ){
    $ret=json_decode($_SESSION['user']);
   
}else{
     header("location:../views/login.html");
        die;
}

class resultobj{
    public $base_name;
    public $totalduplicates;
    public $totalnumbers;
    public $upload_date;
    public $org;
    public $cat;
}

             try{
                   $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
             $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
           
                  if ($ret->isadmin == 'Y'){
    $selectqry="SELECT  x.base_name,count(x.c) as totalduplicates,(select count(*) from mstbase where base_name=x.base_name) as totalnumbers 
                  , x.upload_date , tblorg.orgname, tblcategory.description as category FROM
                  (
                      select base_name, Count(mobileno) as c,upload_date ,(organisation) as org_slno,category as cat_slno
                      from mstbase 
                      group by base_name,mobileno,upload_date,org_slno,cat_slno
                      having Count(mobileno) >= 1
                  ) x left outer join tblorg  on x.org_slno=tblorg.slno  left outer join 
                  tblcategory on x.cat_slno=tblcategory.slno group by x.base_name,x.upload_date,tblorg.orgname,category";
           }else{
               $selectqry="SELECT  x.base_name,count(x.c) as totalduplicates,(select count(*) from mstbase where base_name=x.base_name) as totalnumbers 
                  , x.upload_date , tblorg.orgname, tblcategory.description as category FROM
                  (
                      select base_name, Count(mobileno) as c,upload_date ,(organisation) as org_slno,category as cat_slno
                      from mstbase where uploaded_by='" .$ret->emplname . "'
                      group by base_name,mobileno,upload_date,org_slno,cat_slno
                      having Count(mobileno) >= 1
                  ) x left outer join tblorg  on x.org_slno=tblorg.slno  left outer join 
                  tblcategory on x.cat_slno=tblcategory.slno group by x.base_name,x.upload_date,tblorg.orgname,category";
           }
             $sth = $conn->prepare($selectqry);
             $sth->execute();
            // $results=$sth->fetchAll(PDO::FETCH_ASSOC);
            $results=array();
            $reccount=0;
             while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
                $ret1 =new resultobj();
                $ret1->base_name=$row["base_name"];
                $ret1->totalduplicates =$row["totalduplicates"];
                $ret1->totalnumbers=$row["totalnumbers"];
                $ret1->upload_date=$row["upload_date"];
                $ret1->cat=$row["category"];
                $ret1->org=$row["orgname"];
                $results[]=$ret1;
                  $reccount++;
             }
             //$results ="";
             $draw= 0;//$_GET['draw'];
             $retsultjson= array(
                "draw"            => intval($draw ),
                "recordsTotal"    => intval( $reccount ),
                "recordsFiltered" => intval( $reccount ),
                "data"            => $results
            );
             $json=json_encode($retsultjson);
             echo $json;


             }catch(Exception $e){
                  echo 'Caught exception: ',  $e->getMessage(), "\n";

             }

?>