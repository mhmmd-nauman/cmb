<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="row">
    <div class=" col-md-5 col-md-offset-1">
        <h4>Course List</h4>
    </div>
    <div class=" col-md-2 col-md-offset-3">
        <a href="<?= site_url('course/create')?>" class=" btn btn-success btn-small">Add New Course</a>
    </div>
</div>
<DIV class="row">
         <div class=" col-md-10 col-md-offset-1">
            
            <table class="table table-bordered table-hover table-striped" id="myTable">
                <thead>
                    <tr>
                      <th class=" col-md-1">ID#</th>
                      <th >Name</th>
                     
                      
                      <th class=" col-md-1">Actions</th>
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
                     <!-- <td><?php //echo $departments[$course_item->deptID];?></td> -->
                      <td>
                          <div class = "dropdown pull-right">
   
                              <button  type = "button" class = "btn btn-success dropdown-toggle" id = "dropdownMenu_actions" data-toggle = "dropdown">
                                           Action
                                           <span class = "caret"></span>
                                        </button>
                                        <ul class = "dropdown-menu" role = "menu" aria-labelledby = "dropdownMenu_actions">
                                            
                                            
                                            <li role = "presentation">
                                                <a  href="#" class="edit_button" id="<?php echo $active_record;?>"  role = "menuitem" tabindex = "-1" data-toggle="modal" data-target="#viewDepartmentModal" ><span class="glyphicon glyphicon-edit" ></span> Edit </a>
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

<script type="text/javascript">
$(document).ready(function(){
    $('#myTable').DataTable({
        stateSave: true
    });
});
</script>