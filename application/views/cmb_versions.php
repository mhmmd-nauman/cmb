<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="row">
    <div class=" col-md-5 col-md-offset-1">
        <h4>Course Material Bundle - Older Version List</h4>
    </div>
    <div class=" col-md-2 col-md-offset-3">
       
    </div>
</div>
<DIV class="row">
         <div class=" col-md-10 col-md-offset-1">
            
            <table class="table table-bordered table-hover table-striped" id="myTable">
                <thead>
                    <tr>
                        <th class=" col-md-1">ID#</th>
                        <th >CMB</th>
                        <th class=" col-md-3">Department</th>
                        <th class=" col-md-3">Course</th>
                        <th class=" col-md-1">Version</th>
                        <th class=" col-md-1">Downloaded</th>
                        <th class=" col-md-1">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php 
                    //print_r($courses);
                    if(count((array)$cmbs_versions)>0){
                    foreach ($cmbs_versions as $item):
                        //print_r($course_item);
                        $active_record = $item->cmb_id;
                    ?>
                    <tr >
                      <td><?php echo $item->cmb_id;?></td>
                      
                      <td><?php echo $item->cmb_title;?></td>
                      <td><?php echo $users_array[$item->user_id];?></td>
                      <td><?php echo $courses_array[$item->course_id];?></td>
                      <td><?php echo $item->version_number;?></td>
                      <td><?php echo $item->downloaded;?></td>
                      <td>
                          <div class = "dropdown pull-right">
   
                              <button  type = "button" class = "btn btn-success dropdown-toggle" id = "dropdownMenu_actions" data-toggle = "dropdown">
                                           Action
                                           <span class = "caret"></span>
                                        </button>
                                        <ul class = "dropdown-menu" role = "menu" aria-labelledby = "dropdownMenu_actions">
                                            
                                            <li role = "presentation">
                                                <?php $item->file_path = str_replace("uploads/", "", $item->file_path)?>
                                                <a target="_blank"  href="<?php echo site_url('cmb/download_revision/'.$item->cmb_id.'/'.$item->file_path)?>" class="edit_button" id="<?php echo $active_record;?>"  role = "menuitem" tabindex = "-1"  ><span class="glyphicon glyphicon-download" ></span> Download</a>
                                            </li>
                                            
                                            
                                            
                                            
                                            
                                         </ul>
                                    </div>
                          
                      </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php } ?>
                    
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