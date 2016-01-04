<?php
if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );
/**
* PayPal IPN Result Checker
*
* @version $Id: checkout.begateway_result.php $
* @package VirtueMart
* @subpackage html
* @copyright Copyright (C) 2004-2007 eComCharge
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See /administrator/components/com_virtuemart/COPYRIGHT.php for copyright notices and details.
*
* http://virtuemart.net
*/
mm_showMyFileName( __FILE__ );
require_once(CLASSPATH . "payment/ps_begateway.cfg.php");
require_once(CLASSPATH . "begateway/begateway-api-php/lib/beGateway.php");

global $VM_LANG;
$VM_LANG->load('begateway');

if( !isset( $_REQUEST["token"] ) || empty( $_REQUEST["token"]) ||
	  !isset( $_REQUEST["uid"] ) || empty( $_REQUEST["uid"] )
  ) {
	echo $VM_LANG->_('VM_CHECKOUT_ORDERIDNOTSET');
}
else {
  beGateway_Settings::$shopId = BGW_SHOP_ID;
  beGateway_Settings::$shopKey = BGW_SHOP_KEY;
  beGateway_Settings::$gatewayBase = "https://" . BGW_GW_DOMAIN;
  beGateway_Settings::$checkoutBase = "https://" . BGW_PP_DOMAIN;

	$query = new beGateway_QueryByUid;
  $query->setUid($_REQUEST["uid"]);

  $query_response = $query->submit();

  list($order_id, $order_number, $user_id, $user_info_id) =
	  explode('|', $query_response->getTrackingId());

	$q = "SELECT order_status FROM #__{vm}_orders WHERE ";
	$q .= "#__{vm}_orders.user_id= " . $auth["user_id"] . " ";
	$q .= "AND #__{vm}_orders.order_id= $order_id ";
	$db->query($q);
	if ($db->next_record()) {
		$order_status = $db->f("order_status");
		if ( $query_response->isSuccess() || $order_status == BGW_VERIFIED_STATUS ) {  ?>
      <img src="<?php echo VM_THEMEURL ?>images/button_ok.png" align="middle" alt="<?php echo $VM_LANG->_('VM_CHECKOUT_SUCCESS'); ?>" border="0" />
      <h2><?php echo $VM_LANG->_('PHPSHOP_BGW_THANKYOU'); ?></h2>
    <?php
	} else if ( $query_response->isFailed() || $order_status == BGW_INVALID_STATUS ) { ?>
      <img src="<?php echo VM_THEMEURL ?>images/button_cancel.png" align="middle" alt="<?php echo $VM_LANG->_('VM_CHECKOUT_FAILURE'); ?>" border="0" />
      <h2><?php echo $VM_LANG->_('PHPSHOP_BGW_ERROR') ?></h2>
		<?php
		}
    else { ?>
      <h2><?php echo $VM_LANG->_('PHPSHOP_BGW_PENDING'); ?></h2>
    <?php
    } ?>
    <br />
     <p><a href="index.php?option=com_virtuemart&page=account.order_details&order_id=<?php echo $order_id ?>">
     <?php echo $VM_LANG->_('PHPSHOP_ORDER_LINK') ?></a>
     </p>
    <?php
	}
	else {
		echo $VM_LANG->_('VM_CHECKOUT_ORDERNOTFOUND') . '!';
	}
}
?>
