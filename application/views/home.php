    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h3>Welcome {<?php echo $this->session->userdata['name']?>}</h3>
        </div>
    </div>
<br><hr>
<?php if(in_array("1", $this->session->userdata['roles'])){?>
      <div class="row">
         <div class="col-md-2 col-md-offset-2">
             <b> Departments</b>: <button class="btn btn-info btn-block"><?php echo count($departments);?></button> 
         </div>
         <div class="col-md-2">
             <b> Courses</b>: <button class="btn btn-info btn-block"><?php echo count($courses);?></button> 
         </div>
      
         <div class="col-md-2 ">
             <b> Downloads</b>: <button class="btn btn-info btn-block"><?php echo $downloaded;?></button> 
         </div>
         <div class="col-md-2">
             <b> User visits</b>: <button class="btn btn-info btn-block"><?php echo $visits;?></button>  
         </div>
         
    </div>
<?php } else {?>
<div class="row">
        <div class="col-md-2 col-md-offset-3">
            <a href="<?= site_url('cmb')?>" class=" btn btn-success btn-small">Manage CMB List</a>    
         
        </div>
        <div class="col-md-2 col-md-offset-1">
            <a href="<?= site_url('course')?>" class=" btn btn-success btn-small">Manage Course List</a>    
         
        </div>
        </div>
<?php } ?>
    </div>
</body>
</html>

