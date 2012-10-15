<?php

if(!defined('DS'))
	define('DS', DIRECTORY_SEPARATOR);
if(!defined('SITE_ROOT'))
	define('SITE_ROOT', '/home/codlexco/public_html/infinity-gag');
if(!defined('LIB_PATH'))
	define('LIB_PATH', SITE_ROOT . DS . 'includes');
if(!defined('TEMPLATE_DIR'))
	define('TEMPLATE_DIR', SITE_ROOT . DS . 'templates');



require_once(LIB_PATH.DS."config.php");
require_once(LIB_PATH.DS."session.php");

require_once(LIB_PATH.DS."database.php");
require_once(LIB_PATH.DS."database_object.php");
require_once(LIB_PATH.DS."user.php");
require_once(LIB_PATH.DS."image.php");
require_once(LIB_PATH.DS."comment.php");
require_once(LIB_PATH.DS."imagecomment.php");
require_once(LIB_PATH.DS."profilecomment.php");

require_once(LIB_PATH.DS."functions.php");

?>