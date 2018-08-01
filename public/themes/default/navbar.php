<nav class="navbar navbar-expand-md bg-primary fixed-top navbar-dark">
  <div class="container">
    <a class="navbar-brand" href="./" title="Igmitipn Go home" id="Navbar index">
      <img src="../../assets/img/logo-nav.png"" class="d-inline-block" alt="I Go logo" style="padding-bottom: 5px;" width="24"><b> Ignition Go</b></a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbar2SupportedContent"
       aria-controls="navbar2SupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span> </button>
      <div class="collapse navbar-collapse text-center justify-content-end" id="navbar2SupportedContent">
        <ul class="navbar-nav bg-primary">
          <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
         aria-expanded="false" href="#">Themes</a>
        <div class="dropdown-menu themelist" aria-labelledby="navbarDropdownMenuLink">
      <a class="dropdown-item" data-theme="default" href="#">Default</a>
      <a class="dropdown-item" data-theme="flat" href="#">Flat</a>
          <a class="dropdown-item" data-theme="aquamarine" href="#">Aquamarine</a>
          <a class="dropdown-item" data-theme="elegant" href="#">Elegant</a>
          <a class="dropdown-item" data-theme="neon" href="#">Neon</a>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
       <li class="nav-item mx-1">
         <a class="nav-link" href="/home/elements">Elements</a>
          </li>
       <li class="nav-item mx-1">            
          <a class="nav-link" href="/home/help/">Help</a>
      </li>
<!-- li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes">Themes BS3</span></a>
                    <ul class="dropdown-menu themelist3" aria-labelledby="themes">
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
                </li -->
        </ul>
        <?php if (empty($current_user)): ?>
                <a class="btn btn-secondary mx-2" href="<?php echo site_url(LOGIN_URL); ?>">
      <?php e(lang('us_action_login')); ?>
    </a>
    <?php else : ?>
    <ul class="navbar-nav bg-primary">
          <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
              <span class="d-none d-sm-inline-block"> <i class="fa fa-user"></i> My Account</span>
            </a>
            <ul class="dropdown-menu scale-up" style="min-width:190px;">
              <!-- User image -->
              <li class="user-header" style="padding-left:10px;">
                <i class="fa fa-user fa-2x"></i>
                <p>
                  <?php echo $current_user->username; ?>
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">
              </li>
              <!-- Menu Footer-->
              <div class="user-footer" style="min-height: 40px;">
                <div class="pull-left">
                  <a <?php echo check_method( 'profile'); ?> class="btn btn-sm btn-primary" style="margin-left:10px;" 
                  href="<?php echo site_url('users/profile'); ?>">
                    <?php e(lang('us_user_settings')); ?>
                  </a>
                </div>
                <div class="pull-right">
                  <a class="btn btn-sm btn-default" href="<?php echo site_url('logout'); ?>">
                    <?php e(lang('us_action_logout')); ?>
                  </a>
                </div>
<?php if (!empty($current_user) && $current_user->role == 'admin') : ?>
                <div class="pull-left">
                  <a class="btn btn-sm btn-default" href="<?php echo site_url('admin/dashboard/index'); ?>">
                    <?php e(lang('us_admin_area')); ?>
                  </a>
                </div>
<?php endif; ?>
              </div>
            </ul>
          </li>
</ul>
    <?php endif; ?>
  </div>
  </div>
</nav>
<!-- end navbar -->