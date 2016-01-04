<?php
if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );
/**
*
* @version $Id: ps_begateway.php 1.0 $
* @package VirtueMart
* @subpackage payment
* @copyright Copyright (C) 2015 eComCharge
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
* The ps_begateway class for transactions with beGateway payment software
 */
class ps_begateway {

    var $payment_code = "BGW";
    var $classname = "ps_begateway";

    /**
    * Show all configuration parameters for this payment method
    * @returns boolean False when the Payment method has no configration
    */
    function show_configuration() {

      global $VM_LANG;
      $database = new ps_DB();
      /** Read current Configuration ***/
      require_once(CLASSPATH ."payment/".$this->classname.".cfg.php");
      $VM_LANG->load('begateway');
    ?>
      <table class="adminform">
        <tr class="row0">
            <td><strong><?php echo $VM_LANG->_('PHPSHOP_ADMIN_CFG_BGW_GW_DOMAIN') ?></strong></td>
            <td>
                <input type="text" name="BGW_GW_DOMAIN" class="inputbox" value="<?php echo BGW_GW_DOMAIN ?>" />
            </td>
            <td><?php echo $VM_LANG->_('PHPSHOP_ADMIN_CFG_BGW_GW_DOMAIN_EXPLAIN') ?></td>
        </tr>
        <tr class="row1">
            <td><strong><?php echo $VM_LANG->_('PHPSHOP_ADMIN_CFG_BGW_PP_DOMAIN') ?></strong></td>
            <td>
                <input type="text" name="BGW_PP_DOMAIN" class="inputbox" value="<?php echo BGW_PP_DOMAIN ?>" />
            </td>
            <td><?php echo $VM_LANG->_('PHPSHOP_ADMIN_CFG_BGW_PP_DOMAIN_EXPLAIN') ?></td>
        </tr>
        <tr class="row0">
            <td><strong><?php echo $VM_LANG->_('PHPSHOP_ADMIN_CFG_BGW_SHOP_ID') ?></strong></td>
            <td>
                <input type="text" name="BGW_SHOP_ID" class="inputbox" value="<?php echo BGW_SHOP_ID ?>" />
            </td>
            <td><?php echo $VM_LANG->_('PHPSHOP_ADMIN_CFG_BGW_SHOP_ID_EXPLAIN') ?></td>
        </tr>
        <tr class="row1">
            <td><strong><?php echo $VM_LANG->_('PHPSHOP_ADMIN_CFG_BGW_SHOP_KEY') ?></strong></td>
            <td>
                <input type="text" name="BGW_SHOP_KEY" class="inputbox" value="<?php echo BGW_SHOP_KEY ?>" />
            </td>
            <td><?php echo $VM_LANG->_('PHPSHOP_ADMIN_CFG_BGW_SHOP_KEY_EXPLAIN') ?></td>
        </tr>
        <tr class="row0">
            <td><strong><?php echo $VM_LANG->_('PHPSHOP_ADMIN_CFG_PAYMENT_ORDERSTATUS_SUCC') ?></strong></td>
            <td>
                <select name="BGW_VERIFIED_STATUS" class="inputbox" >
                <?php
                    $q = "SELECT order_status_name,order_status_code FROM #__{vm}_order_status ORDER BY list_order";
                    $database->query($q);
                    $rows = $database->record;
                    $order_status_code = Array();
                    $order_status_name = Array();

                    foreach( $rows as $row ) {
                      $order_status_code[] = $row->order_status_code;
                      $order_status_name[] =  $row->order_status_name;
                    }
                    for ($i = 0; $i < sizeof($order_status_code); $i++) {
                      echo "<option value=\"" . $order_status_code[$i];
                      if (BGW_VERIFIED_STATUS == $order_status_code[$i])
                         echo "\" selected=\"selected\">";
                      else
                         echo "\">";
                      echo $order_status_name[$i] . "</option>\n";
                    }?>
                    </select>
            </td>
            <td><?php echo $VM_LANG->_('PHPSHOP_ADMIN_CFG_PAYMENT_ORDERSTATUS_SUCC_EXPLAIN') ?>
            </td>
        </tr>
        <tr class="row1">
            <td><strong><?php echo $VM_LANG->_('PHPSHOP_ADMIN_CFG_PAYMENT_ORDERSTATUS_FAIL') ?></strong></td>
            <td>
                <select name="BGW_INVALID_STATUS" class="inputbox" >
                <?php
                    for ($i = 0; $i < sizeof($order_status_code); $i++) {
                      echo "<option value=\"" . $order_status_code[$i];
                      if (BGW_INVALID_STATUS == $order_status_code[$i])
                         echo "\" selected=\"selected\">";
                      else
                         echo "\">";
                      echo $order_status_name[$i] . "</option>\n";
                    } ?>
                    </select>
            </td>
            <td><?php echo $VM_LANG->_('PHPSHOP_ADMIN_CFG_PAYMENT_ORDERSTATUS_FAIL_EXPLAIN') ?>
            </td>
        </tr>
        <tr class="row0">
            <td><strong><?php echo $VM_LANG->_('VM_ADMIN_CFG_PAYPAL_STATUS_PENDING') ?></strong></td>
            <td>
                <select name="BGW_PENDING_STATUS" class="inputbox" >
                <?php
                    for ($i = 0; $i < sizeof($order_status_code); $i++) {
                      echo "<option value=\"" . $order_status_code[$i];
                      if (BGW_PENDING_STATUS == $order_status_code[$i])
                         echo "\" selected=\"selected\">";
                      else
                         echo "\">";
                      echo $order_status_name[$i] . "</option>\n";
                    } ?>
                    </select>
            </td>
            <td><?php echo $VM_LANG->_('VM_ADMIN_CFG_PAYPAL_STATUS_PENDING_EXPLAIN') ?></td>
        </tr>
      </table>
   <?php
      // return false if there's no configuration
      return true;
   }

