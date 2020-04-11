<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <h2><?php echo $title; ?></h2>

<?php echo validation_errors(); ?>

<?php echo form_open('users/changepassword/'.$id); ?>

    
    <!--
    <div class="form-group">
        <label for="email">Email:</label>
        <input name="email" type="text" class="form-control" id="email">
    </div>
    
    <div class="form-group">
        <label for="email">Login:</label>
        <input readonly value="23" name="username" type="text" class="form-control" id="username">
    </div>
    
    <div class="form-group">
        <label for="email">Old Password:</label>
        <input name="oldpassword" type="password" class="form-control" id="oldpassword">
        <?php echo form_error('oldpass', '<div class="error">', '</div>')?>
    </div>
    -->
    <div class="form-group">
        <label for="email">New Password:</label>
        <input name="password" type="password" class="form-control" id="password">
        <?php echo form_error('password', '<div class="error">', '</div>')?>
    </div>
    <div class="form-group">
        <label for="email">Confirm Password:</label>
        <input name="confirmpassword" type="password" class="form-control" id="confirmpassword">
        <?php echo form_error('confirmpassword', '<div class="error">', '</div>')?>
    </div>

    <button type="submit" class="btn btn-primary">Change Password</button>

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