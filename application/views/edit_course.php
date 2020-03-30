<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <h2><?php echo $title; ?></h2>

<?php echo validation_errors(); ?>

<?php echo form_open('course/edit/'. $course->course_id); ?>

    
    <div class="form-group">
        <label for="email">Title:</label>
        <input value="<?php echo $course->course_title; ?>" name="course_title" type="text" class="form-control" id="course_title">
    </div>
    <!--
    <div class="form-group">
        <label for="email">Department:</label>
        <select name="deptID" class="form-control">
        <?php  //foreach ($departments as $item): ?>
            <option  value="<?php //echo $item->department_id;?>"><?php //echo $item->department_title;?></option>
        <?php //endforeach; ?>
        </select>
    </div>
    -->

    <button type="submit" class="btn btn-primary">Submit</button>

</form>
    </div>
</div>

    </div>
</body>
</html>

<script type="text/javascript">
$(document).ready(function(){
    
});
</script>