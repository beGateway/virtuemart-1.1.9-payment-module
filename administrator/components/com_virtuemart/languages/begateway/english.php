<?php
if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );
/**
*
* @package VirtueMart
* @subpackage languages
* @copyright Copyright (C) 2004-2008 eComCharge
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See /administrator/components/com_virtuemart/COPYRIGHT.php for copyright notices and details.
*
* http://virtuemart.net
*/
global $VM_LANG;
$langvars = array (
	'CHARSET' => 'ISO-8859-1',
  'PHPSHOP_ADMIN_CFG_BGW_GW_DOMAIN' => 'Payment gateway domain',
  'PHPSHOP_ADMIN_CFG_BGW_GW_DOMAIN_EXPLAIN' => '',
  'PHPSHOP_ADMIN_CFG_BGW_PP_DOMAIN' => 'Payment page domain',
  'PHPSHOP_ADMIN_CFG_BGW_PP_DOMAIN_EXPLAIN' => '',
  'PHPSHOP_ADMIN_CFG_BGW_SHOP_ID' => 'Shop Id',
  'PHPSHOP_ADMIN_CFG_BGW_SHOP_ID_EXPLAIN' => '',
  'PHPSHOP_ADMIN_CFG_BGW_SHOP_KEY' => 'Shop key',
  'PHPSHOP_ADMIN_CFG_BGW_SHOP_KEY_EXPLAIN' => '',
	'PHPSHOP_BGW_ORDER' => 'Order # ',
	'PHPSHOP_BGW_PAYMENT_BUTTON' => 'PROCEED TO PAYMENT PAGE',
	'PHPSHOP_BGW_TOKEN_ERROR' => 'Error to create payment token. Contact shop administrator.',
	'PHPSHOP_BGW_THANKYOU' => 'Thanks for your payment.
				The transaction was successful.',
	'PHPSHOP_BGW_ERROR' => 'An error occured while processing your transaction.
	      The status of your order could not be updated.',
	'PHPSHOP_BGW_PENDING' => 'Thanks for your order.
	      We are awaiting your payment confirmation.',
	'PHPSHOP_THANKYOU_SUCCESS' => 'Your order has been successfully placed!',
); $VM_LANG->initModule( 'begateway', $langvars );
?>
