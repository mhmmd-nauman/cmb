    <div class="row">
        <div class="col-md-6 col-md-offset-2">
            <h3>Welcome dear students</h3>
        </div>
        <div class="col-md-2 col-md-offset-1">
            <a target="_blank"  class="btn btn-primary btn-small" href="<?php echo site_url('login')?>"     tabindex = "-1"  > Teacher Login</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <p>
                Click on the zip file names to download the material for departments respectively. 
            </p>
            
        </div>
    </div>
<br><hr>
<?php foreach ($departments as $item1): ?>
<div class="row">
    <div class="col-md-8 col-md-offset-2">
       <ul>
           <li>
             
             <?php print( $item1->department_title);?>
         
             <?php foreach ($courses as $item2): ?>
             <ul>
                <?php 
                if($item1->department_id == $item2->deptID){ ?>
                 <li>
                     <?php print( $item2->course_title); ?>
                     <ul>
                        <?php foreach ($cmbs as $item3): ?>
                         <?php 
                             if($item2->course_id == $item3->course_id){ ?>   
                                <li> 
                                    <a target="_blank"  href="<?php echo site_url('cmb/download/'.$item3->cmb_id)?>"     tabindex = "-1"  ><span class="glyphicon glyphicon-download" ></span> <?php print( $item3->cmb_title); ?></a>
                                </li>
                            <?php  }
                            ?>
                         <?php endforeach; ?>
                     </ul>
                 </li>
              <?php  }
                ?>
             </ul>
             <?php endforeach; ?>
         </li>
        
    </ul>
    </div>
</div>
<?php endforeach; ?>
    </div>
</body>
</html>

