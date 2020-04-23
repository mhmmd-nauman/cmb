<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <h2><?php echo $title; ?></h2>

<?php echo validation_errors(); ?>

<?php echo form_open('roles/allowed_permissions/'.$role->id); ?>

    
    <div class="form-group">
        <label for="email">Role Name:</label>
        <input readonly="" name="name" value="<?php echo $role->name;?>" type="text" class="form-control" id="name" required="">
    </div>
    <?php foreach($controller as $controller_name => $actions){?>    
    <div class="form-group">
        <label for="email"><?php echo $controller_name;?>: <?php foreach ($actions as $action=>$permission_id){?> <?php echo $action;?> <input name="actions[<?php echo $controller_name;?>][<?php echo $action;?>]" type="checkbox" value="<?php echo $permission_id;?>" <?php if(in_array($permission_id, $existing_permissions))echo"checked"?>> |<?php }?></label>
        
    </div>
    <?php }?>
    <input name="action" value="1" type="hidden">
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