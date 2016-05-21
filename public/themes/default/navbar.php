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
                    <ul class="dropdown-menu" aria-labelledby="themes">
                        <li><a href="./default/">Default</a></li>
                        <li class="divider"></li>
                        <li><a href="./cerulean/">Cerulean</a></li>
                        <li><a href="./cosmo/">Cosmo</a></li>
                        <li><a href="./cyborg/">Cyborg</a></li>
                        <li><a href="./darkly/">Darkly</a></li>
                        <li><a href="./flatly/">Flatly</a></li>
                        <li><a href="./journal/">Journal</a></li>
                        <li><a href="./lumen/">Lumen</a></li>
                        <li><a href="./paper/">Paper</a></li>
                        <li><a href="./readable/">Readable</a></li>
                        <li><a href="./sandstone/">Sandstone</a></li>
                        <li><a href="./simplex/">Simplex</a></li>
                        <li><a href="./slate/">Slate</a></li>
                        <li><a href="./spacelab/">Spacelab</a></li>
                        <li><a href="./superhero/">Superhero</a></li>
                        <li><a href="./united/">United</a></li>
                        <li><a href="./yeti/">Yeti</a></li>
                    </ul>
                </li>
                <li>
                    <a href="./help/">Help</a>
                </li>
                <li>
                    <a href="http://news.bootswatch.com">Blog</a>
                </li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li><a href="http://builtwithbootstrap.com/" target="_blank">Built With Bootstrap</a></li>
         <?php if (empty($current_user)) : ?>
        <li><a href="<?php echo site_url(LOGIN_URL); ?>"><?php e(lang('us_action_login')); ?></a></li>
        <?php else : ?>
        <li <?php echo check_method('profile'); ?>><a href="<?php echo site_url('users/profile'); ?>"><?php e(lang('us_user_settings')); ?></a></li>
        <li><a href="<?php echo site_url('logout'); ?>"><?php e(lang('us_action_logout')); ?></a></li>
        <?php endif; ?>
            </ul>

        </div>
    </div>
</div>