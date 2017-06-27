<?php
 ini_set('display_errors', 1);
error_reporting(-1);
    ini_set('error_log', 'files/log.txt');
    ini_set('log_errors_max_len', 0);
    ini_set('log_errors', true);
    
    
    
    require_once   "../vendor/fpdo/fluentpdo/FluentPDO/FluentPDO.php";

    include '../models/clsorganization.php';
    include '../controllers/prop.php';
    
if (isset($_REQUEST['type']) && !empty($_REQUEST['type'])) {
    $type = $_REQUEST['type'];
    
    switch ($type) {
        case "add":
            if (!empty($_POST['data'])) {
                if (!isset($_POST['data']['orgcode'])  || !isset($_POST['data']['orgname'])){
                    $data['status'] = 'ERR';
                    $data['msg'] = 'Name / Code is empty';
                }else{
                $clsorg = new \models\clsOrganization;
                $clsorg->slno=0;
                $clsorg->orgcode=$_POST['data']['orgcode'];
                $clsorg->orgname=$_POST['data']['orgname'];
                $clsorg->rec_status='A';
             
                $ret=InsertData($clsorg,$servername,$dbname,$username,$password);
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
                if (!isset($_POST['data']['orgcode'])  || !isset($_POST['data']['orgname'])){
                    $data['status'] = 'ERR';
                    $data['msg'] = 'Name / Code is empty';
                }else{
                $clsorg = new \models\clsOrganization;
                $clsorg->slno=$_POST['data']['slno'];
                $clsorg->orgcode=$_POST['data']['orgcode'];
                $clsorg->orgname=$_POST['data']['orgname'];
                $clsorg->rec_status='A';
             
                $ret=UpdateData($clsorg,$servername,$dbname,$username,$password);
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
 
function InsertData($clsorg,$hostname,$dbname,$dbusername,$dbpassword)
{

    $conn = new PDO("mysql:host=$hostname;dbname=$dbname", $dbusername, $dbpassword);
         $fpdo = new FluentPDO($conn);
    try {
         $values=array('orgname' => $clsorg->orgname,'orgcode' => $clsorg->orgcode ,'rec_status' => $clsorg->rec_status);
         $qry=$fpdo->insertInto('tblorg', $values)->execute();
         return $qry;
    } catch (Exception $e) {
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
        $qry=$fpdo->from('tblorg')->where('rec_status', 'A');
         $resultrow=$qry->fetchAll();
     
        return $resultrow;
    } catch (Exception $e) {
        return $e->getMessage();
    }finally{
        $conn=null;
        $fpdo=null;

    }
}

function UpdateData($clsorg,$hostname,$dbname,$dbusername,$dbpassword){
    $conn = new PDO("mysql:host=$hostname;dbname=$dbname", $dbusername, $dbpassword);
    $fpdo = new FluentPDO($conn);
    try {
        $set=array('orgname' => $clsorg->orgname,'orgcode'=>$clsorg->orgcode);
        $qry=$fpdo->update('tblorg')->set($set)->where('slno', $clsorg->slno)->execute();
         
        return $qry;
    } catch (Exception $e) {
        return $e->getMessage();
    }finally{
        $conn=null;
        $fpdo=null;

    }
}

?>