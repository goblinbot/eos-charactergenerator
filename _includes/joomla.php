<?php

// Get Joomla session
define( '_JEXEC', 1 );
define( 'DS', '/' );
// IMPORTANT: adjust path based on folder or define it manually as string
// "myjoomlaroot" is name of your Joomla root folder
define( 'JPATH_BASE', '/opt/bitnami/apache2/htdocs/');
require_once ( JPATH_BASE .DS. 'includes' .DS. 'defines.php' );
require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );
$mainframe = JFactory::getApplication('site');
$mainframe->initialise();
jimport( 'joomla.user.user');
jimport( 'joomla.session.session');
jimport( 'joomla.user.authentication');
// now get user object and 3 example user variables
$user = JFactory::getUser();
$jid = $user->id;
$jname = $user->name;
$jguest = $user->guest;
//$TIJDELIJKID = $user->id;
?>
