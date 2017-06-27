// define application
angular.module("crudApp", [])
.controller("catController", function($scope,$http){
    $scope.cats = [];
    $scope.tempcatData = {};
    // function to get records from the database
    $scope.getRecords = function(){
        $http.get('../controllers/catcrud.php', {
            params:{
                'type':'view'
            }
        }).success(function(response){
            //console.log(response);
            if(response.status == 'OK'){
                console.log(response.records);
                $scope.cats = response.records;
            }
        });
    };
    
    // function to insert or update cat data to the database
    $scope.saveCat = function(type){
        var data = $.param({
            'data':$scope.tempcatData,
            'type':type
        });
        var config = {
            headers : {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        };
        $http.post("../controllers/catcrud.php", data, config).success(function(response){
            if(response.status == 'OK'){
                if(type == 'edit'){
                    $scope.cats[$scope.index].slno = $scope.tempcatData.slno;
                    $scope.cats[$scope.index].description = $scope.tempcatData.description;
                    $scope.cats[$scope.index].rec_status = $scope.tempcatData.rec_status;
                    
                }else{
                    $scope.cats.push({
                        slno:response.data.slno,
                        description:response.data.description,
                        rec_status:response.data.rec_status
                        
                    });
                    
                }
                $scope.catForm.$setPristine();
                $scope.tempcatData = {};
                $('.formData').slideUp();
                $scope.messageSuccess(response.msg);
            }else{
                $scope.messageError(response.msg);
            }
        });
    };
    
    // function to add cat data
    $scope.addCat = function(){
        $scope.saveCat('add');
    };
    
    // function to edit cat data
    $scope.editCat = function(cat){
        console.log(cat);
        $scope.tempcatData = {
            slno:cat.slno,
            description:cat.description,
            rec_status:cat.rec_status
        };
        $scope.index = $scope.cats.indexOf(cat);
        $('.formData').slideDown();
        
    };
    
    // function to update cat data
    $scope.updatecat = function(){
        $scope.saveCat('edit');
    };
    
    // function to delete cat data from the database
    $scope.deletecat = function(cat){
        var conf = confirm('Are you sure to delete the cat?');
        if(conf === true){
            var data = $.param({
                'slno': cat.slno,
                'type':'delete'    
            });
            var config = {
                headers : {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                }    
            };
            $http.post("action.php",data,config).success(function(response){
                if(response.status == 'OK'){
                    var index = $scope.cats.indexOf(cat);
                    $scope.cats.splice(index,1);
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