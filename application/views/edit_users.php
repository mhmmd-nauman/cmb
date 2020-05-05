<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <h2><?php echo $title; ?></h2>

<?php echo validation_errors(); ?>

<?php echo form_open('users/edit/'.$user->id); ?>
    <?php if(in_array('admin-admin', $this->auth->userPermissions())){?>
    <div class="form-group">
        <label for="email">Select Parent:</label>
        <select name="parent_id" class="form-control">
            <option value="0">Parent</option>
            <?php  foreach ($users as $user_p){ ?>
            <option <?php if($user_p->id == $user->parent_id){echo "selected";}?> value="<?php echo $user_p->id;?>"><?php echo $user_p->name;?></option>
            <?php } ?>
        </select>
    </div>
    <?php }else{?>
        <input name="parent_id" type="hidden" value="<?php echo $this->session->userdata['userID'];?>">
    <?php } ?>
    <div class="form-group">
        <label for="email">Name:</label>
        <input name="name" type="text" value="<?php echo $user->name;?>" required="" class="form-control" id="name">
    </div>
    <div class="form-group">
        <label for="email">Email:</label>
        <input name="email" type="text" value="<?php echo $user->email;?>"  class="form-control" id="email">
    </div>
    <div class="form-group">
        <label for="email">Login:</label>
        <input name="username" value="<?php echo $user->username;?>" required="" type="text" class="form-control" id="username">
    </div>
    <?php if(in_array('admin-admin', $this->auth->userPermissions())){?>
    <div class="form-group">
        <label for="email">Select Role:</label>
        <select name="role_id" class="form-control">
           
            <?php  foreach ($roles as $role){ ?>
            
            <option <?php if(in_array($role->id, $user_roles))echo"selected";?>  value="<?php echo $role->id;?>"><?php echo $role->display_name;?></option>
            <?php } ?>
        </select>
    </div>
    <?php }else if(in_array('assign_roles-users', $this->auth->userPermissions())){?>
        <div class="form-group">
        <label for="email">Select Role:</label>
        <select name="role_id" class="form-control">
           <option <?php if(in_array(5, $user_roles))echo"selected";?> value="5">Departmental Login</option>
           <option <?php if(in_array(4, $user_roles))echo"selected";?> value="4">Reviewer</option>
           
        </select>
    </div>
    <?php } else{?>
        <input name="role_id" type="hidden" value="5">
    <?php }?>
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