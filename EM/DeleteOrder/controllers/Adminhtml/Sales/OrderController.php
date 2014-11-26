<?php
require_once 'Mage/Adminhtml/controllers/Sales/OrderController.php';
class EM_DeleteOrder_Adminhtml_Sales_OrderController extends Mage_Adminhtml_Sales_OrderController {
  public function deleteorderAction() {

    $orderIds = $this->getRequest()->getPost('order_ids');
    $flag = false;
    $write = Mage::getSingleton('core/resource')->getConnection('core_write');
    $query="show tables";
    $rsc_table=$write->fetchCol($query);
    $table_sales_flat_order = Mage::getSingleton('core/resource')->getTableName('sales_flat_order');
    $table_sales_flat_creditmemo_comment= Mage::getSingleton('core/resource')->getTableName('sales_flat_creditmemo_comment');
    $table_sales_flat_creditmemo_item= Mage::getSingleton('core/resource')->getTableName('sales_flat_creditmemo_item');
    $table_sales_flat_creditmemo= Mage::getSingleton('core/resource')->getTableName('sales_flat_creditmemo');
    $table_sales_flat_creditmemo_grid= Mage::getSingleton('core/resource')->getTableName('sales_flat_creditmemo_grid');
    $table_sales_flat_invoice_comment= Mage::getSingleton('core/resource')->getTableName('sales_flat_invoice_comment');
    $table_sales_flat_invoice_item= Mage::getSingleton('core/resource')->getTableName('sales_flat_invoice_item');
    $table_sales_flat_invoice= Mage::getSingleton('core/resource')->getTableName('sales_flat_invoice');
    $table_sales_flat_invoice_grid= Mage::getSingleton('core/resource')->getTableName('sales_flat_invoice_grid');
    $table_sales_flat_quote_address_item= Mage::getSingleton('core/resource')->getTableName('sales_flat_quote_address_item');
    $table_sales_flat_quote_item_option= Mage::getSingleton('core/resource')->getTableName('sales_flat_quote_item_option');
    $table_sales_flat_quote= Mage::getSingleton('core/resource')->getTableName('sales_flat_quote');
    $table_sales_flat_quote_address= Mage::getSingleton('core/resource')->getTableName('sales_flat_quote_address');
    $table_sales_flat_quote_item= Mage::getSingleton('core/resource')->getTableName('sales_flat_quote_item');
    $table_sales_flat_quote_payment= Mage::getSingleton('core/resource')->getTableName('sales_flat_quote_payment');
    $table_sales_flat_shipment_comment= Mage::getSingleton('core/resource')->getTableName('sales_flat_shipment_comment');
    $table_sales_flat_shipment_item= Mage::getSingleton('core/resource')->getTableName('sales_flat_shipment_item');
    $table_sales_flat_shipment_track= Mage::getSingleton('core/resource')->getTableName('sales_flat_shipment_track');
    $table_sales_flat_shipment= Mage::getSingleton('core/resource')->getTableName('sales_flat_shipment');
    $table_sales_flat_shipment_grid= Mage::getSingleton('core/resource')->getTableName('sales_flat_shipment_grid');
    $table_sales_flat_order_address= Mage::getSingleton('core/resource')->getTableName('sales_flat_order_address');
    $table_sales_flat_order_item= Mage::getSingleton('core/resource')->getTableName('sales_flat_order_item');
    $table_sales_flat_order_payment= Mage::getSingleton('core/resource')->getTableName('sales_flat_order_payment');
    $table_sales_flat_order_status_history= Mage::getSingleton('core/resource')->getTableName('sales_flat_order_status_history');
    $table_sales_flat_order_grid= Mage::getSingleton('core/resource')->getTableName('sales_flat_order_grid');
    $table_log_quote= Mage::getSingleton('core/resource')->getTableName('log_quote');
    $table_sales_order_tax= Mage::getSingleton('core/resource')->getTableName('sales_order_tax');
    $sales_order_tax_item= Mage::getSingleton('core/resource')->getTableName('sales_order_tax_item');
    $quoteId='';
    if (!empty($orderIds)) {
      foreach ($orderIds as $orderId) {
        $query=null;
        $order = Mage::getModel('sales/order')->load($orderId);
        if($order->increment_id){
          /*$query="show tables like 'sales_flat_order'";
          $rs=$write->fetchAll($query);*/
          $incId=$order->increment_id;
          if(in_array($table_sales_flat_order,$rsc_table)){
            $query='SELECT entity_id   FROM  '.$table_sales_flat_order.' WHERE increment_id="'.mysql_real_escape_string($incId).'"';
            $rs=$write->fetchAll($query);
            $query='SELECT quote_id    FROM   '.$table_sales_flat_order.' WHERE entity_id="'.mysql_real_escape_string($orderId).'"';
            $rs1=$write->fetchAll($query);
            $quoteId=$rs1[0]['quote_id'];
          }
          $query='SET FOREIGN_KEY_CHECKS=1';
          $rs3=$write->query($query);
          if(in_array($table_sales_flat_creditmemo_comment,$rsc_table)){
            $write->query("DELETE FROM ".$table_sales_flat_creditmemo_comment." WHERE parent_id IN (SELECT entity_id FROM ".$table_sales_flat_creditmemo." WHERE order_id='".mysql_real_escape_string($orderId)."')");
          }
          if(in_array('sales_flat_creditmemo_item',$rsc_table)){
            $write->query("DELETE FROM ".$table_sales_flat_creditmemo_item." WHERE parent_id IN (SELECT entity_id FROM ".$table_sales_flat_creditmemo." WHERE order_id='".mysql_real_escape_string($orderId)."')");
          }
          if(in_array($table_sales_flat_creditmemo,$rsc_table)){
            $write->query("DELETE FROM ".$table_sales_flat_creditmemo." WHERE order_id='".mysql_real_escape_string($orderId)."'");
          }
          if(in_array($table_sales_flat_creditmemo_grid,$rsc_table)){
            $write->query("DELETE FROM ".$table_sales_flat_creditmemo_grid." WHERE order_id='".mysql_real_escape_string($orderId)."'");
          }
          if(in_array($table_sales_flat_invoice_comment,$rsc_table)){
            $write->query("DELETE FROM ".$table_sales_flat_invoice_comment." WHERE parent_id IN (SELECT entity_id FROM ".$table_sales_flat_invoice." WHERE order_id='".mysql_real_escape_string($orderId)."')");
          }
          if(in_array($table_sales_flat_invoice_item,$rsc_table)){
            $write->query("DELETE FROM ".$table_sales_flat_invoice_item." WHERE parent_id IN (SELECT entity_id FROM ".$table_sales_flat_invoice." WHERE order_id='".mysql_real_escape_string($orderId)."')");
          }
          if(in_array($table_sales_flat_invoice,$rsc_table)){
            $write->query("DELETE FROM ".$table_sales_flat_invoice." WHERE order_id='".mysql_real_escape_string($orderId)."'");
          }
          if(in_array($table_sales_flat_invoice_grid,$rsc_table)){
            $write->query("DELETE FROM ".$table_sales_flat_invoice_grid." WHERE order_id='".mysql_real_escape_string($orderId)."'");
          }
          if($quoteId){
            if(in_array($table_sales_flat_quote_address_item,$rsc_table)){
              $write->query("DELETE FROM ".$table_sales_flat_quote_address_item." WHERE parent_item_id  IN (SELECT address_id FROM ".$table_sales_flat_quote_address." WHERE quote_id=".$quoteId.")");
            }
            $table_sales_flat_quote_shipping_rate= Mage::getSingleton('core/resource')->getTableName('sales_flat_quote_shipping_rate');
            if(in_array($table_sales_flat_quote_shipping_rate,$rsc_table)){
              $write->query("DELETE FROM ".$table_sales_flat_quote_shipping_rate." WHERE address_id IN (SELECT address_id FROM ".$table_sales_flat_quote_address." WHERE quote_id=".$quoteId.")");
            }
            if(in_array($table_sales_flat_quote_item_option,$rsc_table)){
              $write->query("DELETE FROM ".$table_sales_flat_quote_item_option." WHERE item_id IN (SELECT item_id FROM ".$table_sales_flat_quote_item." WHERE quote_id=".$quoteId.")");
            }
            if(in_array($table_sales_flat_quote,$rsc_table)){
              $write->query("DELETE FROM ".$table_sales_flat_quote." WHERE entity_id=".$quoteId);
            }
            if(in_array($table_sales_flat_quote_address,$rsc_table)){
              $write->query("DELETE FROM ".$table_sales_flat_quote_address." WHERE quote_id=".$quoteId);
            }
            if(in_array($table_sales_flat_quote_item,$rsc_table)){
              $write->query("DELETE FROM ".$table_sales_flat_quote_item." WHERE quote_id=".$quoteId);
            }
            if(in_array('sales_flat_quote_payment',$rsc_table)){
              $write->query("DELETE FROM ".$table_sales_flat_quote_payment." WHERE quote_id=".$quoteId);
            }
          }
          if(in_array($table_sales_flat_shipment_comment,$rsc_table)){
            $write->query("DELETE FROM ".$table_sales_flat_shipment_comment." WHERE parent_id IN (SELECT entity_id FROM ".$table_sales_flat_shipment." WHERE order_id='".mysql_real_escape_string($orderId)."')");
          }
          if(in_array($table_sales_flat_shipment_item,$rsc_table)){
            $write->query("DELETE FROM ".$table_sales_flat_shipment_item." WHERE parent_id IN (SELECT entity_id FROM ".$table_sales_flat_shipment." WHERE order_id='".mysql_real_escape_string($orderId)."')");
          }
          if(in_array($table_sales_flat_shipment_track,$rsc_table)){
            $write->query("DELETE FROM ".$table_sales_flat_shipment_track." WHERE order_id IN (SELECT entity_id FROM ".$table_sales_flat_shipment." WHERE parent_id ='".mysql_real_escape_string($orderId)."')");
          }
          if(in_array($table_sales_flat_shipment,$rsc_table)){
            $write->query("DELETE FROM ".$table_sales_flat_shipment." WHERE order_id='".mysql_real_escape_string($orderId)."'");
          }
          if(in_array($table_sales_flat_shipment_grid,$rsc_table)){
            $write->query("DELETE FROM ".$table_sales_flat_shipment_grid." WHERE order_id='".mysql_real_escape_string($orderId)."'");
          }
          if(in_array($table_sales_flat_order,$rsc_table)){
            $write->query("DELETE FROM ".$table_sales_flat_order." WHERE entity_id='".mysql_real_escape_string($orderId)."'");
          }
          if(in_array($table_sales_flat_order_address,$rsc_table)){
            $write->query("DELETE FROM ".$table_sales_flat_order_address." WHERE parent_id='".mysql_real_escape_string($orderId)."'");
          }
          if(in_array($table_sales_flat_order_item,$rsc_table)){
            $write->query("DELETE FROM ".$table_sales_flat_order_item." WHERE order_id='".mysql_real_escape_string($orderId)."'");
          }
          if(in_array($table_sales_flat_order_payment,$rsc_table)){
            $write->query("DELETE FROM ".$table_sales_flat_order_payment." WHERE parent_id='".mysql_real_escape_string($orderId)."'");
          }
          if(in_array($table_sales_flat_order_status_history,$rsc_table)){
            $write->query("DELETE FROM ".$table_sales_flat_order_status_history." WHERE parent_id='".mysql_real_escape_string($orderId)."'");
          }
          if($incId&&in_array($table_sales_flat_order_grid,$rsc_table)){
            $write->query("DELETE FROM ".$table_sales_flat_order_grid." WHERE increment_id='".mysql_real_escape_string($incId)."'");
          }
          if(in_array($table_sales_order_tax,$rsc_table)) {
            $write->query("DELETE FROM ".$table_sales_order_tax." WHERE order_id='".mysql_real_escape_string($orderId)."'");
          }
          $query="show tables like '%".$table_log_quote."'";
          $rsc_table_l=$write->fetchCol($query);
          if($quoteId&&$rsc_table_l){
            $write->query("DELETE FROM ".$table_log_quote." WHERE quote_id=".$quoteId);
          }
          $write->query("SET FOREIGN_KEY_CHECKS=1");
        }
      }
      $this->_getSession()->addSuccess($this->__('Order(s) deleted.'));
    }else{
      $this->_getSession()->addError($this->__('Order(s) error.'));
    }
    $this->_redirect('*/*/');
  }
}
