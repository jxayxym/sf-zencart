<?php
if(!defined('IS_ADMIN_FLAG')) {
	die('Illegal Access');
}

$autoLoadConfig[199][] = array(
	'autoType' => 'init_script',
	'loadFile' => 'init_seo_config.php'
);