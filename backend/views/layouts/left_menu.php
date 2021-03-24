<?php

$session = Yii::$app->session;
$session['user_logintype'];	

 $menu_data_array = array();
 if($session['user_logintype']=='T1')
 {
$menu_data_array[0] = array('one', 'Dashboard', Yii::$app -> homeUrl, '<i class="fa fa-dashboard"></i>', 'index');
/*$menu_data_array[4] = array('one', 'Home Management', Yii::$app->homeUrl.'?r=home-management/index', '<i class="fa fa-fw fa-building"></i>', 'index');
*/$menu_data_array[5] = array('one', 'Category Management', Yii::$app->homeUrl.'?r=category-management/index', '<i class="fa fa-th-large"></i>', 'index');
$menu_data_array[6] = array('one', 'Videos Management', Yii::$app->homeUrl.'?r=video-management/index', '<i class="fa fa fa-youtube-play"></i>', 'index');
$menu_data_array[7] = array('one', 'App Management', Yii::$app->homeUrl.'?r=colorsystem/index', '<i class="fa fa fa-cog fa-spin"></i>', 'index');
$menu_data_array[8] = array('one', 'Splash Screen', Yii::$app->homeUrl.'?r=flash-screen/index', '<i class="fa fa fa-bolt"></i>', 'index');
/*$menu_data_array[9] = array('one', 'Fetch Data', Yii::$app->homeUrl.'?r=api-fetch-details/index', '<i class="fa fa-folder-o"></i>', 'index');*/
/*$menu_data_array[1]=array('more','Management','#','<i class="fa fa-fw fa-building"></i>','swim-service-centre');
$menu_data_array[1]['sub'][0]=array('Category Management',Yii::$app->homeUrl.'?r=category-management/index','<i class="fa fa-fw fa-plus"></i>','swim-service-centre','create');
$menu_data_array[1]['sub'][1]=array('Videos Management',Yii::$app->homeUrl.'?r=video-management/index','<i class="fa fa-fw fa-plus"></i>','swim-service-centre','swim-service-centre');*/
}
$html_menu_out = '';
$controler_url_id = Yii::$app ->controller->id;
$active_url_id = Yii::$app ->controller->action->id;
$html_menu_out_tmp = $controler_url_id . "/" . $active_url_id;
//$html_menu_out .= $html_menu_out_tmp;
foreach ($menu_data_array as $one_ig => $one_menus) {//echo "<pre>";print_r($one_menus);
	if (count($one_menus) > 0) {
		if ($one_menus[0] == 'more') {
			$isselct = '';
			if ($controler_url_id == $one_menus[4]) {$isselct = 'active';
			}//echo $isselct;
			$html_menu_out2 = '<ul class="treeview-menu">';
			foreach ($one_menus['sub'] as $one_submenus) {
				$isactive = '';
				if ($active_url_id == "index") {
					if ($active_url_id == $one_submenus[4] || $controler_url_id == $one_submenus[4]) {
						$isactive = 'class="active"';
						if ($isselct == '') {
							$isselct = 'active';
						}
					}
				} else {
					if ($active_url_id == $one_submenus[4]) {$isactive = 'class="active"';
					}
				}
				$html_menu_out2 .= '<li ' . $isactive . '><a href="' . $one_submenus[1] . '">' . $one_submenus[2] . '' . $one_submenus[0] . '</a></li>';
			}
			$html_menu_out1 = '<li class="treeview ' . $isselct . '"><a href="#">' . $one_menus[3] . ' <span>' . $one_menus[1] . '</span><i class="fa fa-angle-left pull-right"></i></a>';
			$html_menu_out2 .= '</ul></li>';
			$isselct = '';
			$html_menu_out .= $html_menu_out1 . $html_menu_out2;
		} elseif ($one_menus[0] == 'one') {
			$isselct = '';
			if ($active_url_id == "index") {
				if ($controler_url_id == $one_menus[4] || $active_url_id == $one_menus[4]) {$isselct = 'active';
				}
			} else {
				if ($html_menu_out_tmp == $one_menus[4]) {$isselct = 'active';
				}
				//if($controler_url_id==$one_menus[4]){$isselct='active';}
			}
			$html_menu_out .= '<li class="treeview ' . $isselct . '"> 
		              <a href="' . $one_menus[2] . '">' . $one_menus[3] . ' <span>' . $one_menus[1] . '</span></a></li>';
		}
	}
}
?>
<aside class="main-sidebar">
<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">
<!-- Sidebar user panel
<div class="user-panel">
<div class="pull-left image">
<img src="../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
</div>
<div class="pull-left info">
<p>Alexander Pierce</p>
<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
</div>
</div>-->
<!-- search form
<form action="#" method="get" class="sidebar-form">
<div class="input-group">
<input type="text" name="q" class="form-control" placeholder="Search...">
<span class="input-group-btn">
<button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
</span>
</div>
</form>
<!-- /.search form -->
<!-- sidebar menu: : style can be found in sidebar.less -->
<ul class="sidebar-menu">
<?php echo $html_menu_out; ?>

</ul>
</section>
<!-- /.sidebar -->
</aside>