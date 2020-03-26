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

<body class="text-center">
    <div class="container-fluid">
        <div class="row">						
            <div  class="col-md-12 " >
                
                    <img src="<?php echo base_url();?>images/iub_name_logo.png"  class="center-block"/>
                </a>
            </div>
        </div>
        <div class="row">	
            <div class="col-md-12">
                
                <h2> CMB Repository</h2>
                </a>
            </div>						
        </div>
        <BR>
        <div class="row">
            <div class=" col-md-12">
                <nav class = "navbar navbar-default" role = "navigation" >
   
                <div class = "navbar-header">
                   <a class = "navbar-brand" href = "<?php echo base_url();?>/">IUB CMB Repository</a>
                </div>

                <div>
                   <ul class = "nav navbar-nav">
                      <li class = "dropdown">
                         <a href = "#" class = "dropdown-toggle" data-toggle = "dropdown">
                            Applications Manager 
                            <b class = "caret"></b>
                         </a>

                         <ul class = "dropdown-menu">
                            <li><a href ="#" data-toggle="modal" data-target="#FindApplicantApplicationsModal">Find Applications</a></li> 
                            <li class = "divider"></li>
                            <li><a href = "receieved_apps_programs_wise.php">Received Applications - Programme Wsie</a></li>
                            
                            <li class = "divider"></li>
                            <li><a href ="#" data-toggle="modal" data-target="#FindApplicantModal">Find an Applicants</a></li>
                            <li class = "divider"></li>
                            <li>
                                <a href ="programs_offered.php"  >Programs Offered</a>
                            </li>
                           
                            
                        </ul>

                      </li>
                      
           
                      <li><a href = "system_users.php">Users/Administrators</a></li>
                      <li><a href = "<?= site_url('login/logout')?>">Logout</a></li>
          
                   </ul>
                </div>

             </nav>
            </div>   
            
        </div>

        <DIV class="row">
         <div class=" col-md-10 col-md-offset-1">
            
            <table class="table table-bordered table-hover table-striped" id="myTable">
                <thead>
                    <tr>
                      <th>ID#</th>
                      <th class=" col-md-6">Name</th>
                     
                      <th class=" col-md-3">Department</th>
                      <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php 
                    //print_r($courses);
                    foreach ($courses as $course_item):
                        //print_r($course_item);
                        $active_record = $course_item->course_id;
                    ?>
                    <tr >
                      <td><?php echo $course_item->course_id;?></td>
                      
                      <td><?php echo $course_item->course_title;?></td>
                      <td><?php echo $course_item->deptID;?></td>
                      <td>
                          <div class = "dropdown pull-right">
   
                              <button  type = "button" class = "btn btn-success dropdown-toggle" id = "dropdownMenu_actions" data-toggle = "dropdown">
                                           Action
                                           <span class = "caret"></span>
                                        </button>
                                        <ul class = "dropdown-menu" role = "menu" aria-labelledby = "dropdownMenu_actions">
                                            
                                            
                                            <li role = "presentation">
                                                <a  href="#" class="edit_button" id="<?php echo $active_record;?>"  role = "menuitem" tabindex = "-1" data-toggle="modal" data-target="#viewDepartmentModal" ><span class="glyphicon glyphicon-edit" ></span> Edit Department</a>
                                            </li>
                                            
                                            
                                            
                                            
                                         </ul>
                                    </div>
                          
                      </td>
                    </tr>
                    <?php endforeach; ?>
                   
                    
                </tbody>
            </table>
         </div>
        </div>
    </div>
</body>
</html>

