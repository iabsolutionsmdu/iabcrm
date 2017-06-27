<?php
 ini_set('display_errors', 1);
error_reporting(-1);
    ini_set('error_log', 'files/log.txt');
    ini_set('log_errors_max_len', 0);
    ini_set('log_errors', true);
    
    
    include "../logger.php";
    require_once   "../vendor/fpdo/fluentpdo/FluentPDO/FluentPDO.php";

    include '../models/clsuser.php';
    include '../controllers/prop.php';
    
if (isset($_REQUEST['type']) && !empty($_REQUEST['type'])) {
    $type = $_REQUEST['type'];
    
    switch ($type) {
        case "add":
            if (!empty($_POST['data'])) {
                if (!isset($_POST['data']['dept_slno'])  || !isset($_POST['data']['emplname']) 
                || !isset($_POST['data']['cat_slno']) || !isset($_POST['data']['org_slno']))
                {
                    $data['status'] = 'ERR';
                    $data['msg'] = 'Name / Department / Organization / Category is empty';
                }else{
                $clsusr = new \models\users;
                $clsusr->slno=0;
                $clsusr->emplname=$_POST['data']['emplname'];
                $clsusr->password="123";
                $clsusr->emailid=$_POST['data']['emailid'];
                $clsusr->mobile=$_POST['data']['mobile'];
                $clsusr->org_slno=$_POST['data']['org_slno'];
                $clsusr->cat_slno=$_POST['data']['cat_slno'];
                $clsusr->dept_slno=$_POST['data']['dept_slno'];
                $clsusr->isadmin=$_POST['data']['isadmin'];
                $clsusr->rec_status='A';
             
                $ret=InsertData($clsusr,$servername,$dbname,$username,$password);
                if ($ret) {
                    $data['data'] = $ret;
                    $data['status'] = 'OK';
                    $data['msg'] = 'Data has been added successfully.';
                } else {
                    $data['status'] = 'ERR';
                    $data['msg'] = 'Update Failed, please try again.';
                }
            } 
            }else {
                $data['status'] = 'ERR';
                $data['msg'] = 'No Data Transferred, please try again.';
            }
            echo json_encode($data);
            break;
        case "view":
            $result=GetData($servername,$dbname,$username,$password);
            //print_r($result);
            if ($result) {
                $data['records'] = $result;
                $data['status'] = 'OK';
            } else {
                $data['records'] = array();
                $data['status'] = 'ERR';
            }
            echo json_encode($data);
            break;
        case "edit":
 if (!empty($_POST['data'])) {
                if (!isset($_POST['data']['dept_slno'])  || !isset($_POST['data']['emplname']) 
                || !isset($_POST['data']['cat_slno']) || !isset($_POST['data']['org_slno']))
                {
                    $data['status'] = 'ERR';
                    $data['msg'] = 'Name / Department / Organization / Category is empty';
                }else{
               $clsusr = new \models\users;
                $clsusr->slno=$_POST['data']['slno'];
                $clsusr->emplname=$_POST['data']['emplname'];
                $clsusr->password="123";
                if (isset($_POST['data']['emailid'])){
                $clsusr->emailid=$_POST['data']['emailid'];
                }
                if (isset($_POST['data']['mobile'])){
                $clsusr->mobile=$_POST['data']['mobile'];
                }else{
                    $clsusr->mobile='';
                }
                $clsusr->org_slno=$_POST['data']['org_slno'];
                $clsusr->cat_slno=$_POST['data']['cat_slno'];
                $clsusr->dept_slno=$_POST['data']['dept_slno'];
                $clsusr->isadmin=$_POST['data']['isadmin'];
                $clsusr->rec_status='A';
             
                $ret=UpdateData($clsusr,$servername,$dbname,$username,$password);
                if ($ret) {
                    $data['data'] = $ret;
                    $data['status'] = 'OK';
                    $data['msg'] = 'Data has been updated successfully.';
                } else {
                    $data['status'] = 'ERR';
                    $data['msg'] = 'Update Failed, please try again.';
                }
            } 
            }else {
                $data['status'] = 'ERR';
                $data['msg'] = 'No Data Transferred, please try again.';
            }
            echo json_encode($data);

            break;
    }
}
 
function InsertData($clsusr,$hostname,$dbname,$dbusername,$dbpassword)
{

     $conn = new PDO("mysql:host=$hostname;dbname=$dbname", $dbusername, $dbpassword);
         $fpdo = new FluentPDO($conn);
    try {
         $values=array('emplname' => $clsusr->emplname,
         'password' => $clsusr->password ,'emailid' => $clsusr->emailid,
         'mobile' => $clsusr->mobile ,'org_slno' => $clsusr->org_slno,
         'cat_slno' => $clsusr->cat_slno ,'dept_slno' => $clsusr->dept_slno,
          'rec_status' => $clsusr->rec_status , 'isadmin' => $clsusr->isadmin);
         $qry=$fpdo->insertInto('tbluser', $values)->execute();
         return $qry;
    } catch (Exception $e) {
        $logger->addError($e);
        return $e->getMessage();
    }finally{
        $conn=null;
        $fpdo=null;

    }
}

function GetData($hostname,$dbname,$dbusername,$dbpassword)
{
   
    $conn = new PDO("mysql:host=$hostname;dbname=$dbname", $dbusername, $dbpassword);
    $fpdo = new FluentPDO($conn);
    try {
        $qry=$fpdo->from('tbluser')->where('rec_status', 'A');
         $resultrow=$qry->fetchAll();
     
        return $resultrow;
    } catch (Exception $e) {
        $logger->addError($e);
        return $e->getMessage();
    }finally{
        $conn=null;
        $fpdo=null;

    }
}

function UpdateData($clsusr,$hostname,$dbname,$dbusername,$dbpassword){
    $conn = new PDO("mysql:host=$hostname;dbname=$dbname", $dbusername, $dbpassword);
    $fpdo = new FluentPDO($conn);
    try {
      
        $set=array('emplname' => $clsusr->emplname,
         'emailid' => $clsusr->emailid,
         'mobile' => $clsusr->mobile ,'org_slno' => $clsusr->org_slno,
         'cat_slno' => $clsusr->cat_slno ,'dept_slno' => $clsusr->dept_slno,
          'rec_status' => $clsusr->rec_status, 'isadmin'=> $clsusr->isadmin);
        // print_r($set);

       $qry= $fpdo->update('tbluser')->set($set)->where('slno', $clsusr->slno);
      
        $qry->execute();
        return $qry;
    } catch (Exception $e) {
        $logger->addError($e);
        return $e->getMessage();
    }finally{
        $conn=null;
        $fpdo=null;

    }
}

?>