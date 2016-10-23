<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
 
 <?php
if ( !isset($hide_search) || (!$hide_search) ) : ?>
      <!-- search form (Optional) -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
<?php endif; ?>
 <?php
 /* Can pass in menu_data and menu_header */
if ( isset($menu_data) && ($menu_data!=null) ) :
    $refs = array();
    $list = array();
    foreach ($menu_data as $mdata)
    {
        $thisref = &$refs[ $mdata['menu_item_id'] ];
        $thisref['menu_parent_id'] = $mdata['menu_parent_id'];
        $thisref['menu_item_name'] = $mdata['menu_item_name'];
        $thisref['url'] = $mdata['url'];
        $thisref['icon'] = $mdata['icon'];
        if ($mdata['menu_parent_id'] == 0)
        {
            $list[ $mdata['menu_item_id'] ] = &$thisref;
        }
        else
        {
            $refs[ $mdata['menu_parent_id'] ]['children'][ $mdata['menu_item_id'] ] = &$thisref;
        }
    }

    function create_list( $arr, $ord)
    {
        if($ord==0){
             $html = "\n<ul class='sidebar-menu'>\n";
        } else
        {
             $html = "\n<ul class='treeview-menu'>\n";
        }

        $html .= "<li class='header'>".(isset($menu_header)?$menu_header:"")."</li>\n";
        
        foreach ($arr as $key=>$v)
        {
            if (array_key_exists('children', $v))
            {
                $html .= "<li class='treeview'>\n";
                $html .= '<a href="#">
                                <i class="'.$v['icon'].'"></i>
                                <span>'.$v['menu_item_name'].'</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>';
 
                $html .= create_list($v['children'],1);
                $html .= "</li>\n";
            }
            else{
                    $html .= '<li><a href="'.$v['url'].'">';
                    if($ord==0)
                    {
                        $html .=    '<i class="'.$v['icon'].'"></i>';
                    }
                    if($ord==1)
                    {
                        $html .=    '<i class="fa fa-angle-double-right"></i>';
                    }
                    $html .= $v['menu_item_name']."</a></li>\n";}
        }
        $html .= "</ul>\n";
        return $html;
    }
    echo create_list( $list,0 );
endif;
?>
         </section>

    <!-- /.sidebar -->
  </aside>
