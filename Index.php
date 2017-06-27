<?php 
include 'controllers/checkauthentication.php';
?>
<!DOCTYPE html>
<html>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />
<meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE" />
<head>
    <title>IAB -CRM</title>
    <?php include 'links.php';
    session_start();?>
    <script src="https://code.angularjs.org/1.5.6/angular-animate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/angular-filter/0.5.8/angular-filter.js"></script>
<script src="<?php echo (BASE_URL)?>/node_modules/angular-ui-bootstrap/dist/ui-bootstrap-tpls.js"></script>
<style>
        body {
            padding-top: 70px;
            /* Required padding for .navbar-fixed-top. Remove if using .navbar-static-top. Change if height of navigation changes. */
        }
        /* Start by setting display:none to make this hidden.
   Then we position it in relation to the viewport window
   with position:fixed. Width, height, top and left speak
   for themselves. Background we set to 80% white with
   our animation centered, and no-repeating */
        
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: rgba( 255, 255, 255, .8) url('http://i.stack.imgur.com/FhHRx.gif') 50% 50% no-repeat;
        }
        /* When the body has the loading class, we turn
   the scrollbar off with overflow:hidden */
        
        body.loading {
            overflow: hidden;
        }
        /* Anytime the body has the loading class, our
   modal element will be visible */
        
        body.loading .modal {
            display: block;
        }
    </style>
    <script>
    angular.module('fileListApp',['ui.bootstrap'])
    .controller('ddlFileList',function ($scope,$http){
     $http.get('controllers/getfilelist.php').success(function(data) {
           $scope.fnames = data;
         });
    })
    .controller('baselist',function($scope,$http){
 $http.get('controllers/loadData.php').success(function(data) {
     //console.log(data.data);
           var uploadedfileslist = data.data;
         
           $scope.funcDownload= function(col){

            document.location.href = 'controllers/downloadcsv.php?args=' + col;
           };
           
        $scope.totalItems = uploadedfileslist.count;
        $scope.currentPage = 1; // keeps track of the current page
        $scope.pageSize = 20; // holds the number of items per page
        $scope.mydata=uploadedfileslist;  
    });
        }).filter('start',function(){
        return function(input,start){
            if (!input ||!input.length){return;}
            start=+start;
            return input.slice(start);
        }});
   
    </script>
    </head>
    <body>
        <?php include 'menu.php' ?>
