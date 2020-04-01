<div class="row">
    <div class="col-md-6 col-md-offset-3">
<form class="form-signin" method="post" id="loginForm" action="<?= site_url('login') ?>">
    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
           value="<?= $this->security->get_csrf_hash(); ?>">
    <h1 class="h3 mb-3 font-weight-normal">Please Login</h1>
    <?= isset($failed) && !empty($failed) ? "<p class='err'>{$failed}</p>" : ""; ?>
    <?= $this->session->flashdata('success'); ?>
    <div class="form-group">
        <label for="username">Username</label>
        <?= form_error('username', '<div class="err">', '</div>'); ?>
    <input type="text" id="inputEmail" class="form-control" placeholder="Username" value="<?= set_value('username'); ?>"
           name="username" autofocus>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <?= form_error('password', '<div class="err">', '</div>'); ?>
    <input type="password" id="inputPassword" class="form-control" placeholder="Password"
           value="<?= set_value('password'); ?>" name="password">
    </div>
    <div class="form-group">
        <?php
        
        echo $captcha_image;
        //echo '';
        ?>
    </div>
    <div class="form-group">
        <label for="password">Enter Captcha</label>
        <input class="form-control" type="text" name="captcha" value="" />
    </div>
    <div class="form-group">
    <div class="checkbox mb-3">
        <label>
            <input type="checkbox" value="remember-me"> Remember me
        </label>
    </div>
    </div>
    
    
    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button> 
</form>
</div>
</div>
</div>
</body>
</html>
