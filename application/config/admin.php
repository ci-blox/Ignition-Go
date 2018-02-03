<?php
defined('BASEPATH') OR exit('No direct script access allowed');

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | This logo is displayed at the upper left corner of your admin panel,
    | if no site title is set.
    | You can use basic HTML here if you want. The logo has also a mini
    | variant, used for the mini side bar. Make it 3 letters or so
    |
    */
    $config['adm_logo_use_site_title'] = true;
    $config['adm_logo'] = '';
    $config['adm_brandtext'] = '<strong>Ignition GO</strong>';
    $config['adm_logo_mini'] = '<strong>I</strong>GO';
    /*
    |--------------------------------------------------------------------------
    | Skin Color
    |--------------------------------------------------------------------------
    |
    | Choose a skin color for your admin panel. The available skin colors:
    | blue, black, purple, yellow, red, and green. Each skin also has a
    | light variant: blue-light, purple-light, purple-light, etc.
    |
    */
    $config['adm_skin'] = 'purple';
    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Choose a layout for your admin panel. The available layout options:
    | null, 'boxed', 'fixed', 'top-nav'. Boxed is the default, top-nav
    | removes the sidebar and places your menu in the top navbar
    |
    */
    $config['adm_layout'] = 'boxed';
    /*
    |--------------------------------------------------------------------------
    | Collapse Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we choose and option to be able to start with a collapsed side
    | bar. To adjust your sidebar layout simply set this  either true
    | this is compatible with layouts except top-nav layout option
    |
    */
    $config['adm_collapse_sidebar'] = false;
/*
    |--------------------------------------------------------------------------
    | Footer
    |--------------------------------------------------------------------------
    |
    | Set the right footer content
    |
    */
    $config['adm_footer_right'] = '<div class="text-muted">{memory_usage} Used</div>';

