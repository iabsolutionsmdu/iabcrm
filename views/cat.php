<!DOCTYPE html>
<html>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />
<meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE" />
<head>
    <title>IAB -CRM</title>
    <?php include '../links.php';
    session_start();?>
    <script src="https://code.angularjs.org/1.5.6/angular-animate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/angular-filter/0.5.8/angular-filter.js"></script>
<script src="<?php echo (BASE_URL)?>/node_modules/angular-ui-bootstrap/dist/ui-bootstrap-tpls.js"></script>
<style>
        body {
            padding-top: 70px;
            /* Required padding for .navbar-fixed-top. Remove if using .navbar-static-top. Change if height of navigation changes. */
        }
        /* required style*/ 
.none{display: none;}

/* optional styles */
table tr th, table tr td{font-size: 1.2rem;}
.row{ margin:20px 20px 20px 20px;width: 100%;}
.glyphicon{font-size: 20px;}
.glyphicon-plus{float: right; }
#dataanchor {float : right ; font-family:roboto;text-decoration: none;cursor: pointer; };

#dataanchor.glyphicon{text-decoration: none;cursor: pointer;}
.glyphicon-trash{margin-left: 10px;}
.alert{
    width: 50%;
    border-radius: 0;
    margin-top: 10px;
    margin-left: 10px;
}
    </style>
    
    </head>
    <body ng-app="crudApp">
        <?php include '../menu.php' ?>
        <div class="container" ng-controller="catController" ng-init="getRecords()">
    <div class="row">
        <div class="panel panel-default users-content">
            <div class="panel-heading">Category <a id="dataanchor" href="javascript:void(0);" onclick="$('.formData').slideToggle();"> ADD &nbsp;&nbsp;<i class="glyphicon glyphicon-plus" style="padding-right: 5px;"></i></a></div>
            <div class="alert alert-danger none"><p></p></div>
            <div class="alert alert-success none"><p></p></div>
            <div class="panel-body none formData">
                <form class="form" name="catForm">
                   
                    <div class="form-group col-xs-6">
                        <label for="Category Description">Category Description</label>
                        <input type="text" class="form-control" name="description" ng-model="tempcatData.description" ng-required="true" required/>
                    </div>
                    
                     <div class="form-group col-xs-6">
                    <a href="javascript:void(0);" class="btn btn-warning" onclick="$('.formData').slideUp();">Cancel</a>
                    <a href="javascript:void(0);" class="btn btn-success" ng-hide="tempcatData.slno" ng-click="addCat()">Add</a>
                    <a href="javascript:void(0);" class="btn btn-success" ng-hide="!tempcatData.slno" ng-click="updatecat()">Update </a>
                     </div>
                </form>
            </div>
            <table class="table table-striped">
                <tr>
                    <th width="5%">#</th>
                    <th width="20%">Category Description</th>
                    <th> Edit</th>
                </tr>
                <tr ng-repeat="cat in cats">
                    <td>{{$index + 1}}</td>
                    <td>{{cat.description}}</td>
                    <td>
                        <a href="javascript:void(0);" class="glyphicon glyphicon-edit" ng-click="editCat(cat)"></a>
                        <!--<a href="javascript:void(0);" class="glyphicon glyphicon-trash" ng-click="deleteUser(user)"></a>-->
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript" src="../js/cat.js"></script>
        </body>
        </html>