<div class="container" ng-app="fileListApp">
        <div class="row">

            <div class="col-md-6">
                <div class="panel panel-default" >
                    <div class="panel-heading">Upload Base</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <form role="form" name="frminsert" method="post" action="controllers/processbase.php" enctype="multipart/form-data">
                                <!--<div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" value="lessno" name="chkino" id="chkino">
                                        Exclude Invalid Number (Mobile number less than 10 digits)
                                    </label>
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" value="invstno" name="chkstno" id="chkstno">
                                       Exclude Invalid Number (Mobile number Starting other than 7 /  8 /  9)
                                    </label>
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" value="dupno" name="chkdupno" id="chkdupno">
                                       Exclude Duplicate Number 
                                    </label>
                                </div>-->
                                <br>
                                <label for="file" class="control-label">Filename:
                                    <input type="file" name="file" id="file" class="form-control" accept=".csv" required aria-required="true"><br>
                                    <input type="submit" name="submit" value="Submit" class="btn btn-default">
                                    </label>


                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-info" >
                    <div class="panel-heading">Update Feedback</div>
                    <div class="panel-body">
                        <div class="form-group">

                            <form role="form" name="frmupdate" action="controllers/upload_feedback.php" method="post" enctype="multipart/form-data">
                                <div  ng-controller="ddlFileList">
                                    <label for="select" class="control-label"> Select Base:
                                    <select name="ddlbase" id="ddlbase" required aria-required="true">
                                        <option value = "" label = "Please Select"></option>
                                        <option ng-repeat="n in fnames" value="{{n.fname}}"
                                                    ng-selected="{{ n.Selected == true }}">
                                            {{n.fname}}
                                        </option>
                                    </select>
                                    </label>
                                    <input type="hidden" name="hdnbasename" id="hdnbasename"/>
                                </div>
                                <label for="file" class="control-label">Filename:
                                    <input type="file" name="file1" id="file1" class="form-control" accept=".csv" required aria-required="true"><br>
                                    <input type="submit" name="submit" value="Submit" class="btn btn-default">
                                    </label>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="row">
            <div class="col-md-12">
            
                <div class="panel panel-success" >
                    <div class="panel-heading">Download Base</div>
                    <div class="panel-body">
                        <div class="form-group" >
                            <div ng-app="fileListApp" ng-controller="baselist">
                                <p><input type="text" ng-model="search"></p>
                            <table id="dtdownload" class="table table-bordered table-condensed table-responsive" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Base Name</th>
                                        <th>Available Numbers</th>
                                        <th>Distinct Numbers (count)</th>
                                        <th>Uploaded Date </th>
                                        <th>Organization </th>
                                        <th>Category </th>
                                        <th>Send SMS</th>
                                        <th>Download</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="d in mydata | start :(currentPage - 1) * pageSize | limitTo: pageSize|filter : search | orderBy : 'upload_date' ">
                                        <td>{{ d.base_name}}</td>
                                        <td>{{ d.totalnumbers}}</td>
                                        <td>{{ d.totalduplicates}}</td>
                                        <td>{{ d.upload_date}}</td>
                                        <td>{{ d.org}}</td>
                                        <td>{{ d.cat}}</td>
                                        <td><button id='btnsms' class="sendsms" >Send SMS</button></td>
                                        <td><button id='btndownload' class="downloadcontrol" ng-click="funcDownload(d.base_name)" >Download</button></td>
                                    </tr>
                                </tbody>
                               </table>
                                <ul uib-pagination total-items="mydata.length" items-per-page="pageSize" ng-model="currentPage" max-size="5" 
                        class="pagination-sm" ></ul>
        
                               </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="modal">
        <!-- Place at bottom of page -->
    </div>
    <script type="text/javascript">
    $body = $("body");

$(document).on({
    ajaxStart: function() { $body.addClass("loading");    },
     ajaxStop: function() { $body.removeClass("loading"); }    
});
                            $(document).ready(function(){


                                function validate() {
                                    if (document.getElementById("ddlbase").value == "") {
                                        alert("Please select value"); // gives alert to user select any value
                                        document.getElementById("select").focus(); //set focus back to control
                                        return false;
                                    }
                                }

                                $('#ddlbase').on('change',function(){
                                    $('#hdnbasename').val($(this).val());
                                    
                                    //alert($(this).val());
                                });

                        //        $('#dtdownload').DataTable({
                        //     destroy: true,
                        //     dom: 'Bfrtip',
                           
                        //     "pageLength": 25
                        // });

                                //used loadData.php
                                // var table= $('#dtdownload').DataTable( {
                                //       "bProcessing": true,
                                //       "bServerSide": false,
                                //       "ajax" : "controllers/loadData.php",
                                //     "columns": [
                                //         { "data": "base_name" },
                                //         { "data": "totalnumbers" },
                                //         { "data": "totalduplicates" },
                                //         { "data": "upload_date" },
                                //         { "className":      'details-control', "data" : null, defaultContent: "<button id='btnsms' class='sms' >Send SMS</button>"},
                                //         { "className" : 'downloadcontrol', "data" : null, defaultContent: "<button id='btndownload'>Download</button>"}]
                                   
                                // } );
                               
                          
                                $('#dtdownload tbody').on('click','td.sendsms', function (e) {
                                    e.preventDefault();
                              
                                var row=$(this).closest("tr");
                                var col=row.find("td:first").text();

                                alert("This functionality yet to be implemented");

                              // document.location.href = 'controllers/processsms.php?args=' + col;

                                  
                                });

                                 $('#dtdownload tbody').on('click','td.downloadcontrol', function (e) {
                                    e.preventDefault();
                              
                                var row=$(this).closest("tr");
                                var col=row.find("td:first").text();

                                //alert(col);

                               document.location.href = 'controllers/downloadcsv.php?args=' + col;

                                  
                                });
                            });//end of docready
                            </script>
    </body>
    </html>
