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
	'CHARSET' => 'utf-8',
  'PHPSHOP_ADMIN_CFG_BGW_GW_DOMAIN' => 'Домен платежного шлюза',
  'PHPSHOP_ADMIN_CFG_BGW_GW_DOMAIN_EXPLAIN' => '',
  'PHPSHOP_ADMIN_CFG_BGW_PP_DOMAIN' => 'Домен страницы оплаты',
  'PHPSHOP_ADMIN_CFG_BGW_PP_DOMAIN_EXPLAIN' => '',
  'PHPSHOP_ADMIN_CFG_BGW_SHOP_ID' => 'Id магазина',
  'PHPSHOP_ADMIN_CFG_BGW_SHOP_ID_EXPLAIN' => '',
  'PHPSHOP_ADMIN_CFG_BGW_SHOP_KEY' => 'Ключ магазина',
  'PHPSHOP_ADMIN_CFG_BGW_SHOP_KEY_EXPLAIN' => '',
	'PHPSHOP_BGW_ORDER' => 'Заказ # ',
	'PHPSHOP_BGW_PAYMENT_BUTTON' => 'ПЕРЕЙТИ К ОПЛАТЕ',
	'PHPSHOP_BGW_TOKEN_ERROR' => 'Ошибка создания ссылки на оплату. Обратитесь к администратору магазина.',
	'PHPSHOP_BGW_THANKYOU' => 'Спасибо за оплату.
				Ваш платеж был одобрен.',
	'PHPSHOP_BGW_ERROR' => 'Ошибка оплаты.
	      Статус Вашего заказа не изменен.',
	'PHPSHOP_BGW_PENDING' => 'Спасибо за Ваш заказ.
	      Мы ожидаем подтверждения Вашего платежа.',
	'PHPSHOP_THANKYOU_SUCCESS' => 'Ваш заказ был успешно получен!',
); $VM_LANG->initModule( 'begateway', $langvars );
?>
