<?php
if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );
/**
* beGateway payment class
*
* @version $Id: begateway.php eComCharge $
* @package VirtueMart
* @subpackage classes
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

/**
 * This class uses the currency rates provided by an XML file from the European Central Bank
 * Requires cURL or allow_url_fopen
 */

require_once(CLASSPATH . "payment/ps_begateway.cfg.php");
require_once(CLASSPATH . "begateway/begateway-api-php/lib/beGateway.php");

class begateway {
  static $languages =
    array(
      'english' => 'en',
      'russian' => 'ru'
    );

  function __construct() {
    beGateway_Settings::$shopId = BGW_SHOP_ID;
    beGateway_Settings::$shopKey = BGW_SHOP_KEY;
    beGateway_Settings::$gatewayBase = "https://" . BGW_GW_DOMAIN;
    beGateway_Settings::$checkoutBase = "https://" . BGW_PP_DOMAIN;
  }

  function getToken($order) {
    $track_data = implode('|',
      array(
        $order['order_id'], $order['order_number'],
        $order['user_id'], $order['user_info_id']
     ));
    $transaction = new beGateway_GetPaymentPageToken;
    $transaction->money->setCurrency($order['currency']);
    $transaction->money->setAmount($order['amount']);
    $transaction->setDescription($order['description']);
    $transaction->setTrackingId($track_data);
    $transaction->setLanguage($order['language']);
    $transaction->setSuccessUrl(SECUREURL . 'index.php?option=com_virtuemart&page=checkout.begateway_result&order_id='.$order['order_id']);
    $transaction->setDeclineUrl(SECUREURL . 'index.php?option=com_virtuemart&page=checkout.begateway_result&order_id='.$order['order_id']);
    $transaction->setFailUrl(SECUREURL . 'index.php?option=com_virtuemart&page=checkout.begateway_result&order_id='.$order['order_id']);
    $transaction->setCancelUrl(SECUREURL . 'index.php?option=com_virtuemart&page=checkout.begateway_result&order_id='.$order['order_id']);

    $notification_url = SECUREURL . 'administrator/components/com_virtuemart/begateway_notify.php';
    $notification_url = str_replace('carts.local', 'webhook.begateway.com:8443', $notification_url);

    $transaction->setNotificationUrl($notification_url);
    $transaction->customer->setFirstName($order['first_name']);
    $transaction->customer->setLastName($order['last_name']);
    $transaction->customer->setEmail($order['email']);
    $transaction->setAddressHidden();

    try {
      $response = $transaction->submit();
    } catch (Exception $e) {
      return false;
    }

    if ($response->isSuccess() ) {
      return $response->getToken();
    } else {
      return false;
    }
  }

  function getLanguage($lang) {
    if (isset(self::$languages[$lang])) {
      return self::$languages[$lang];
    } else {
      return 'en';
    }
  }
}
