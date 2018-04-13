<style>
    body.layout-boxed>.wrapper {
        background-color: transparent;
        box-shadow: none;
    }

    .login-box-body {
        box-shadow: 0 20px 32px rgba(0, 0, 0, 0.25);
    }
</style>
<div class="login-box">
    <div class="login-logo">
        <strong>
            <?php echo $secareatitleorlogo; ?>
        </strong>
    </div>

    <div class="login-box-body">
        <p class="login-box-msg">Please Sign In</p>
        <form action="<?php echo base_url($secarea); ?>/check/login" method="post" accept-charset="utf-8">
            <div class="form-group">
                <label for="username">Username</label>
                <span class="fa fa-user form-control-feedback" style="position: relative; left: 220px; top: 40px;"></span>
                <input type="text" name="username" value="" id="username" class="form-control" />
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <span class="fa fa-lock form-control-feedback" style="position: relative; left: 220px; top: 40px;"></span>
                <input type="password" name="password" value="" id="password" class="form-control" />
            </div>
            <div class="form-group icheck">
                <input type="checkbox" class="form-check-input" id="rememberme">
                <label class="form-check-label" for="rememberme">Remember me</label>
            </div>
            <div class="clear"></div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Sign In</button>
            </div>
        </form>
    </div>
</div>