    <div class="row">
        <div class="col-md-6 col-md-offset-2">
            <h3>Welcome dear students</h3>
        </div>
        <div class="col-md-2 col-md-offset-1">
            <!--
            <a target="_blank"  class="btn btn-primary btn-small" href="<?php echo site_url('login')?>"     tabindex = "-1"  > Teacher Login</a>
            -->
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
<?php foreach ($users as $dpt): 
    
    ?>
<div class="row">
    <div class="col-md-8 col-md-offset-2">
       <ul>
           <li>
             
             <?php print( $dpt->name);?>
             <?php // print( $dpt->id);?>
             <?php 
             if(key_exists($dpt->id, $courses_data)){
             foreach ($courses_data[$dpt->id] as $course_id=>$course_title): 
                // print_r($courses_data[$dpt->id]);
                 ?>
             <ul>
                <?php 
                //if($item1->id == $item2->course_id){ ?>
                 <li>
                     <?php print( $course_title); ?>
                     <ul>
                        <?php foreach ($cmb_data[$dpt->id] as $item3): 
                           // print_r($cmb_data[$dpt->id]);
                            ?>
                         <?php 
                             if($course_id == $item3->course_id){ ?>   
                                <li> 
                                    <a target="_blank"  href="<?php echo site_url('cmb/download/'.$item3->cmb_id)?>"     tabindex = "-1"  ><span class="glyphicon glyphicon-download" ></span> <?php print( $item3->cmb_title); ?></a>
                                </li>
                            <?php  }
                            ?>
                         <?php endforeach; ?>
                     </ul>
                 </li>
              <?php  //}
                ?>
             </ul>
             <?php endforeach; 
             }
             ?>
         </li>
        
    </ul>
    </div>
</div>
<?php endforeach; ?>
    </div>
</body>
</html>

