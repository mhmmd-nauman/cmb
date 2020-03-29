<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <h2><?php echo $title; ?></h2>

<?php echo validation_errors(); ?>

<?php echo form_open_multipart('cmb/create'); ?>

    <div class="form-group">
        <label for="email">Teacher:</label>
        <input name="cmb_title" type="text" class="form-control" id="cmb_title">
    </div>
    <div class="form-group">
        <label for="email">Select File:</label>
        <input name="userfile" size="20"  type="file" class="form-control" id="userfile">
    </div>
    <?php //echo $this->session->userdata('name');
    //print_r($this->session->userdata);
    ?>
    <div class="form-group">
        <label for="email">Course:</label>
        <select name="course_id" class="form-control">
        <?php  foreach ($courses as $item): ?>
            <option  value="<?php echo $item->course_id;?>"><?php echo $item->course_title;?></option>
        <?php endforeach; ?>
        </select>
    </div>

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