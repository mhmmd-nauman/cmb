 <main role="main">

      <div class="jumbotron" style="padding-top: 120px; background-color: #2B357C;">
        <div class="container">
          <h1 class="display-3 text-white">Welcome Students!</h1>
          <p style="color:#E5AC39;"><b>Course Material Bundle Repository</b>&nbsp;Search and Select department / course / teacher name to download the study material in zip file.</p>
           <input class="form-control" id="anything" type="text" placeholder="Search Department / Course / Teacher">
        </div>
      </div>    


<?php foreach ($users as $dpt):?>

 <div class="container" id="data">
        <div class="panel-group">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="panel-title"><a class="btn bg-light w-100 text-left" data-toggle="collapse" href="#economics"><?php print( $dpt->name);?></a></h4></div>
             
             <?php // print( $dpt->id);?>
             <?php 
             if(key_exists($dpt->id, $courses_data)){

             foreach ($courses_data[$dpt->id] as $course_id=>$course_title): 
                // print_r($courses_data[$dpt->id]);
                 ?>


                  <div id="economics" class="panel-collapse collapse">
              <!-- 2nd level List -->
              <ul class="list-group">
                
                <?php 
                //if($item1->id == $item2->course_id){ ?>

                     <a data-toggle="collapse" href="#subject1"><li class="list-group-item"><?php print( $course_title); ?></li></a>
                      
                 <div id="subject1" class="panel-collapse collapse">
                        <!-- 3nd level List of subject 1 accounting -->
                        <ul class="list-group">
                        <?php foreach ($cmb_data[$dpt->id] as $item3): 
                           // print_r($cmb_data[$dpt->id]);
                            ?>
                         <?php 
                             if($course_id == $item3->course_id){ ?>   
                                <li class="list-group-item"> 
                                    <a target="_blank"  href="<?php echo site_url('cmb/download/'.$item3->cmb_id)?>"     tabindex = "-1"  ><span class="glyphicon glyphicon-download" ></span> <?php print( $item3->cmb_title); ?></a>
                                </li>
                            <?php  }
                            ?>
                         <?php endforeach; ?>
                     </ul>
                 </div>
              <?php  //}
                ?>
             </ul>
         </div>
             <?php endforeach; 
             }
             ?>
        
    </div>
</div>
</div>
<?php endforeach; ?>
 </main>



 <footer class="text-muted text-white mt-5 p-2" style="background-color: #2B357C;">
      <div class="container">
        <p class="float-right">
          <a href="#anything">Back to top</a>
        </p>
        <p>Course Material Bundle Repository @ iub</p>
      </div>
    </footer>
</body>
</html>
