<?php

/**
 * Ffuenf_DeleteOrder extension.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 *
 * @category   Ffuenf
 *
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
        $rscTbl = $coreWrite->fetchCol('show tables');
        $quoteId = '';
        $tblSalesFlatOrder = $coreResource->getTableName('sales_flat_order');
        $tblSalesFlatCreditmemoComment = $coreResource->getTableName('sales_flat_creditmemo_comment');
        $tblSalesFlatCreditmemoItem = $coreResource->getTableName('sales_flat_creditmemo_item');
        $tblSalesFlatCreditmemo = $coreResource->getTableName('sales_flat_creditmemo');
        $tblSalesFlatCreditmemoGrid = $coreResource->getTableName('sales_flat_creditmemo_grid');
        $tblSalesFlatInvoiceComment = $coreResource->getTableName('sales_flat_invoice_comment');
        $tblSalesFlatInvoiceItem = $coreResource->getTableName('sales_flat_invoice_item');
        $tblSalesFlatInvoice = $coreResource->getTableName('sales_flat_invoice');
        $tblSalesFlatInvoiceGrid = $coreResource->getTableName('sales_flat_invoice_grid');
        $tblSalesFlatQuoteAddressItem = $coreResource->getTableName('sales_flat_quote_address_item');
        $tblSalesFlatQuoteItemOption = $coreResource->getTableName('sales_flat_quote_item_option');
        $tblSalesFlatQuote = $coreResource->getTableName('sales_flat_quote');
        $tblSalesFlatQuoteAddress = $coreResource->getTableName('sales_flat_quote_address');
        $tblSalesFlatQuoteItem = $coreResource->getTableName('sales_flat_quote_item');
        $tblSalesFlatQuotePayment = $coreResource->getTableName('sales_flat_quotePayment');
        $tblSalesFlatQuoteShippingRate = $coreResource->getTableName('sales_flat_quote_shipping_rate');
        $tblSalesFlatShipmentComment = $coreResource->getTableName('sales_flat_shipment_comment');
        $tblSalesFlatShipmentItem = $coreResource->getTableName('sales_flat_shipment_item');
        $tblSalesFlatShipmentTrack = $coreResource->getTableName('sales_flat_shipment_track');
        $tblSalesFlatShipment = $coreResource->getTableName('sales_flat_shipment');
        $tblSalesFlatShipmentGrid = $coreResource->getTableName('sales_flat_shipment_grid');
        $tblSalesFlatOrderAddress = $coreResource->getTableName('sales_flat_order_address');
        $tblSalesFlatOrderItem = $coreResource->getTableName('sales_flat_order_item');
        $tblSalesFlatOrderPayment = $coreResource->getTableName('sales_flat_orderPayment');
        $tblSalesFlatOrderStatusHistory = $coreResource->getTableName('sales_flat_order_status_history');
        $tblSalesFlatOrderGrid = $coreResource->getTableName('sales_flat_order_grid');
        $tblLogQuote = $coreResource->getTableName('log_quote');
        $rscTblL = $coreWrite->fetchCol('SHOW TABLES LIKE ?', '%' . $tblLogQuote);
        $tblSalesOrderTax = $coreResource->getTableName('sales_order_tax');

        if (!empty($orderIds)) {
            foreach ($orderIds as $orderId) {
                $orderId = (int)$orderId;
                $order = Mage::getModel('sales/order')->load($orderId);
                if ($order->increment_id) {
                    $incId = (int)$order->increment_id;
                    if (in_array($tblSalesFlatOrder, $rscTbl)) {
                        $rs1 = $coreWrite->fetchAll('SELECT quote_id FROM `' . $tblSalesFlatOrder . '` WHERE entity_id=' . $orderId);
                        $quoteId = (int)$rs1[0]['quote_id'];
                    }
                    $coreWrite->raw_query('SET FOREIGN_KEY_CHECKS=1');
                    if (in_array($tblSalesFlatCreditmemoComment, $rscTbl)) {
                        $coreWrite->raw_query('DELETE FROM `' . $tblSalesFlatCreditmemoComment . '` WHERE parent_id IN (SELECT entity_id FROM `' . $tblSalesFlatCreditmemo . '` WHERE order_id=' . $orderId . ')');
                    }
                    if (in_array('sales_flat_creditmemo_item', $rscTbl)) {
                        $coreWrite->raw_query('DELETE FROM `' . $tblSalesFlatCreditmemoItem . '` WHERE parent_id IN (SELECT entity_id FROM `' . $tblSalesFlatCreditmemo . '` WHERE order_id=' . $orderId . ')');
                    }
                    if (in_array($tblSalesFlatCreditmemo, $rscTbl)) {
                        $coreWrite->raw_query('DELETE FROM `' . $tblSalesFlatCreditmemo . '` WHERE order_id=' . $orderId);
                    }
                    if (in_array($tblSalesFlatCreditmemoGrid, $rscTbl)) {
                        $coreWrite->raw_query('DELETE FROM `' . $tblSalesFlatCreditmemoGrid . '` WHERE order_id=' . $orderId);
                    }
                    if (in_array($tblSalesFlatInvoiceComment, $rscTbl)) {
                        $coreWrite->raw_query('DELETE FROM `' . $tblSalesFlatInvoiceComment . '` WHERE parent_id IN (SELECT entity_id FROM `' . $tblSalesFlatInvoice . '` WHERE order_id=' . $orderId . ')');
                    }
                    if (in_array($tblSalesFlatInvoiceItem, $rscTbl)) {
                        $coreWrite->raw_query('DELETE FROM `' . $tblSalesFlatInvoiceItem . '` WHERE parent_id IN (SELECT entity_id FROM `' . $tblSalesFlatInvoice . '` WHERE order_id=' . $orderId . ')');
                    }
                    if (in_array($tblSalesFlatInvoice, $rscTbl)) {
                        $coreWrite->raw_query('DELETE FROM `' . $tblSalesFlatInvoice . '` WHERE order_id=' . $orderId);
                    }
                    if (in_array($tblSalesFlatInvoiceGrid, $rscTbl)) {
                        $coreWrite->raw_query('DELETE FROM `' . $tblSalesFlatInvoiceGrid . '` WHERE order_id=' . $orderId);
                    }
                    if ($quoteId) {
                        if (in_array($tblSalesFlatQuoteAddressItem, $rscTbl)) {
                            $coreWrite->raw_query('DELETE FROM `' . $tblSalesFlatQuoteAddressItem . '` WHERE parent_item_id IN (SELECT address_id FROM `' . $tblSalesFlatQuoteAddress . '` WHERE quote_id=' . $quoteId . ')');
                        }
                        if (in_array($tblSalesFlatQuoteShippingRate, $rscTbl)) {
                            $coreWrite->raw_query('DELETE FROM `' . $tblSalesFlatQuoteShippingRate . '` WHERE address_id IN (SELECT address_id FROM `' . $tblSalesFlatQuoteAddress . '` WHERE quote_id=' . $quoteId . ')');
                        }
                        if (in_array($tblSalesFlatQuoteItemOption, $rscTbl)) {
                            $coreWrite->raw_query('DELETE FROM `' . $tblSalesFlatQuoteItemOption . '` WHERE item_id IN (SELECT item_id FROM `' . $tblSalesFlatQuoteItem . '` WHERE quote_id=' . $quoteId . ')');
                        }
                        if (in_array($tblSalesFlatQuote, $rscTbl)) {
                            $coreWrite->raw_query('DELETE FROM `' . $tblSalesFlatQuote . '` WHERE entity_id=' . $quoteId);
                        }
                        if (in_array($tblSalesFlatQuoteAddress, $rscTbl)) {
                            $coreWrite->raw_query('DELETE FROM `' . $tblSalesFlatQuoteAddress . '` WHERE quote_id=' . $quoteId);
                        }
                        if (in_array($tblSalesFlatQuoteItem, $rscTbl)) {
                            $coreWrite->raw_query('DELETE FROM `' . $tblSalesFlatQuoteItem . '` WHERE quote_id=' . $quoteId);
                        }
                        if (in_array('sales_flat_quotePayment', $rscTbl)) {
                            $coreWrite->raw_query('DELETE FROM `' . $tblSalesFlatQuotePayment . '` WHERE quote_id=' . $quoteId);
                        }
                    }
                    if (in_array($tblSalesFlatShipmentComment, $rscTbl)) {
                        $coreWrite->raw_query('DELETE FROM `' . $tblSalesFlatShipmentComment . '` WHERE parent_id IN (SELECT entity_id FROM `' . $tblSalesFlatShipment . '` WHERE order_id=' . $orderId . ')');
                    }
                    if (in_array($tblSalesFlatShipmentItem, $rscTbl)) {
                        $coreWrite->raw_query('DELETE FROM `' . $tblSalesFlatShipmentItem . '` WHERE parent_id IN (SELECT entity_id FROM `' . $tblSalesFlatShipment . '` WHERE order_id=' . $orderId . ')');
                    }
                    if (in_array($tblSalesFlatShipmentTrack, $rscTbl)) {
                        $coreWrite->raw_query('DELETE FROM `' . $tblSalesFlatShipmentTrack . '` WHERE order_id IN (SELECT entity_id FROM `' . $tblSalesFlatShipment . '` WHERE parent_id=' . $orderId . ')');
                    }
                    if (in_array($tblSalesFlatShipment, $rscTbl)) {
                        $coreWrite->raw_query('DELETE FROM `' . $tblSalesFlatShipment . '` WHERE order_id=' . $orderId);
                    }
                    if (in_array($tblSalesFlatShipmentGrid, $rscTbl)) {
                        $coreWrite->raw_query('DELETE FROM `' . $tblSalesFlatShipmentGrid . '` WHERE order_id=' . $orderId);
                    }
                    if (in_array($tblSalesFlatOrder, $rscTbl)) {
                        $coreWrite->raw_query('DELETE FROM `' . $tblSalesFlatOrder . '` WHERE entity_id=' . $orderId);
                    }
                    if (in_array($tblSalesFlatOrderAddress, $rscTbl)) {
                        $coreWrite->raw_query('DELETE FROM `' . $tblSalesFlatOrderAddress . '` WHERE parent_id=' . $orderId);
                    }
                    if (in_array($tblSalesFlatOrderItem, $rscTbl)) {
                        $coreWrite->raw_query('DELETE FROM `' . $tblSalesFlatOrderItem . '` WHERE order_id=' . $orderId);
                    }
                    if (in_array($tblSalesFlatOrderPayment, $rscTbl)) {
                        $coreWrite->raw_query('DELETE FROM `' . $tblSalesFlatOrderPayment . '` WHERE parent_id=' . $orderId);
                    }
                    if (in_array($tblSalesFlatOrderStatusHistory, $rscTbl)) {
                        $coreWrite->raw_query('DELETE FROM `' . $tblSalesFlatOrderStatusHistory . '` WHERE parent_id=' . $orderId);
                    }
                    if ($incId && in_array($tblSalesFlatOrderGrid, $rscTbl)) {
                        $coreWrite->raw_query('DELETE FROM `' . $tblSalesFlatOrderGrid . '` WHERE increment_id=' . $incId);
                    }
                    if (in_array($tblSalesOrderTax, $rscTbl)) {
                        $coreWrite->raw_query('DELETE FROM `' . $tblSalesOrderTax . '` WHERE order_id=' . $orderId);
                    }
                    if ($quoteId && $rscTblL) {
                        $coreWrite->raw_query('DELETE FROM `' . $tblLogQuote . '` WHERE quote_id=' . $quoteId);
                    }
                    $coreWrite->raw_query('SET FOREIGN_KEY_CHECKS=1');
                }
            }
            $this->_getSession()->addSuccess($this->__('Order(s) deleted.'));
        } else {
            $this->_getSession()->addError($this->__('Order(s) error.'));
        }
        $this->_redirect('adminhtml/sales_order/index');
    }
}
