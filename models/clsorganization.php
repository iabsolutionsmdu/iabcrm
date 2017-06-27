<?php

namespace models

{
    ini_set('display_errors', 1);
    error_reporting(-1);
    ini_set('error_log', 'files/log.txt');
    ini_set('log_errors_max_len', 0);
    ini_set('log_errors', true);
    
    
    
    class clsOrganization
    {
    
        var $slno;
        var $orgcode;
        var $orgname;
        var $rec_status;
    }

    // class crudOrganization extends clsOrganization
    // {

    //     private $conn = null;
    //     private $fpdo =null;

    //     public function __construct()
    //     {
        
    //           $conn = new \PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    //           $fpdo = new FluentPDO($conn);

    //     }
    //     function __destruct(){
    //         $conn=null;
    //         $fpdo=null;
    //     }

    //     function InsertData($orgclass)
    //     {
    //         $this->slno = $orgclass::slno;
    //         $this->orgname=$orgclass::orgname;
    //         $this->orgcode=$orgclass::orgcode;
    //         $this->rec_status=$orgclass::rec_status;

    //         try {
    //             $values=array('orgname' => $this->orgname,'orgcode' => $this->orgcode ,'rec_status' => $this->rec_status);
    
               
    //             $qry=$fpdo->insertInto('tblorg', $values)->execute();
    //             return true;
    //         } catch (Exception $e) {
    //             echo 'Caught exception: ',  $e->getMessage(), "\n";
    //         }
    //     }

    //     function GetData(){

    //         try {
    //             $values=array('orgname' => $this->orgname,'orgcode' => $this->orgcode ,'rec_status' => $this->rec_status);
    
               
    //             $qry=$fpdo->from('tblorg')->where('rec_status','A');
    //             return $qry;
    //         } catch (Exception $e) {
    //             echo 'Caught exception: ',  $e->getMessage(), "\n";
    //         }

    //     }
    // }
}
