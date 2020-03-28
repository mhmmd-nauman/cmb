    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h3>Welcome {<?php echo $this->session->userdata['username']?>}</h3>
        </div>
    </div>
<br><hr>
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
    </div>
</body>
</html>

