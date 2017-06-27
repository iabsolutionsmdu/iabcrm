// define application
angular.module("crudApp", [])
.controller("deptController", function($scope,$http){
    $scope.depts = [];
    $scope.tempdeptData = {};
    // function to get records from the database
    $scope.getRecords = function(){
        $http.get('../controllers/deptcrud.php', {
            params:{
                'type':'view'
            }
        }).success(function(response){
            //console.log(response);
            if(response.status == 'OK'){
                console.log(response.records);
                $scope.depts = response.records;
            }
        });
    };
    
    // function to insert or update dept data to the database
    $scope.saveDept = function(type){
        var data = $.param({
            'data':$scope.tempdeptData,
            'type':type
        });
        var config = {
            headers : {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        };
        $http.post("../controllers/deptcrud.php", data, config).success(function(response){
            if(response.status == 'OK'){
                if(type == 'edit'){
                    $scope.depts[$scope.index].slno = $scope.tempdeptData.slno;
                    $scope.depts[$scope.index].dept_name = $scope.tempdeptData.dept_name;
                    $scope.depts[$scope.index].dept_code = $scope.tempdeptData.dept_code;
                    $scope.depts[$scope.index].rec_status = $scope.tempdeptData.rec_status;
                    
                }else{
                    $scope.depts.push({
                        slno:response.data.slno,
                        dept_name:response.data.dept_name,
                        dept_code:response.data.dept_code,
                        rec_status:response.data.rec_status
                        
                    });
                    
                }
                $scope.deptForm.$setPristine();
                $scope.tempdeptData = {};
                $('.formData').slideUp();
                $scope.messageSuccess(response.msg);
            }else{
                $scope.messageError(response.msg);
            }
        });
    };
    
    // function to add dept data
    $scope.addDept = function(){
        $scope.saveDept('add');
    };
    
    // function to edit dept data
    $scope.editDept = function(dept){
        console.log(dept);
        $scope.tempdeptData = {
            slno:dept.slno,
            dept_name:dept.dept_name,
            dept_code:dept.dept_code,
            rec_status:dept.rec_status
        };
        $scope.index = $scope.depts.indexOf(dept);
        $('.formData').slideDown();
        angular.element("input[name='dept_code']").trigger('focus');
    };
    
    // function to update dept data
    $scope.updatedept = function(){
        $scope.savedept('edit');
    };
    
    // function to delete dept data from the database
    $scope.deletedept = function(dept){
        var conf = confirm('Are you sure to delete the dept?');
        if(conf === true){
            var data = $.param({
                'slno': dept.slno,
                'type':'delete'    
            });
            var config = {
                headers : {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                }    
            };
            $http.post("action.php",data,config).success(function(response){
                if(response.status == 'OK'){
                    var index = $scope.depts.indexOf(dept);
                    $scope.depts.splice(index,1);
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