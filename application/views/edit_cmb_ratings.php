<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <h2><?php echo $title; ?></h2>

<?php echo validation_errors(); ?>

<?php 
//print_r($cmb);
echo form_open_multipart('cmb/edit_ratings/'.$cmb->cmb_id); 
$cmb_data->cmb_title = str_replace(".rar","",$cmb_data->cmb_title);
?>

    <div class="form-group">
        <label for="email">CMB:</label>
        <p class="content red-text"><b><?php echo str_replace(".zip","",$cmb_data->cmb_title);?>/Course/Department</b></p>
    </div>
    
    <?php //echo $this->session->userdata('name');
    //print_r($this->session->userdata);
    ?>
    <div class="form-group">
        <label for="email">CMB Rating(1=Lowest,5=Highest):</label>
        <select name="ratings" class="form-control">
            <option value="0">Select Rating</option>
            <?php  for ($i=1; $i<6; $i++){ ?>
                <option <?php if($cmb->ratings == $i)echo"selected";?>  value="<?php echo $i;?>"><?php echo $i;?></option>
            <?php } ?>
        </select>
    </div>
    
    <div class="form-group">
        <label for="email">Remarsk:</label>
        <textarea class="form-control" name="remarks" rows="2" required=""><?php echo $cmb->remarks;?></textarea>
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