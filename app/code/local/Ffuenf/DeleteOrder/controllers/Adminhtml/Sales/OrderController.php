<?php
/**
 * Ffuenf_DeleteOrder extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category   Ffuenf
 * @package    Ffuenf_DeleteOrder
 * @author     Achim Rosenhagen <a.rosenhagen@ffuenf.de>
 * @copyright  Copyright (c) 2015 ffuenf (http://www.ffuenf.de)
 * @license    http://opensource.org/licenses/mit-license.php MIT License
*/

require_once 'Mage/Adminhtml/controllers/Sales/OrderController.php';

class Ffuenf_DeleteOrder_Adminhtml_Sales_OrderController extends Mage_Adminhtml_Sales_OrderController
{

    public function deleteorderAction()
    {
        $coreResource = Mage::getSingleton('core/resource');
        $coreWrite = $coreResource->getConnection('core_write');
        $orderIds = $this->getRequest()->getPost('order_ids');
        $rsc_tbl = $coreWrite->fetchCol('show tables');
        $quoteId = '';
        $tbl_sales_flat_order = $coreResource->getTableName('sales_flat_order');
        $tbl_sales_flat_creditmemo_comment = $coreResource->getTableName('sales_flat_creditmemo_comment');
        $tbl_sales_flat_creditmemo_item = $coreResource->getTableName('sales_flat_creditmemo_item');
        $tbl_sales_flat_creditmemo = $coreResource->getTableName('sales_flat_creditmemo');
        $tbl_sales_flat_creditmemo_grid = $coreResource->getTableName('sales_flat_creditmemo_grid');
        $tbl_sales_flat_invoice_comment = $coreResource->getTableName('sales_flat_invoice_comment');
        $tbl_sales_flat_invoice_item = $coreResource->getTableName('sales_flat_invoice_item');
        $tbl_sales_flat_invoice = $coreResource->getTableName('sales_flat_invoice');
        $tbl_sales_flat_invoice_grid = $coreResource->getTableName('sales_flat_invoice_grid');
        $tbl_sales_flat_quote_address_item = $coreResource->getTableName('sales_flat_quote_address_item');
        $tbl_sales_flat_quote_item_option = $coreResource->getTableName('sales_flat_quote_item_option');
        $tbl_sales_flat_quote = $coreResource->getTableName('sales_flat_quote');
        $tbl_sales_flat_quote_address = $coreResource->getTableName('sales_flat_quote_address');
        $tbl_sales_flat_quote_item = $coreResource->getTableName('sales_flat_quote_item');
        $tbl_sales_flat_quote_payment = $coreResource->getTableName('sales_flat_quote_payment');
        $tbl_sales_flat_quote_shipping_rate = $coreResource->getTableName('sales_flat_quote_shipping_rate');
        $tbl_sales_flat_shipment_comment = $coreResource->getTableName('sales_flat_shipment_comment');
        $tbl_sales_flat_shipment_item = $coreResource->getTableName('sales_flat_shipment_item');
        $tbl_sales_flat_shipment_track = $coreResource->getTableName('sales_flat_shipment_track');
        $tbl_sales_flat_shipment = $coreResource->getTableName('sales_flat_shipment');
        $tbl_sales_flat_shipment_grid = $coreResource->getTableName('sales_flat_shipment_grid');
        $tbl_sales_flat_order_address = $coreResource->getTableName('sales_flat_order_address');
        $tbl_sales_flat_order_item = $coreResource->getTableName('sales_flat_order_item');
        $tbl_sales_flat_order_payment = $coreResource->getTableName('sales_flat_order_payment');
        $tbl_sales_flat_order_status_history = $coreResource->getTableName('sales_flat_order_status_history');
        $tbl_sales_flat_order_grid = $coreResource->getTableName('sales_flat_order_grid');
        $tbl_log_quote = $coreResource->getTableName('log_quote');
        $rsc_tbl_l = $coreWrite->fetchCol('SHOW TABLES LIKE ?', '%'.$tbl_log_quote);
        $tbl_sales_order_tax = $coreResource->getTableName('sales_order_tax');

        if (!empty($orderIds)) {
            foreach ($orderIds as $orderId) {
                $orderId = (int)$orderId;
                $order = Mage::getModel('sales/order')->load($orderId);
                if($order->increment_id) {
                    $incId = (int)$order->increment_id;
                    if (in_array($tbl_sales_flat_order, $rsc_tbl)) {
                        $rs1 = $coreWrite->fetchAll('SELECT quote_id FROM `'.$tbl_sales_flat_order.'` WHERE entity_id='.$orderId);
                        $quoteId = (int)$rs1[0]['quote_id'];
                    }
                    $coreWrite->raw_query('SET FOREIGN_KEY_CHECKS=1');
                    if (in_array($tbl_sales_flat_creditmemo_comment, $rsc_tbl)) {
                        $coreWrite->raw_query('DELETE FROM `'.$tbl_sales_flat_creditmemo_comment.'` WHERE parent_id IN (SELECT entity_id FROM `'.$tbl_sales_flat_creditmemo.'` WHERE order_id='.$orderId.')');
                    }
                    if (in_array('sales_flat_creditmemo_item', $rsc_tbl)) {
                        $coreWrite->raw_query('DELETE FROM `'.$tbl_sales_flat_creditmemo_item.'` WHERE parent_id IN (SELECT entity_id FROM `'.$tbl_sales_flat_creditmemo.'` WHERE order_id='.$orderId.')');
                    }
                    if (in_array($tbl_sales_flat_creditmemo, $rsc_tbl)) {
                        $coreWrite->raw_query('DELETE FROM `'.$tbl_sales_flat_creditmemo.'` WHERE order_id='.$orderId);
                    }
                    if (in_array($tbl_sales_flat_creditmemo_grid, $rsc_tbl)) {
                        $coreWrite->raw_query('DELETE FROM `'.$tbl_sales_flat_creditmemo_grid.'` WHERE order_id='.$orderId);
                    }
                    if (in_array($tbl_sales_flat_invoice_comment, $rsc_tbl)) {
                        $coreWrite->raw_query('DELETE FROM `'.$tbl_sales_flat_invoice_comment.'` WHERE parent_id IN (SELECT entity_id FROM `'.$tbl_sales_flat_invoice.'` WHERE order_id='.$orderId.')');
                    }
                    if (in_array($tbl_sales_flat_invoice_item, $rsc_tbl)) {
                        $coreWrite->raw_query('DELETE FROM `'.$tbl_sales_flat_invoice_item.'` WHERE parent_id IN (SELECT entity_id FROM `'.$tbl_sales_flat_invoice.'` WHERE order_id='.$orderId.')');
                    }
                    if (in_array($tbl_sales_flat_invoice, $rsc_tbl)) {
                        $coreWrite->raw_query('DELETE FROM `'.$tbl_sales_flat_invoice.'` WHERE order_id='.$orderId);
                    }
                    if (in_array($tbl_sales_flat_invoice_grid, $rsc_tbl)) {
                        $coreWrite->raw_query('DELETE FROM `'.$tbl_sales_flat_invoice_grid.'` WHERE order_id='.$orderId);
                    }
                    if ($quoteId) {
                        if (in_array($tbl_sales_flat_quote_address_item, $rsc_tbl)) {
                            $coreWrite->raw_query('DELETE FROM `'.$tbl_sales_flat_quote_address_item.'` WHERE parent_item_id IN (SELECT address_id FROM `'.$tbl_sales_flat_quote_address.'` WHERE quote_id='.$quoteId.')');
                        }
                        if (in_array($tbl_sales_flat_quote_shipping_rate, $rsc_tbl)) {
                            $coreWrite->raw_query('DELETE FROM `'.$tbl_sales_flat_quote_shipping_rate.'` WHERE address_id IN (SELECT address_id FROM `'.$tbl_sales_flat_quote_address.'` WHERE quote_id='.$quoteId.')');
                        }
                        if (in_array($tbl_sales_flat_quote_item_option, $rsc_tbl)) {
                            $coreWrite->raw_query('DELETE FROM `'.$tbl_sales_flat_quote_item_option.'` WHERE item_id IN (SELECT item_id FROM `'.$tbl_sales_flat_quote_item.'` WHERE quote_id='.$quoteId.')');
                        }
                        if (in_array($tbl_sales_flat_quote, $rsc_tbl)) {
                            $coreWrite->raw_query('DELETE FROM `'.$tbl_sales_flat_quote.'` WHERE entity_id='.$quoteId);
                        }
                        if (in_array($tbl_sales_flat_quote_address, $rsc_tbl)) {
                            $coreWrite->raw_query('DELETE FROM `'.$tbl_sales_flat_quote_address.'` WHERE quote_id='.$quoteId);
                        }
                        if (in_array($tbl_sales_flat_quote_item, $rsc_tbl)) {
                            $coreWrite->raw_query('DELETE FROM `'.$tbl_sales_flat_quote_item.'` WHERE quote_id='.$quoteId);
                        }
                        if (in_array('sales_flat_quote_payment', $rsc_tbl)) {
                            $coreWrite->raw_query('DELETE FROM `'.$tbl_sales_flat_quote_payment.'` WHERE quote_id='.$quoteId);
                        }
                    }
                    if (in_array($tbl_sales_flat_shipment_comment, $rsc_tbl)) {
                        $coreWrite->raw_query('DELETE FROM `'.$tbl_sales_flat_shipment_comment.'` WHERE parent_id IN (SELECT entity_id FROM `'.$tbl_sales_flat_shipment.'` WHERE order_id='.$orderId.')');
                    }
                    if (in_array($tbl_sales_flat_shipment_item, $rsc_tbl)) {
                        $coreWrite->raw_query('DELETE FROM `'.$tbl_sales_flat_shipment_item.'` WHERE parent_id IN (SELECT entity_id FROM `'.$tbl_sales_flat_shipment.'` WHERE order_id='.$orderId.')');
                    }
                    if (in_array($tbl_sales_flat_shipment_track, $rsc_tbl)) {
                        $coreWrite->raw_query('DELETE FROM `'.$tbl_sales_flat_shipment_track.'` WHERE order_id IN (SELECT entity_id FROM `'.$tbl_sales_flat_shipment.'` WHERE parent_id='.$orderId.')');
                    }
                    if (in_array($tbl_sales_flat_shipment, $rsc_tbl)) {
                        $coreWrite->raw_query('DELETE FROM `'.$tbl_sales_flat_shipment.'` WHERE order_id='.$orderId);
                    }
                    if (in_array($tbl_sales_flat_shipment_grid, $rsc_tbl)) {
                        $coreWrite->raw_query('DELETE FROM `'.$tbl_sales_flat_shipment_grid.'` WHERE order_id='.$orderId);
                    }
                    if (in_array($tbl_sales_flat_order, $rsc_tbl)) {
                        $coreWrite->raw_query('DELETE FROM `'.$tbl_sales_flat_order.'` WHERE entity_id='.$orderId);
                    }
                    if (in_array($tbl_sales_flat_order_address, $rsc_tbl)) {
                        $coreWrite->raw_query('DELETE FROM `'.$tbl_sales_flat_order_address.'` WHERE parent_id='.$orderId);
                    }
                    if (in_array($tbl_sales_flat_order_item, $rsc_tbl)) {
                        $coreWrite->raw_query('DELETE FROM `'.$tbl_sales_flat_order_item.'` WHERE order_id='.$orderId);
                    }
                    if (in_array($tbl_sales_flat_order_payment, $rsc_tbl)) {
                        $coreWrite->raw_query('DELETE FROM `'.$tbl_sales_flat_order_payment.'` WHERE parent_id='.$orderId);
                    }
                    if (in_array($tbl_sales_flat_order_status_history, $rsc_tbl)) {
                        $coreWrite->raw_query('DELETE FROM `'.$tbl_sales_flat_order_status_history.'` WHERE parent_id='.$orderId);
                    }
                    if ($incId && in_array($tbl_sales_flat_order_grid, $rsc_tbl)) {
                        $coreWrite->raw_query('DELETE FROM `'.$tbl_sales_flat_order_grid.'` WHERE increment_id='.$incId);
                    }
                    if (in_array($tbl_sales_order_tax, $rsc_tbl)) {
                        $coreWrite->raw_query('DELETE FROM `'.$tbl_sales_order_tax.'` WHERE order_id='.$orderId);
                    }
                    if ($quoteId && $rsc_tbl_l) {
                        $coreWrite->raw_query('DELETE FROM `'.$tbl_log_quote.'` WHERE quote_id='.$quoteId);
                    }
                    $coreWrite->raw_query('SET FOREIGN_KEY_CHECKS=1');
                }
            }
            $this->_getSession()->addSuccess($this->__('Order(s) deleted.'));
        } else {
            $this->_getSession()->addError($this->__('Order(s) error.'));
        }
        $this->_redirect('*/*/');
    }
}
