// define application
angular.module("crudApp", [])
.controller("usersController", function($scope,$http){
    $scope.users = [];
    $scope.orgs =[];
    $scope.depts=[];
    $scope.cats=[];
    $scope.tempusersData = {};
    // function to get records from the database
    $scope.getRecords = function(){
        $http.get('../controllers/userscrud.php', {
            params:{
                'type':'view'
            }
        }).success(function(response){
            //console.log(response);
            if(response.status == 'OK'){
                console.log(response.records);
                $scope.users = response.records;
            }
        });
    };

    $scope.getOrgs=function(){
        $http.get('../controllers/orgcrud.php', {
            params:{
                'type':'view'
            }
        }).success(function(response){
            //console.log(response);
            if(response.status == 'OK'){
              //  console.log(response.records);
                $scope.orgs = response.records;
            }
        });
    };

    $scope.getCats=function(){
        $http.get('../controllers/catcrud.php', {
            params:{
                'type':'view'
            }
        }).success(function(response){
            //console.log(response);
            if(response.status == 'OK'){
              //  console.log(response.records);
                $scope.cats = response.records;
            }
        });
    };
    $scope.getDepts=function(){
         $http.get('../controllers/deptcrud.php', {
            params:{
                'type':'view'
            }
        }).success(function(response){
            //console.log(response);
            if(response.status == 'OK'){
              //  console.log(response.records);
                $scope.depts = response.records;
            }
        });

    };
    $scope.adminstatus=[{
        key: 'Yes',value : 'Y'
    },{
        key:'N',value:'N'
    }]
    
    // function to insert or update users data to the database
    $scope.saveUsers = function(type){
        console.log(type);
        var data = $.param({
            'data':$scope.tempusersData,
            'type':type
        });
        var config = {
            headers : {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        };
        $http.post("../controllers/userscrud.php", data, config).success(function(response){
            if(response.status == 'OK'){
                if(type == 'edit'){
                    $scope.users[$scope.index].slno = $scope.tempusersData.slno;
                    $scope.users[$scope.index].emplname = $scope.tempusersData.emplname;
                    $scope.users[$scope.index].password = $scope.tempusersData.password;
                    $scope.users[$scope.index].emailid = $scope.tempusersData.emailid;
                    $scope.users[$scope.index].mobile = $scope.tempusersData.mobile;
                    $scope.users[$scope.index].org_slno = $scope.tempusersData.org_slno;
                    $scope.users[$scope.index].cat_slno = $scope.tempusersData.cat_slno;
                    $scope.users[$scope.index].dept_slno = $scope.tempusersData.dept_slno;
                    $scope.users[$scope.index].rec_status = $scope.tempusersData.rec_status;
                    $scope.users[$scope.index].isadmin = $scope.tempusersData.isadmin;
                    
                }else{
                    $scope.users.push({
                        slno:response.data.slno,
                        emplname:response.data.emplname,
                        password:response.data.password,
                        emailid:response.data.emailid,
                        mobile:response.data.mobile,
                        org_slno:response.data.org_slno,
                        cat_slno:response.data.cat_slno,
                        dept_slno:response.data.dept_slno,
                        rec_status:response.data.rec_status,
                        isadmin:response.data.isadmin
                        
                    });
                    
                }
                $scope.usersForm.$setPristine();
                $scop.usersForm.$setUntoched();
                $scope.tempusersData = {};
                $('.formData').slideUp();
                $scope.messageSuccess(response.msg);
            }else{
                $scope.messageError(response.msg);
            }
        });
    };
    
    // function to add users data
    $scope.addUsers = function(){
        $scope.saveUsers('add');
    };
    
    // function to edit users data
    $scope.editUsers = function(users){
        //console.log(users);
        $scope.tempusersData = {
            slno:users.slno,
            emplname:users.emplname,
            password:users.password,
            emailid:users.emailid,
            mobile:users.mobile,
            org_slno:users.org_slno,
            cat_slno:users.cat_slno,
            dept_slno:users.dept_slno,
            rec_status:users.rec_status,
            isadmin:users.isadmin
        };
        $scope.index = $scope.users.indexOf(users);
        $('.formData').slideDown();
        angular.element("input[name='emplname']").trigger('focus');
    };
    
    // function to update users data
    $scope.updateusers = function(){
        console.log('update');
        $scope.saveUsers('edit');
    };
    $scope.cancel=function(){
         $scope.usersForm.$setPristine();
                $scop.usersForm.$setUntoched();
                $scope.tempusersData = {};
                $('.formData').slideUp();
    }
    // function to delete users data from the database
    $scope.deleteusers = function(users){
        var conf = confirm('Are you sure to delete the users?');
        if(conf === true){
            var data = $.param({
                'slno': users.slno,
                'type':'delete'    
            });
            var config = {
                headers : {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                }    
            };
            $http.post("action.php",data,config).success(function(response){
                if(response.status == 'OK'){
                    var index = $scope.users.indexOf(users);
                    $scope.users.splice(index,1);
                    $scope.messageSuccess(response.msg);
                }else{
                    $scope.messageError(response.msg);
                }
            });
        }
    };
    
    // function to display success message
    $scope.messageSuccess = function(msg){
        $('.alert-success > p').html(msg);
        $('.alert-success').show();
        $('.alert-success').delay(5000).slideUp(function(){
            $('.alert-success > p').html('');
        });
    };
    
    // function to display error message
    $scope.messageError = function(msg){
        $('.alert-danger > p').html(msg);
        $('.alert-danger').show();
        $('.alert-danger').delay(5000).slideUp(function(){
            $('.alert-danger > p').html('');
        });
    };
});