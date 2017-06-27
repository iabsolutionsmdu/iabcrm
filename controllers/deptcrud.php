<?php
 ini_set('display_errors', 1);
error_reporting(-1);
    ini_set('error_log', 'files/log.txt');
    ini_set('log_errors_max_len', 0);
    ini_set('log_errors', true);
    
    
    
    require_once   "../vendor/fpdo/fluentpdo/FluentPDO/FluentPDO.php";

    include '../models/clsdepartment.php';
    include '../controllers/prop.php';
    
if (isset($_REQUEST['type']) && !empty($_REQUEST['type'])) {
    $type = $_REQUEST['type'];
    
    switch ($type) {
        case "add":
            if (!empty($_POST['data'])) {
                if (!isset($_POST['data']['dept_code'])  || !isset($_POST['data']['dept_name'])){
                    $data['status'] = 'ERR';
                    $data['msg'] = 'Name / Code is empty';
                }else{
                $clsdept = new \models\clsDepartment;
                $clsdept->slno=0;
                $clsdept->dept_code=$_POST['data']['dept_code'];
                $clsdept->dept_name=$_POST['data']['dept_name'];
                $clsdept->rec_status='A';
             
                $ret=InsertData($clsdept,$servername,$dbname,$username,$password);
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
                if (!isset($_POST['data']['dept_code'])  || !isset($_POST['data']['dept_name'])){
                    $data['status'] = 'ERR';
                    $data['msg'] = 'Name / Code is empty';
                }else{
                $clsdept = new \models\clsDepartment;
                $clsdept->slno=$_POST['data']['slno'];
                $clsdept->dept_code=$_POST['data']['dept_code'];
                $clsdept->dept_name=$_POST['data']['dept_name'];
                $clsdept->rec_status='A';
             
                $ret=UpdateData($clsdept,$servername,$dbname,$username,$password);
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
 
function InsertData($clsdept,$hostname,$dbname,$dbusername,$dbpassword)
{

     $conn = new PDO("mysql:host=$hostname;dbname=$dbname", $dbusername, $dbpassword);
         $fpdo = new FluentPDO($conn);
    try {
         $values=array('dept_name' => $clsdept->dept_name,'dept_code' => $clsdept->dept_code ,'rec_status' => $clsdept->rec_status);
         $qry=$fpdo->insertInto('tbldepartment', $values)->execute();
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
        $qry=$fpdo->from('tbldepartment')->where('rec_status', 'A');
         $resultrow=$qry->fetchAll();
     
        return $resultrow;
    } catch (Exception $e) {
        return $e->getMessage();
    }finally{
        $conn=null;
        $fpdo=null;

    }
}

function UpdateData($clsdept,$hostname,$dbname,$dbusername,$dbpassword){
    $conn = new PDO("mysql:host=$hostname;dbname=$dbname", $dbusername, $dbpassword);
    $fpdo = new FluentPDO($conn);
    try {
        $set=array('dept_name' => $clsdept->dept_name,'dept_code'=>$clsdept->dept_code);
        $qry=$fpdo->update('tbldepartment')->set($set)->where('slno', $clsdept->slno)->execute();
         
        return $qry;
    } catch (Exception $e) {
        return $e->getMessage();
    }finally{
        $conn=null;
        $fpdo=null;

    }
}

?>