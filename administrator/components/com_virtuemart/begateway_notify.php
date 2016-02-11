<?php
/*
* @version $Id: begateway_notify.php 617 eComCharge $
* @package VirtueMart
* @subpackage Payment
*
* @copyright (C) 2015 eComCharge
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* VirtueMart is Free Software.
* VirtueMart comes with absolute no warranty.
*
* www.virtuemart.net
*/

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {

	header("HTTP/1.0 200 OK");

  global $mosConfig_absolute_path, $mosConfig_live_site, $mosConfig_lang, $database,
  $mosConfig_mailfrom, $mosConfig_fromname;

  /*** access Joomla's configuration file ***/
  $my_path = dirname(__FILE__);

  if( file_exists($my_path."/../../../configuration.php")) {
      $absolute_path = dirname( $my_path."/../../../configuration.php" );
      require_once($my_path."/../../../configuration.php");
  }
  elseif( file_exists($my_path."/../../configuration.php")){
      $absolute_path = dirname( $my_path."/../../configuration.php" );
      require_once($my_path."/../../configuration.php");
  }
  elseif( file_exists($my_path."/configuration.php")){
      $absolute_path = dirname( $my_path."/configuration.php" );
      require_once( $my_path."/configuration.php" );
  }
  else {
      die( "Joomla Configuration File not found!" );
  }

  $absolute_path = realpath( $absolute_path );

  // Set up the appropriate CMS framework
  if( class_exists( 'jconfig' ) ) {
		define( '_JEXEC', 1 );
		define( 'JPATH_BASE', $absolute_path );
		define( 'DS', DIRECTORY_SEPARATOR );

		// Load the framework
		require_once ( JPATH_BASE . DS . 'includes' . DS . 'defines.php' );
		require_once ( JPATH_BASE . DS . 'includes' . DS . 'framework.php' );

		// create the mainframe object
		$mainframe = & JFactory::getApplication( 'site' );

		// Initialize the framework
		$mainframe->initialise();

		// load system plugin group
		JPluginHelper::importPlugin( 'system' );

		// trigger the onBeforeStart events
		$mainframe->triggerEvent( 'onBeforeStart' );
		$lang =& JFactory::getLanguage();
		$mosConfig_lang = $GLOBALS['mosConfig_lang']          = strtolower( $lang->getBackwardLang() );
		// Adjust the live site path
		$mosConfig_live_site = str_replace('/administrator/components/com_virtuemart', '', JURI::base());
		$mosConfig_absolute_path = JPATH_BASE;
  } else {
  	define('_VALID_MOS', '1');
  	require_once($mosConfig_absolute_path. '/includes/joomla.php');
  	require_once($mosConfig_absolute_path. '/includes/database.php');
  	$database = new database( $mosConfig_host, $mosConfig_user, $mosConfig_password, $mosConfig_db, $mosConfig_dbprefix );
  	$mainframe = new mosMainFrame($database, 'com_virtuemart', $mosConfig_absolute_path );
  }

  // load Joomla Language File
  if (file_exists( $mosConfig_absolute_path. '/language/'.$mosConfig_lang.'.php' )) {
      require_once( $mosConfig_absolute_path. '/language/'.$mosConfig_lang.'.php' );
  }
  elseif (file_exists( $mosConfig_absolute_path. '/language/english.php' )) {
      require_once( $mosConfig_absolute_path. '/language/english.php' );
  }
  /*** VirtueMart part ***/
  require_once($mosConfig_absolute_path.'/administrator/components/com_virtuemart/virtuemart.cfg.php');
  include_once( ADMINPATH.'/compat.joomla1.5.php' );
  require_once( ADMINPATH. 'global.php' );
  require_once( CLASSPATH. 'ps_main.php' );

	$sess = new ps_session();

  /* load the VirtueMart Language File */
  if (file_exists( ADMINPATH. 'languages/admin/'.$mosConfig_lang.'.php' ))
    require_once( ADMINPATH. 'languages/admin/'.$mosConfig_lang.'.php' );
  else
    require_once( ADMINPATH. 'languages/admin/english.php' );

  /* Load the VirtueMart database class */
  require_once( CLASSPATH. 'ps_database.php' );

  /*** END VirtueMart part ***/

  require_once(CLASSPATH . "/payment/ps_begateway.cfg.php");
  require_once(CLASSPATH . "/begateway/begateway-api-php/lib/beGateway.php");

  beGateway_Settings::$shopId = BGW_SHOP_ID;
  beGateway_Settings::$shopKey = BGW_SHOP_KEY;

  $webhook = new beGateway_Webhook();

  if ( $webhook->isAuthorized() ) {
    list($order_id, $order_number, $user_id, $user_info_id) =
		  explode('|', $webhook->getTrackingId());

    $d['order_id'] = (int) $order_id;    //this identifies the order record

    if ( $d['order_id'] > 0) {

      if( $webhook->isSuccess() ){
          $d['order_status'] = BGW_VERIFIED_STATUS;  //this is the new value for the database field I think X for cancelled, C for confirmed
          $d['order_comment'] = 'UID: ' . $webhook->getUid();
      }
      else if( $webhook->isFailed() ){
          $d['order_status'] = BGW_INVALID_STATUS;  //this is the new value for the database field I think X for cancelled, C for confirmed
          $d['order_comment'] = 'UID: ' . $webhook->getUid();
      }
      else if( $webhook->isIncomplete() ){
          $d['order_status'] = BGW_PENDING_STATUS;  //this is the new value for the database field I think X for cancelled, C for confirmed
      }

      require_once ( CLASSPATH . 'ps_order.php' );

      $ps_order= new ps_order;

      $ps_order->order_status_update($d);
      echo "OK";
    }
  } else {
    echo "ERROR";
  }
}
?>
