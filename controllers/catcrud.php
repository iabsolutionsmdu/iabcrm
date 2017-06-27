<?php
 ini_set('display_errors', 0);
error_reporting(-1);
    ini_set('error_log', '../files/log.txt');
    ini_set('log_errors_max_len', 0);
    ini_set('log_errors', true);
    
    include "../logger.php";
    
    require_once  "../vendor/fpdo/fluentpdo/FluentPDO/FluentPDO.php";

    include '../models/clscategory.php';
    include '../controllers/prop.php';
    
if (isset($_REQUEST['type']) && !empty($_REQUEST['type'])) {
    $type = $_REQUEST['type'];
    
    switch ($type) {
        case "add":
            if (!empty($_POST['data'])) {
                if ( !isset($_POST['data']['description'])){
                    $data['status'] = 'ERR';
                    $data['msg'] = 'Description is empty ';
                }else{
                $clscat = new \models\clsCategory;
                $clscat->slno=0;
                $clscat->description=$_POST['data']['description'];
                $clscat->rec_status='A';
             
                $ret=InsertData($clscat,$servername,$dbname,$username,$password);
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
                if ( !isset($_POST['data']['description'])){
                    $data['status'] = 'ERR';
                    $data['msg'] = 'Description is empty';
                }else{
                $clscat = new \models\clsCategory;
                $clscat->slno=$_POST['data']['slno'];
                $clscat->description=$_POST['data']['description'];
                $clscat->rec_status='A';
             
                $ret=UpdateData($clscat,$servername,$dbname,$username,$password);
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
 
function InsertData($clscat,$hostname,$dbname,$dbusername,$dbpassword)
{

     $conn = new PDO("mysql:host=$hostname;dbname=$dbname", $dbusername, $dbpassword);
         $fpdo = new FluentPDO($conn);
    try {
         $values=array('description' => $clscat->description ,'rec_status' => $clscat->rec_status);
         $qry=$fpdo->insertInto('tblcategory', $values)->execute();
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
        $qry=$fpdo->from('tblcategory')->where('rec_status', 'A');
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

function UpdateData($clscat,$hostname,$dbname,$dbusername,$dbpassword){
    $conn = new PDO("mysql:host=$hostname;dbname=$dbname", $dbusername, $dbpassword);
    $fpdo = new FluentPDO($conn);
    try {
        $set=array('description' => $clscat->description);
        $qry=$fpdo->update('tblcategory')->set($set)->where('slno', $clscat->slno)->execute();
         
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