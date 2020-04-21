<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="row">
    <div class=" col-md-5 col-md-offset-1">
        <h4>Course Material List</h4>
    </div>
    <div class=" col-md-2 col-md-offset-3">
        <a href="<?= site_url('cmb/create')?>" class=" btn btn-success btn-small">Upload CMB Material</a>
    </div>
    </div>
    <div class="row">
    <div class=" col-md-9 col-md-offset-1">
        <form action="<?= site_url('cmb/index/searchbydpt')?>" class = "form-inline" role = "form" method="post">
            <div class="form-group">
                <label for="email">Select Department:</label>
                <select name="dpt_id" class="form-control">
                    <option value="0">Select Department</option>
                    <?php  foreach ($dpts_array as $usr_id=>$user_name){ ?>
                        <option <?php if($searched_dpt == $usr_id)echo"selected";?>  value="<?php echo $usr_id;?>"><?php echo $user_name;?></option>
                    <?php } ?>
                </select>
            </div>
            <button type = "submit" class = "btn btn-default">Search</button>
            
        </form>
    </div>
    
</div>
<br>
<DIV class="row">
         <div class=" col-md-10 col-md-offset-1">
            
            <table class="table table-bordered table-hover table-striped" id="myTable">
                <thead>
                    <tr>
                        <th >CMB/ Log/ Ratings/ Remarks</th>
                        <th class=" col-md-2">Department</th>
                        <th class=" col-md-2">Course</th>
                        <th class=" col-md-1">Version </th>
                        <th class=" col-md-1">Downloaded</th>
                        <th class=" col-md-1">Size(Mbs)</th>
                        <th class=" col-md-1">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php 
                    //print_r($courses);
                    if(count((array)$cmbs)>0){
                    foreach ($cmbs as $item):
                        //print_r($course_item);
                        $active_record = $item->cmb_id;
                    ?>
                    <tr >
                      <td><?php echo $item->cmb_title; 
                      if(!empty($item->change_log)){?><br><b>Log:</b><?php echo $item->change_log;}
                      if($cmb_ratings[$item->cmb_id]->ratings > 1){?><br><b>Rating:</b><?php echo $cmb_ratings[$item->cmb_id]->ratings;}
                      if(!empty($cmb_ratings[$item->cmb_id])&&!empty($cmb_ratings[$item->cmb_id]->remarks)){?><br><b>Remarks:</b><?php echo $cmb_ratings[$item->cmb_id]->remarks;}
                      ?>
                      </td>
                      <td><?php echo $users_array[$item->user_id];?></td>
                      <td><?php echo $courses_array[$item->course_id];?></td>
                      <td><?php echo $item->version_number;?></td>
                      <td><?php echo $item->downloaded;?></td>
                      <td><?php echo @ceil((@filesize($item->file_path)/1024)/1024);?></td>
                      <td>
                          <?php if(in_array("4", $this->session->userdata['roles'])){?>
                              <div class = "dropdown pull-right">
                              
                              <button  type = "button" class = "btn btn-success dropdown-toggle" id = "dropdownMenu_actions" data-toggle = "dropdown">
                                           Action
                                           <span class = "caret"></span>
                                        </button>
                                        <ul class = "dropdown-menu" role = "menu" aria-labelledby = "dropdownMenu_actions">
                                            <li role = "presentation">
                                                <a   href="<?php echo site_url('cmb/edit_ratings/'.$item->cmb_id)?>" class="edit_button" id="<?php echo $active_record;?>"  role = "menuitem" tabindex = "-1"  ><span class="glyphicon glyphicon-book" ></span> Rate & Remarks</a>
                                            </li>
                                            
                                            <li class = "divider"></li>
                                            <li role = "presentation">
                                                <a target="_blank"  href="<?php echo site_url('cmb/download/'.$item->cmb_id)?>" class="edit_button" id="<?php echo $active_record;?>"  role = "menuitem" tabindex = "-1"  ><span class="glyphicon glyphicon-download" ></span> Download</a>
                                            </li>
                                            
                                        </ul>
                                    </div>
                          <?php } else {?>
                          <div class = "dropdown pull-right">
                              
                              <button  type = "button" class = "btn btn-success dropdown-toggle" id = "dropdownMenu_actions" data-toggle = "dropdown">
                                           Action
                                           <span class = "caret"></span>
                                        </button>
                                        <ul class = "dropdown-menu" role = "menu" aria-labelledby = "dropdownMenu_actions">
                                            <li role = "presentation">
                                                <a   href="<?php echo site_url('cmb/edit/'.$item->cmb_id)?>" class="edit_button" id="<?php echo $active_record;?>"  role = "menuitem" tabindex = "-1"  ><span class="glyphicon glyphicon-edit" ></span> Revise</a>
                                            </li>
                                            <li class = "divider"></li>
                                            <li role = "presentation">
                                                <a onclick="return confirm('Are you sure you want to delete this item?');"  href="<?php echo site_url('cmb/delete/'.$item->cmb_id)?>" class="edit_button" id="<?php echo $active_record;?>"  role = "menuitem" tabindex = "-1"  ><span class="glyphicon glyphicon-remove" ></span> Delete</a>
                                            </li>
                                            <li class = "divider"></li>
                                            <li role = "presentation">
                                                <a target="_blank"  href="<?php echo site_url('cmb/download/'.$item->cmb_id)?>" class="edit_button" id="<?php echo $active_record;?>"  role = "menuitem" tabindex = "-1"  ><span class="glyphicon glyphicon-download" ></span> Download</a>
                                            </li>
                                            <li class = "divider"></li>
                                            <li role = "presentation">
                                                <a   href="<?php echo site_url('cmb/view_revisions/'.$item->cmb_id)?>" class="edit_button" id="<?php echo $active_record;?>"  role = "menuitem" tabindex = "-1"  ><span class="glyphicon glyphicon-book" ></span> View Old Revisions</a>
                                            </li>
                                        </ul>
                                    </div>
                          <?php }?>
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