<?php
require_once(CLASSPATH . 'begateway/begateway.php');
require_once(CLASSPATH . 'ps_country.php');

global $VM_LANG;
$VM_LANG->load('begateway');

$db1 = new ps_DB();
$q = "SELECT country_2_code FROM #__vm_country WHERE country_3_code='".$user->country."' ORDER BY country_2_code ASC";
$db1->query($q);

$country = $db1->f('country_2_code');
$state = NULL;

if (in_array($country, array('US', 'CA'))) {
  $state = $user->state;
}

$email = NULL;

if (isset($user->email)) {
  $email = $user->email;
} else {
  $email = $user->user_email;
}

$params = array(
  // Customer Name and Billing Address
  'first_name' => $user->first_name,
  'last_name' => $user->last_name,
  'address' => $user->address_1,
  'city' => $user->city,
  'state' => $state,
  'zip' => $user->zip,
  'country' => $country,
  'phone' => $user->phone_1,
  'email' => $email,
  'description' => $VM_LANG->_('PHPSHOP_BGW_ORDER') . sprintf("%08d", $db->f("order_id")),
  'user_info_id' => $db->f("user_info_id"),
  'user_id' => $db->f("user_id"),
  'order_id' => $db->f("order_id"),
  'order_number' => $db->f("order_number"),
  'amount' => $db->f("order_total"),
  'currency' => $_SESSION['vendor_currency']
);

$bgw = new begateway();

$lang = !empty( $GLOBALS['mosConfig_lang'] ) ? $GLOBALS['mosConfig_lang'] : ext_Lang::detect_lang();
$params['language'] = $bgw->getLanguage($lang);

$token = $bgw->getToken($params);

if ($token != false) {
?>
<form id="begatewayForm" action="<?php echo beGateway_Settings::$checkoutBase; ?>/checkout" method="post">
  <input type='hidden' name='token' value='<?php echo $token; ?>'>
  <input type="submit" value="<?php echo $VM_LANG->_('PHPSHOP_BGW_PAYMENT_BUTTON'); ?>"/>
</form>
<script>
(function() {
	//var begatewayHandler = function() {document.getElementById("begatewayForm").submit();};
	//if (document.addEventListener) window.addEventListener("load", begatewayHandler, false);
	//else window.attachEvent("load", begatewayHandler);
})();
</script>
<?php
} else {
  echo '<div class="shop_error">' . $VM_LANG->_('PHPSHOP_BGW_TOKEN_ERROR') . '</div>';
}
?>
