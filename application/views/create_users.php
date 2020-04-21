<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <h2><?php echo $title; ?></h2>

<?php echo validation_errors(); ?>

<?php echo form_open('users/create'); ?>

    
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
    
    <div class="form-group">
        <label for="email">Select Role:</label>
        <select name="role_id" class="form-control">
           
            <?php  foreach ($roles as $role){ ?>
                <option  value="<?php echo $role->id;?>"><?php echo $role->display_name;?></option>
            <?php } ?>
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