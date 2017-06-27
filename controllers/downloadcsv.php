<?php
  ini_set('display_errors', 1); error_reporting(-1);
    ini_set('error_log', 'files/log.txt');
    ini_set('log_errors_max_len', 0);
    ini_set('log_errors', true);

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
             //$selectqry="SELECT slno,mblno,provider,team,mdate from tblbase where fname='vmp.csv'";
             $selectheader="select mobileno,  service_provider,customer_firstname,  customer_lastname,  customer_address1,  customer_address2,
  customer_address3,  customer_state,  customer_country,  pincode,  base_name,  campaign_name, 
  fld1_mapped_colname,  fld2_mapped_colname,  fld3_mapped_colname,
  fld4_mapped_colname,   fld5_mapped_colname,  fld6_mapped_colname,  fld7_mapped_colname,  fld8_mapped_colname,
  fld9_mapped_colname,  fld10_mapped_colname,  fld11_mapped_colname,  fld12_mapped_colname,  fld13_mapped_colname,
  fld14_mapped_colname,  fld15_mapped_colname,  fld16_mapped_colname,  fld17_mapped_colname,  fld18_mapped_colname,
  fld19_mapped_colname,  fld20_mapped_colname from mstbase where base_name='" . $args ."' limit 1";
  
             $selectqry="SELECT 
  mobileno,  service_provider,customer_firstname,  customer_lastname,  customer_address1,  customer_address2,
  customer_address3,  customer_state,  customer_country,  pincode,  base_name,  campaign_name,
  fld1,  fld2,  fld3,  fld4,  fld5,  fld6,  fld7,  fld8,  fld9,  fld10,  fld11,  fld12,  fld13,  fld14,
  fld15,  fld16,  fld17,  fld18,  fld19,  fld20 from mstbase where base_name='" . $args ."'";
  
             $sth = $conn->prepare($selectqry);
             $sth->execute();
             $results=$sth->fetchAll(PDO::FETCH_ASSOC);
             $sth1= $conn->prepare($selectheader);
             $sth1->execute();
             $header=$sth1->fetchAll(PDO::FETCH_ASSOC);
           
             $hr=array_filter($header,function($value) {
                            return ($value !== null && $value !== false && $value !== ''); 
                        });
                        $cols=array_filter($hr[0]);
            // print_r ($cols);
             
             $hrow=[];
             foreach($cols as $key => $value){
               
                //  echo $value;
                  //echo substr($key,0,3);
                  if (substr($key,0,3) == "fld" ){
                         array_push($hrow,$value);
                  }else{
                         array_push($hrow,$key);
                  }
                

             }
                  $data = fopen('php://output', 'w');
              header('Content-Type: text/csv');
                header('Content-Disposition: attachment; filename=' . $args );
                header('Pragma: no-cache');
                header('Expires: 0');
                fputcsv($data, $hrow);

             $rr=array_filter($results,function($value) {
                            return ($value !== null && $value !== false && $value !== ''); 
                        });
                    foreach($rr as $row){
                        //print_r($row);
                        $rescols=array_filter($row,function($value) {
                            return ($value !== null);});
                       // print_r($row);
                        fputcsv($data,$rescols);
                    }
                        
             
         

                 fclose($data);
                    die;
              }catch(Exception $e){
                  echo 'Caught exception: ',  $e->getMessage(), "\n";
                  die;

             }

?>