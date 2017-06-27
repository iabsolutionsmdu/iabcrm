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

        .none {
            display: none;
        }
        /* optional styles */

        table tr th,
        table tr td {
            font-size: 1.2rem;
        }

        .row {
            margin: 20px 20px 20px 20px;
            width: 100%;
        }

        .glyphicon {
            font-size: 20px;
        }

        .glyphicon-plus {
            float: right;
        }

        #dataanchor {
            float: right;
            font-family: roboto;
            text-decoration: none;
            cursor: pointer;
        }

        ;

        #dataanchor.glyphicon {
            text-decoration: none;
            cursor: pointer;
        }

        .glyphicon-trash {
            margin-left: 10px;
        }

        .alert {
            width: 50%;
            border-radius: 0;
            margin-top: 10px;
            margin-left: 10px;
        }
    </style>

</head>

<body ng-app="crudApp">
    <?php include '../menu.php' ?>
    <div class="container" ng-controller="usersController" ng-init="getRecords()">
        <div class="row">
            <div class="panel panel-default users-content">
                <div class="panel-heading">Users <a id="dataanchor" href="javascript:void(0);" onclick="$('.formData').slideToggle();"> ADD &nbsp;&nbsp;<i class="glyphicon glyphicon-plus" style="padding-right: 5px;"></i></a></div>
                <div class="alert alert-danger none">
                    <p></p>
                </div>
                <div class="alert alert-success none">
                    <p></p>
                </div>
                <div class="panel-body none formData">
                    <form class="form" name="usersForm">
                        <div class="form-group col-xs-3">
                            <label for="User Name">User Name</label>
                            <input type="text" class="form-control" name="emplname" ng-model="tempusersData.emplname" required ng-required="true" />
                        </div>
                        <div class="form-group col-xs-6">
                            <label for="Email">Email</label>
                            <input type="email" class="form-control" name="emailid" ng-model="tempusersData.emailid" ng-required="true" required/>
                        </div>
                        <div class="form-group col-xs-6">
                            <label for="Mobile">Mobile</label>
                            <input type="text" class="form-control" name="mobile" ng-model="tempusersData.mobile" ng-required="true" required/>
                        </div>
                        <div class="form-group col-xs-6" ng-init="getOrgs()">
                            <label for="Organization">Organization</label>
                            <select name="ddlorg" id="ddlorg" class="form-control dropdown" required aria-required="true" ng-model="tempusersData.org_slno" >
                                        <option value = "" label = "Please Select"></option>
                                        <option ng-repeat="o in orgs" value="{{o.slno}}"
                                                    ng-selected="{{ o.Selected == true }}">
                                            {{o.orgname}}
                                        </option>
                                    </select>
                        </div>
                        <div class="form-group col-xs-6" ng-init="getDepts()">
                            <label for="Department">Department</label>
                            <select name="ddldept" id="ddldept" class="form-control dropdown" required aria-required="true" ng-model="tempusersData.dept_slno">
                                        <option value = "" label = "Please Select"></option>
                                        <option ng-repeat="d in depts" value="{{d.slno}}"
                                                    ng-selected="{{ d.Selected == true }}">
                                            {{d.dept_name}}
                                        </option>
                                    </select>
                        </div>
                        <div class="form-group col-xs-6" ng-init="getCats()">
                            <label for="Category">Category</label>
                            <select name="ddlcat" id="ddlcat" class="form-control dropdown" required aria-required="true" ng-model="tempusersData.cat_slno">
                                        <option value = "" label = "Please Select"></option>
                                        <option ng-repeat="c in cats" value="{{c.slno}}"
                                                    ng-selected="{{ c.Selected == true }}">
                                            {{c.description}}
                                        </option>
                                    </select>
                        </div>
                          <div class="form-group col-xs-3">
                            <label for="isadmin">Is Admin</label>
                            <select name="ddladmin" id="ddladmin" class="form-control dropdown" required aria-required="true" ng-model="tempusersData.isadmin">
                                        <option value = "N" label = "NO" ></option>
                                        <option value = "Y" label = "YES"></option>
                                        
                                    </select>
                        </div>
                        <div class="form-group col-xs-6">
                            <a href="javascript:void(0);" class="btn btn-warning" onclick="$('.formData').slideUp();" ng-click="cancel()">Cancel</a>
                            <a href="javascript:void(0);" class="btn btn-success" ng-hide="tempusersData.slno" ng-click="addUsers()">Add</a>
                            <a href="javascript:void(0);" class="btn btn-success" ng-hide="!tempusersData.slno" ng-click="updateusers()">Update </a>
                        </div>
                    </form>
                </div>
                <table class="table table-striped">
                    <tr>
                        <th width="5%">#</th>
                        <th width="20%">User Name</th>
                        <th width="30%">Email</th>
                        <th width="30%">Mobile</th>
                        <th> Edit</th>
                    </tr>
                    <tr ng-repeat="u in users | orderBy :'emplname'">
                        <td>{{$index + 1}}</td>
                        <td>{{u.emplname}}</td>
                        <td>{{u.emailid}}</td>
                        <td>{{u.mobile}}</td>
                        <td>
                            <a href="javascript:void(0);" class="glyphicon glyphicon-edit" ng-click="editUsers(u)"></a>
                            <!--<a href="javascript:void(0);" class="glyphicon glyphicon-trash" ng-click="deleteUser(user)"></a>-->
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="../js/users.js">

    </script>
</body>

</html>