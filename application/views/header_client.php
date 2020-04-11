<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php date_default_timezone_set("Asia/Karachi"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Course Material Bundle - IUB</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
 
   <!-- Styles -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/js/DataTables-1.10.13/media/css/jquery.dataTables.css" >
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/time-line.css">
    <!--
    <link rel="stylesheet" type="text/css" href="assets/mdb-free/css/mdb.css">
    -->
<link rel="stylesheet" href="<?php echo base_url();?>assets/bootstrap/dist/css/bootstrap.min.css" >
<script src="<?php echo base_url();?>assets/js/jquery-3.1.1.min.js"></script>
<script src="<?php echo base_url();?>assets/js/popper.min.js" ></script>
<script src="<?php echo base_url();?>assets/bootstrap/dist/js/bootstrap.min.js" ></script>


    
    <script src="<?php echo base_url();?>assets/js/DataTables-1.10.13/media/js/jquery.dataTables.js" ></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url();?>assets/js/DataTables-1.10.13/examples/resources/syntax/shCore.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url();?>assets/js/DataTables-1.10.13/examples/resources/demo.js"></script>
    
    <script src="<?php echo base_url();?>assets/js/angular.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/jquery-ui-1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="<?php echo base_url();?>assets/js/jquery-ui-1.12.1/jquery-ui.css">
   
<script>
  $(document).ready(function () {
  $("#anything").on("keyup", function () {
    var value = $(this).val().toLowerCase();
    $("#data *").filter(function () {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>

</head>

<body >


<nav class="navbar navbar-expand-md  bg-white fixed-top shadow-sm">
      <div class="container d-flex justify-content-between">
          <a href="#" class="navbar-brand d-flex align-items-center">
            <img src="<?php echo base_url();?>images/iub_name_logo.png" height="50">
          </a>
        </div>
    </nav>


