<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php date_default_timezone_set("Asia/Karachi"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>CMB</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <style type="text/css">
    .panel-heading a{float: right;}
    #importFrm{margin-bottom: 20px;display: none;}
    #importFrm input[type=file] {display: inline;}
    .navbar-default {
        background-color: red;
    }
    .navbar-default .navbar-nav>li>a{ color: #fff;}
  </style>
   <!-- Styles -->
   <link rel="stylesheet" href="<?php echo base_url();?>assets/bootstrap/dist/css/bootstrap.min.css" >
    <link rel="stylesheet" href="<?php echo base_url();?>assets/js/DataTables-1.10.13/media/css/jquery.dataTables.css" >
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/time-line.css">
    <!--
    <link rel="stylesheet" type="text/css" href="assets/mdb-free/css/mdb.css">
    -->
    
    <script src="<?php echo base_url();?>assets/js/jquery-3.1.1.min.js" ></script>
    <script src="<?php echo base_url();?>assets/bootstrap/dist/js/bootstrap.js" ></script>
    
    <script src="<?php echo base_url();?>assets/js/DataTables-1.10.13/media/js/jquery.dataTables.js" ></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url();?>assets/js/DataTables-1.10.13/examples/resources/syntax/shCore.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url();?>assets/js/DataTables-1.10.13/examples/resources/demo.js"></script>
    
    <script src="<?php echo base_url();?>assets/js/angular.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/jquery-ui-1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="<?php echo base_url();?>assets/js/jquery-ui-1.12.1/jquery-ui.css">
    
    <script type="text/javascript" src="<?php echo base_url();?>assets/app/app.js"></script>
    <script src="<?php echo base_url();?>assets/js/pleaseWait.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/mdb-free/js/mdb.js"></script>
</head>

<body >
    <div class="container-fluid">
        <div class="row">						
            <div  class="col-md-12 " >
                
                    <img src="<?php echo base_url();?>images/iub_name_logo.png"  class="center-block"/>
                </a>
            </div>
        </div>
        <div class="row">	
            <div class="col-md-12 text-center">
                
                <h3> CMB Repository</h3>
                </a>
            </div>						
        </div>
        <BR>
       