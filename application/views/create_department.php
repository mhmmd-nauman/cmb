<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <h2><?php echo $title; ?></h2>

<?php echo validation_errors(); ?>

<?php echo form_open('department/create'); ?>

    
    <div class="form-group">
        <label for="email">Title:</label>
        <input name="course_title" type="text" class="form-control" id="course_title">
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