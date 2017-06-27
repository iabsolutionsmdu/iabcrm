<html>
    <head>
        <title>IAB Base</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
   
    <script src="https://code.jquery.com/jquery-1.10.2.min.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
      <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="~/Scripts/html5shiv.min.js"></script>
        <script src="~/Scripts/respond.min.js"></script>
    <![endif]-->
    <!--[if lt IE 8]>
        <script src="~/Scripts/excanvas.js"></script>
        
    <![endif]-->

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
        </head>
    <body>
        <form name="formprocess" method="post" >
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
                <a class="navbar-brand" href="Index.html">IAB</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav">

                  
                    <li class="active">
                        <a href="Index.html">Home</a>
                    </li>
                    <li>
                         <a href="newreport.html" >Reports</a>
                    </li>

                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
    <div class="row">
        <div class="col-lg-12 col-md-12">
            
<?php
    ini_set('display_errors', 1); error_reporting(-1);
    ini_set('error_log', 'files/log.txt');
    ini_set('log_errors_max_len', 0);
    ini_set('log_errors', true);
    include 'prop.php';
if (isset($_GET["args"])){
        $args=$_GET["args"];
    }
  
       try{
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $selectqry="SELECT * from mstbase where base_name= ? ";
             $sth = $conn->prepare($selectqry);
             $sth->bindParam(1,$args);
             $sth->execute();
            
                $mobilenos = $sth->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <table class="table table-bordered" id="tbl1">
                    <thead><th>Mobile No</th><th>Result</th></thead><tbody>
                <?php
                foreach($mobilenos as $row){
                  
                   // echo $row["Mobileno"];
                    echo "<tr><td>" . $row["Mobileno"] . "</td><td><input type='text' id='txtresult' name='txtresult'/></td>";
                }

             }catch(Exception $e){
                  echo 'Caught exception: ',  $e->getMessage(), "\n";

             }
    ?>
    </tbody></table>
    </div>

    </div>
    <div class="row">
        <div class="col-lg-5">
            <input type="button" id="btnsend" name="btnsend" value="Send SMS"/>
        </div>
        </div>
</form>
<script type="text/javscript">
    $(document).ready(function(){
        $('#btnsend').on('click',function(e){
            e.preventDefault();

            $('#tbl1 > tbody > tr').each(function(i,j){
                
            });
            
        });
    });
</script>
</body>
    </html>