    function has_configuration() {
      // return false if there's no configuration
      return true;
   }

  /**
	* Returns the "is_writeable" status of the configuration file
	* @param void
	* @returns boolean True when the configuration file is writeable, false when not
	*/
   function configfile_writeable() {
      return is_writeable( CLASSPATH."payment/".$this->classname.".cfg.php" );
   }

  /**
	* Returns the "is_readable" status of the configuration file
	* @param void
	* @returns boolean True when the configuration file is writeable, false when not
	*/
   function configfile_readable() {
      return is_readable( CLASSPATH."payment/".$this->classname.".cfg.php" );
   }
  /**
	* Writes the configuration file for this payment method
	* @param array An array of objects
	* @returns boolean True when writing was successful
	*/
   function write_configuration( &$d ) {

      $my_config_array = array(
        "BGW_GW_DOMAIN" => $d['BGW_GW_DOMAIN'],
        "BGW_PP_DOMAIN" => $d['BGW_PP_DOMAIN'],
        "BGW_SHOP_ID" => $d['BGW_SHOP_ID'],
        "BGW_SHOP_KEY" => $d['BGW_SHOP_KEY'],
        "BGW_VERIFIED_STATUS" => $d['BGW_VERIFIED_STATUS'],
        "BGW_PENDING_STATUS" => $d['BGW_PENDING_STATUS'],
        "BGW_INVALID_STATUS" => $d['BGW_INVALID_STATUS']
                          );
      $config = "<?php\n";
      $config .= "if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' ); \n\n";
      foreach( $my_config_array as $key => $value ) {
        $config .= "define ('$key', '$value');\n";
      }

      $config .= "?>";

      if ($fp = fopen(CLASSPATH ."payment/".$this->classname.".cfg.php", "w")) {
          fputs($fp, $config, strlen($config));
          fclose ($fp);
          return true;
     }
     else
        return false;
   }

  /**************************************************************************
  ** name: process_payment()
  ** created by: soeren
  ** description:
  ** parameters: $order_number, the number of the order, we're processing here
  **            $order_total, the total $ of the order
  ** returns:
  ***************************************************************************/
   function process_payment($order_number, $order_total, &$d) {

      return true;

   }
}
