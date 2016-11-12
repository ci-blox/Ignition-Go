<div class="navbar navbar-inverse navbar-fixed-top navbar-transparent">
    <div class="container">
        <div class="navbar-header">
            <a href="./" class="navbar-brand"><img src="../../assets/img/logo-nav.png">Ignition Go</a>
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="navbar-collapse collapse" id="navbar-main">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes">Themes <span class="caret"></span></a>
                    <ul class="dropdown-menu themelist" aria-labelledby="themes">
                        <li><a data-theme="default" href="#">Default</a></li>
                        <li class="divider"></li>
                        <li><a data-theme="cerulean" href="#">Cerulean</a></li>
                        <li><a data-theme="cosmo" href="#">Cosmo</a></li>
                        <li><a data-theme="cyborg" href="#">Cyborg</a></li>
                        <li><a data-theme="darkly" href="#">Darkly</a></li>
                        <li><a data-theme="flatly" href="#">Flatly</a></li>
                        <li><a data-theme="journal" href="#">Journal</a></li>
                        <li><a data-theme="lumen" href="#">Lumen</a></li>
                        <li><a data-theme="paper" href="#">Paper</a></li>
                        <li><a data-theme="readable" href="#">Readable</a></li>
                        <li><a data-theme="sandstone" href="#">Sandstone</a></li>
                        <li><a data-theme="simplex" href="#">Simplex</a></li>
                        <li><a data-theme="slate" href="#">Slate</a></li>
                        <li><a data-theme="spacelab" href="#">Spacelab</a></li>
                        <li><a data-theme="superhero" href="#">Superhero</a></li>
                        <li><a data-theme="united" href="#">United</a></li>
                        <li><a data-theme="yeti" href="#">Yeti</a></li>
                    </ul>
                </li>
                <li>
                    <a href="/home/elements">Elements</a>
                </li>
                <li>
                    <a href="/home/help/">Help</a>
                </li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li><a href="http://builtwithbootstrap.com/" target="_blank">Built With Bootstrap</a></li>
                <?php if (empty($current_user)): ?>
                <li><a href="<?php echo site_url(LOGIN_URL); ?>"><?php e(lang('us_action_login')); ?></a></li>
                <?php else : ?>
                <li <?php echo check_method('profile'); ?>><a href="<?php echo site_url('users/profile'); ?>"><?php e(lang('us_user_settings')); ?></a></li>
                <li><a href="<?php echo site_url('logout'); ?>"><?php e(lang('us_action_logout')); ?></a></li>
                <?php endif; ?>
            </ul>

        </div>
    </div>
</div>