<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <h2><?php echo $title; ?></h2>

<?php echo validation_errors(); ?>

<?php echo form_open('users/create'); ?>
    <?php if(in_array('admin-admin', $this->auth->userPermissions())){?>    
    <div class="form-group">
        <label for="email">Select Parent:</label>
        <select name="parent_id" class="form-control">
            <option value="0">Parent</option>
            <?php  foreach ($users as $user){ ?>
                <option  value="<?php echo $user->id;?>"><?php echo $user->name;?></option>
            <?php } ?>
        </select>
    </div>
    <?php }else{?>
        <input name="parent_id" type="hidden" value="<?php echo $this->session->userdata['userID'];?>">
    <?php } ?>
    <div class="form-group">
        <label for="email">Name:</label>
        <input name="name" type="text" class="form-control" id="name">
    </div>
    <div class="form-group">
        <label for="email">Email:</label>
        <input name="email" type="text" class="form-control" id="email">
    </div>
    <div class="form-group">
        <label for="email">Login:</label>
        <input name="username" type="text" class="form-control" id="username">
    </div>
    <div class="form-group">
        <label for="email">Password:</label>
        <input name="password" type="text" class="form-control" id="password">
    </div>
    <?php if(in_array('admin-admin', $this->auth->userPermissions())){?>
    <div class="form-group">
        <label for="email">Select Role:</label>
        <select name="role_id" class="form-control">
           
            <?php  foreach ($roles as $role){ ?>
                <option  value="<?php echo $role->id;?>"><?php echo $role->display_name;?></option>
            <?php } ?>
        </select>
    </div>
    <?php } else if(in_array('assign_roles-users', $this->auth->userPermissions())){?>
        <div class="form-group">
        <label for="email">Select Role:</label>
        <select name="role_id" class="form-control">
           <option  value="5">Departmental Login</option>
           <option  value="4">Reviewer</option>
           
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

