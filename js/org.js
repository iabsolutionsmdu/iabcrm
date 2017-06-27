// define application
angular.module("crudApp", [])
.controller("orgController", function($scope,$http){
    $scope.orgs = [];
    $scope.temporgData = {};
    // function to get records from the database
    $scope.getRecords = function(){
        $http.get('../controllers/orgcrud.php', {
            params:{
                'type':'view'
            }
        }).success(function(response){
            //console.log(response);
            if(response.status == 'OK'){
                console.log(response.records);
                $scope.orgs = response.records;
            }
        });
    };
    
    // function to insert or update org data to the database
    $scope.saveOrg = function(type){
        var data = $.param({
            'data':$scope.temporgData,
            'type':type
        });
        var config = {
            headers : {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        };
        $http.post("../controllers/orgcrud.php", data, config).success(function(response){
            if(response.status == 'OK'){
                if(type == 'edit'){
                    $scope.orgs[$scope.index].slno = $scope.temporgData.slno;
                    $scope.orgs[$scope.index].orgname = $scope.temporgData.orgname;
                    $scope.orgs[$scope.index].orgcode = $scope.temporgData.orgcode;
                    $scope.orgs[$scope.index].rec_status = $scope.temporgData.rec_status;
                    
                }else{
                    $scope.orgs.push({
                        slno:response.data.slno,
                        orgname:response.data.orgname,
                        orgcode:response.data.orgcode,
                        rec_status:response.data.rec_status
                        
                    });
                    
                }
                $scope.orgForm.$setPristine();
                $scope.temporgData = {};
                $('.formData').slideUp();
                $scope.messageSuccess(response.msg);
            }else{
                $scope.messageError(response.msg);
            }
        });
    };
    
    // function to add org data
    $scope.addOrg = function(){
        $scope.saveOrg('add');
    };
    
    // function to edit org data
    $scope.editOrg = function(org){
        console.log(org);
        $scope.temporgData = {
            slno:org.slno,
            orgname:org.orgname,
            orgcode:org.orgcode,
            rec_status:org.rec_status
        };
        $scope.index = $scope.orgs.indexOf(org);
        $('.formData').slideDown();
        angular.element("input[name='orgcode']").trigger('focus');
    };
    
    // function to update org data
    $scope.updateorg = function(){
        $scope.saveOrg('edit');
    };
    
    // function to delete org data from the database
    $scope.deleteorg = function(org){
        var conf = confirm('Are you sure to delete the org?');
        if(conf === true){
            var data = $.param({
                'slno': org.slno,
                'type':'delete'    
            });
            var config = {
                headers : {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                }    
            };
            $http.post("action.php",data,config).success(function(response){
                if(response.status == 'OK'){
                    var index = $scope.orgs.indexOf(org);
                    $scope.orgs.splice(index,1);
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