<style>
    #login-box-body{
        border-radius:6px;
    }

    body.layout-boxed>.wrapper {
        background-color: transparent;
        box-shadow: none;
    }

    .login-box-body {
        box-shadow: 0 20px 32px rgba(0, 0, 0, 0.25);
    }

    #username, #password{
        border-radius:6px;
    }

    #rememberme-div{
        display:inline-block;
        float:left;
        padding-left:2%;
        font-size:13px;
    }

    #forgot-div{
        display:inline-block;
        float:right;
        padding-right:2.5%;
    }

    #forgot-password{
        font-style:italic;
        font-size:12px;
    }

    #submit-div{
        text-align:center;
    }

    #submit-button{
        width:98%;
        border-radius:6px;
    }

.below-login{
    text-align:center;
    margin: 10px auto;
}
</style>

<head>
<title>Login</title>
</head>

<div class="login-box">
    <div class="login-logo">
        <strong>
            <?php echo $secareatitleorlogo; ?>
        </strong>
    </div>

    <div class="login-box-body" id="login-box-body">
        <em>Please login to access our secure area.</em>
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
            <?php if (isset($settings['auth.allow_remember']) && $settings['auth.allow_remember'] == 1) { ?>
            <div class="form-group icheck" id="rememberme-div">
                <input type="checkbox" class="form-check-input" id="rememberme">
                <label class="form-check-label" for="rememberme">Remember me</label>
            </div>
            <?php } ?>
            <div class="form-group" id="forgot-div">
                <a href="/users/forgot" id="forgot-password">Forgot password?</a>
            </div>
            <div class="clear"></div>
            <div class="form-group" id="submit-div">
                <button type="submit" class="btn btn-primary" id="submit-button">Sign In</button>
            </div>
        </form>
    </div>
<div class="below-login">
<?php if (isset($settings['auth.allow_register']) && $settings['auth.allow_register'] == 1) { ?>
<a id="register_now" href="/users/register">Or Request An Account</a></div>
<?php } ?>
</div>