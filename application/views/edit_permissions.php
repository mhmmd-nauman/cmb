<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <h2><?php echo $title; ?></h2>

<?php echo validation_errors(); ?>

<?php echo form_open('permissions/edit/'.$permission->id); ?>

    
    <div class="form-group">
        <label for="email">Name (function-controller):</label>
        <input name="name" value="<?php echo $permission->name;?>" type="text" class="form-control" id="name" required="">
    </div>
    <div class="form-group">
        <label for="email">Display Name:</label>
        <input value="<?php echo $permission->display_name;?>" name="display_name" type="text" class="form-control" id="display_name" required="">
    </div>
    <div class="form-group">
        <label for="email">Description:</label>
        <input value="<?php echo $permission->description;?>" name="description" type="text" class="form-control" id="description">
    </div>
    
    
    <div class="form-group">
        <label for="email">Status:</label>
        <select name="status" class="form-control">
            <option <?php if($permission->status ==0)echo"selected"; ?>  value="0">Disable</option>
            <option  <?php if($permission->status ==1)echo"selected"; ?> value="1">Active</option>
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