<?php

include 'models/clsuser.php';
//define('BASE_URL', 'http://localhost/iab');
$ret=new \models\users;
if (array_key_exists('user',$_SESSION) && !empty($_SESSION['user']) ){
    $ret=json_decode($_SESSION['user']);
   
}else{
     header("location:../views/login.html");
        die;
}
?>
<nav class="navbar navbar-default  navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                <a class="navbar-brand" href="<?php echo (BASE_URL)?>/index.php">IAB</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                      

                    <li class="dropdown">
                            <a class="dropdown-toggle " data-toggle="dropdown" href="#" >Master
                            <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo (BASE_URL)?>/views/org.php">Organization</a></li>
                                <li><a href="<?php echo (BASE_URL)?>/views/cat.php">Category</a></li>
                                <li><a href="<?php echo (BASE_URL)?>/views/dept.php">Department</a></li>
                                <li><a href="<?php echo (BASE_URL)?>/views/users.php">Users</a></li>
                            </ul>
                        </li>
                  
                    <li>
                         <a href="<?php echo (BASE_URL)?>/views/newreport.html" >Reports</a>
                    </li>

                </ul>
                 <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><span
                        class="glyphicon glyphicon-user"></span><strong>
                            <span><?php echo $ret->emplname; ?> </span> </strong> <span class="glyphicon glyphicon-chevron-down">
                            </span></a>
                            <ul class="dropdown-menu">
                        <li><a href="<?php echo (BASE_URL)?>/views/login.html">Sign Out <span class="glyphicon glyphicon-log-out pull-right"></span></a>
                        </li>
                            </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>