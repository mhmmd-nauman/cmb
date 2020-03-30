<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <h2><?php echo $title; ?></h2>

<?php echo validation_errors(); ?>

<?php echo form_open_multipart('cmb/edit/'.$cmb->cmb_id); 
$cmb->cmb_title = str_replace(".rar","",$cmb->cmb_title);
?>

    <div class="form-group">
        <label for="email">Teacher:</label>
        <input  value="<?php echo str_replace(".zip","",$cmb->cmb_title);?>" name="cmb_title" type="text" class="form-control" id="cmb_title">
    </div>
    <div class="form-group">
        <label for="email">Select Revised File:</label>
        <input name="userfile" size="20"  type="file" class="form-control" id="userfile">
    </div>
    <?php //echo $this->session->userdata('name');
    //print_r($this->session->userdata);
    ?>
    <div class="form-group">
        <label for="email">Course:</label>
        <select name="course_id" class="form-control">
        <?php  foreach ($courses as $item): ?>
            <option <?php if($item->course_id == $cmb->course_id)echo"selected";?>  value="<?php echo $item->course_id;?>"><?php echo $item->course_title;?></option>
        <?php endforeach; ?>
        </select>
    </div>
    <input type="hidden" value="<?php echo $cmb->file_type;?>" name="file_type" id="file_type">
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