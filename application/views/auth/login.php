<div class="row">
    <div class="col-md-6 col-md-offset-3">
<form class="form-signin" method="post" id="loginForm" action="<?= site_url('login') ?>">
    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
           value="<?= $this->security->get_csrf_hash(); ?>">
    <h1 class="h3 mb-3 font-weight-normal">Please Login</h1>
    <?= isset($failed) && !empty($failed) ? "<p class='err'>{$failed}</p>" : ""; ?>
    <?= $this->session->flashdata('success'); ?>

    <label for="username" class="sr-only">Email address</label>
    <?= form_error('username', '<div class="err">', '</div>'); ?>
    <input type="text" id="inputEmail" class="form-control" placeholder="Username" value="<?= set_value('username'); ?>"
           name="username" autofocus>

    <label for="password" class="sr-only">Password</label>
    <?= form_error('password', '<div class="err">', '</div>'); ?>
    <input type="password" id="inputPassword" class="form-control" placeholder="Password"
           value="<?= set_value('password'); ?>" name="password">

    <div class="checkbox mb-3">
        <label>
            <input type="checkbox" value="remember-me"> Remember me
        </label>
    </div>

    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button> 
</form>
</div>
</div>
</div>
</body>
</html>
