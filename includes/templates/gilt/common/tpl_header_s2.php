<?php
/**
 * Common Template - tpl_header.php
 *
 * this file can be copied to /templates/your_template_dir/pagename<br />
 * example: to override the privacy page<br />
 * make a directory /templates/my_template/privacy<br />
 * copy /templates/templates_defaults/common/tpl_footer.php to /templates/my_template/privacy/tpl_header.php<br />
 * to override the global settings and turn off the footer un-comment the following line:<br />
 * <br />
 * $flag_disable_header = true;<br />
 *
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_header.php 4813 2006-10-23 02:13:53Z drbyte $
 */
?>

<?php
  // Display all header alerts via messageStack:
  if ($messageStack->size('header') > 0) {
    echo $messageStack->output('header');
  }
  if (isset($_GET['error_message']) && zen_not_null($_GET['error_message'])) {
  echo htmlspecialchars(urldecode($_GET['error_message']));
  }
  if (isset($_GET['info_message']) && zen_not_null($_GET['info_message'])) {
   echo htmlspecialchars($_GET['info_message']);
} else {

}
?>


<!--bof-header logo and navigation display-->
<?php
if (!isset($flag_disable_header) || !$flag_disable_header) {
?>

<div id="headerWrapper">
<!--bof-navigation display-->
<div id="navMainWrapper">
<div id="navMain" class="centeredContent">
<?php require DIR_WS_MODULES.zen_get_module_directory('ezpages_bar_header.php');?>
<?php 
if (!empty($page_query_list_header)){
	echo '<ul>';
	foreach ($page_query_list_header as $etnry){
		echo '<li><a href="'.$etnry['link'].'">'.$etnry['name'].'</a></li>';
	}
	echo '</ul>';
}
?>
</div>
</div>
<!--eof-navigation display-->

<div class="navBg">
<div id="navCustomer" class="layout-center1000">
	<ul class="top-utilities">
<?php 
if ($_SESSION['customer_id']!=''){
?>
	<li id="nav_account" class="rightSeparator back">
            <a class="nav_account" href="javascript:;">Account</a>
            <div class="arrow-s"></div>
            <ul class="nav_account-list l-s_n">
                    <li><span id="nav_account-list-order"></span><a href="<?php echo zen_href_link(FILENAME_ACCOUNT_HISTORY)?>">Orders</a></li>
                    <li><span id="nav_account-list-address"></span><a href="<?php echo zen_href_link(FILENAME_ADDRESS_BOOK)?>">Address Book</a></li>
                    <li><span id="nav_account-list-setting"></span><a href="<?php echo zen_href_link(FILENAME_ACCOUNT_EDIT)?>">Account Setting</a></li>
                    <li><span id="nav_account-list-signout"></span><a href="<?php echo zen_href_link(FILENAME_LOGOFF)?>">Sign Out</a></li>
            </ul>
	</li>
<?php	
}else{
?>
	<li class="rightSeparator back"><a id="nav_create_account" href="<?php echo zen_href_link(FILENAME_CREATE_ACCOUNT)?>"><?php echo HEADER_TITLE_CREATE_ACCOUNT ?></a></li>
	<li class="rightSeparator back"><a id="nav_login" href="<?php echo zen_href_link(FILENAME_LOGIN)?>"><?php echo HEADER_TITLE_LOGIN ?></a></li>
<?php	
}
?>
	<li id="nav_currencies" class="back pr">
		<?php 
                $lng = new language;
                $language_list = '';
                  while (list($key, $value) = each($lng->catalog_languages)) {
                    if($value['id'] == $_SESSION['languages_id']) $current_language_image = zen_image(DIR_WS_LANGUAGES .  $value['directory'] . '/images/' . $value['image'], $value['name'],'',10);   
                    $language_list .= '<span>'.zen_image(DIR_WS_LANGUAGES .  $value['directory'] . '/images/' . $value['image'], $value['name']) . '</span>';
                  }
                echo '<span class="nav_currencies">'.$current_language_image.$_SESSION['currency'].'</span>'; 
                ?>
		<div class="arrow-s"></div>
		<div id="nav_currencies-wrapper" class="pa dn">
                    <div class="mb5">Language:</div>
                     <?php echo $language_list ?> 
                    <hr />
                    <div>Currency:</div>
		<?php 
		  reset($currencies->currencies);
		  ksort($currencies->currencies);
		  $parameters = zen_get_all_get_params(array('info', 'x', 'y'));
		  $i = 1;
	      while (list($key, $value) = each($currencies->currencies)) {
	        echo '<div class="back currencies_item">';
			if ($key==$_SESSION['currency'])
				echo '<span class="c-gold">'.$value['title'].'</span>';
			else
	        	echo'<a href="'.zen_href_link($_GET['main_page'],'currency='.$key.'&'.$parameters).'")'.'>'.$value['title'].'</a>';
	        echo '</div>';
	        if (($i++)%3==0) echo '<br class="clearBoth" />';
	      }
		?>
		</div>
	</li>
        <?php
        if($_SESSION['cart']->count_contents()>0||$_SESSION['customer_id']!=''){
        ?>
	<li id="cart-util" class="back">
            <div>
                <span>Cart</span>
                <span class="arrow-w"></span>
                <span class="cart-util-amount"><a href="<?php echo zen_href_link(FILENAME_SHOPPING_CART)?>"><?php echo $_SESSION['cart']->count_contents()?></a></span>
                <?php
                if($_SESSION['cart']->count_contents()>0){
                ?>
                <a href="<?php echo zen_href_link(FILENAME_CHECKOUT_SHIPPING)?>" class="cart-util-checkout">Checkout</a>
                <?php
                }
                ?>
            </div>
        </li>
        <?php
        }
        ?>
	</ul>
	<?php if (false && $_SESSION['customer_id']==''){?>
	<span class="socialAccountRow forward">
	<?php require DIR_WS_MODULES.'LoginWithSocialAccount/login_with.php';?>
	</span>
	<?php }?>	
</div>
<br class="clearBoth" />
<!--bof-branding display-->
<div id="logoWrapper" class="layout-center1000">
    <div id="logo" style="position:relative;width:200px;height:50px;"><?php echo '<a href="' . HTTP_SERVER . DIR_WS_CATALOG . '">' . zen_image($template->get_template_dir('logo.png', DIR_WS_TEMPLATE, $current_page_base,'images'). '/' . 'logo.png','','','','style="position:absolute;top:-45px;"') . '</a>'; ?></div>
	<ul class="tabs">
                <li class="tab back <?php if ($_GET['cPath']==FILENAME_PRODUCTS_NEW) echo 'current' ?>"><a href="<?php echo zen_href_link(FILENAME_PRODUCTS_NEW)?>"><?php echo HEADER_TITLE_PRODUCTS_NEWS ?></a></li>
                <li class="tab back <?php if ($_GET['cPath']==FILENAME_FEATURED_PRODUCTS) echo 'current' ?>"><a href="<?php echo zen_href_link(FILENAME_FEATURED_PRODUCTS)?>"><?php echo HEADER_TITLE_PRODUCTS_FEATUREDS ?></a></li>
<!--                <li class="tab back <?php if ($_GET['cPath']==FILENAME_SPECIALS) echo 'current' ?>"><a href="<?php echo zen_href_link(FILENAME_SPECIALS)?>"><?php echo HEADER_TITLE_PRODUCTS_SPECIALS ?></a></li>-->
                <?
                $top_categories = get_top_categories();
                if(false && !empty($top_categories)){
                    $c_array = explode('_', $_GET['cPath']);
                    foreach ($top_categories as $top_entry){
                ?>
                <li class="tab back <?php if ($_GET['main_page']==FILENAME_CATEGORIES_LIST) echo 'current' ?>""><a href="<?php echo zen_href_link(FILENAME_DEFAULT,'cPath='.$top_entry['categories_id'])?>"><?php echo $top_entry['categories_name']; ?></a>
                    <div id="tab<?php echo str_replace(' ', '', $top_entry['categories_name']) ?>" class="tab-menu">
                    <?php
                    $children_categories = get_children_categories($top_entry['categories_id']);
                    if(!empty($children_categories)){
                    ?>
                    <div id="tab<?php echo str_replace(' ', '', $top_entry['categories_name']) ?>-list" class="tab-menu-list back">    
                    <ul>
                        <?php
                        foreach ($children_categories as $children_entry){
                        ?>
                        <li class="back"><a href="<?php echo zen_href_link(FILENAME_DEFAULT,'cPath='.$children_entry['categories_id'])?>"><?php echo $children_entry['categories_name']?></a></li>
                        <?
                        }
                        ?>
                    </ul>    
                    </div>                            
                    <?    
                    }
                    ?>
                        <div class="forward"><?php echo zen_image(DIR_WS_IMAGES.$top_entry['categories_image'])?></div>
                    </div>
                </li>
                <?
                    }
                }
                ?>
		<li id="navCategoriesListTab" class="tab back <?php if ($_GET['main_page']==FILENAME_CATEGORIES_LIST) echo 'current' ?>"><a href="javascript:;<?php //echo zen_href_link(FILENAME_CATEGORIES_LIST)?>"><?php echo HEADER_TITLE_ALL_CATEGORIES;?></a>
			<div id="tab-allCategories" class="tab-menu">
			<?php 
                        if(false){
			require(DIR_WS_MODULES . zen_get_module_directory('category_list.php')); 
			while (!$leaf_categories->EOF){
			?>
			<div class="back navCategoriesItem ml5"><a href="<?php echo zen_href_link(FILENAME_DEFAULT,'cPath='.$leaf_categories->fields['categories_id']) ?>"><?php echo $leaf_categories->fields['categories_name']?></a></div>
			<?php
				$leaf_categories->MoveNext();
			}
                        }
                        require($template->get_template_dir('tpl_modules_categories_tabs.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_categories_tabs.php');
			?>
			</div>
		</li>
	</ul>
	<div id="navMainSearch"><?php require DIR_WS_MODULES.zen_get_module_directory('search_header.php'); ?></div>
	<br class="clearBoth" />
</div>
</div>
<!--eof-branding display-->

<!--eof-header logo and navigation display-->

<?php if (!in_array($_GET['main_page'], $main_page_left) && (HEADER_SALES_TEXT != '' || (SHOW_BANNERS_GROUP_SET2 != '' && $banner = zen_banner_exists('dynamic', SHOW_BANNERS_GROUP_SET2)))) { ?>
    <div id="taglineWrapper">
<?php
              if (HEADER_SALES_TEXT != '') {
?>
      <div id="tagline"><?php echo HEADER_SALES_TEXT;?></div>
<?php
              }
?>
<?php
              if (SHOW_BANNERS_GROUP_SET2 != '' && $banner = zen_banner_exists('dynamic', SHOW_BANNERS_GROUP_SET2)) {
                if ($banner->RecordCount() > 0) {
?>
      <div id="bannerTwo" class="banners"><?php echo zen_display_banner('static', $banner);?></div>
<?php
                }
              }
?>
    </div>
<?php } // no HEADER_SALES_TEXT or SHOW_BANNERS_GROUP_SET2 ?>

<!--bof-optional categories tabs navigation display-->
<?php //require($template->get_template_dir('tpl_modules_categories_tabs.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_categories_tabs.php'); ?>
<!--eof-optional categories tabs navigation display-->

<!--bof-header ezpage links-->
<?php //if (EZPAGES_STATUS_HEADER == '1' or (EZPAGES_STATUS_HEADER == '2' and (strstr(EXCLUDE_ADMIN_IP_FOR_MAINTENANCE, $_SERVER['REMOTE_ADDR'])))) { ?>
<?php //require($template->get_template_dir('tpl_ezpages_bar_header.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_ezpages_bar_header.php'); ?>
<?php //} ?>
<!--eof-header ezpage links-->
</div>
<?php } ?>