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
class Ffuenf_DeleteOrder_Block_Adminhtml_Sales_Order_Grid extends Mage_Adminhtml_Block_Sales_Order_Grid
{
    /**
     * Adding Delete Order Mass Action.
     *
     * @return $this
     */
    protected function _prepareMassaction()
    {
        $retValue = parent::_prepareMassaction();
        if (Mage::helper('ffuenf_deleteorder')->isExtensionActive()) {
            $this->getMassactionBlock()->addItem('delete_order', array(
                'label' => Mage::helper('sales')->__('Delete order'),
                'url' => $this->getUrl('adminhtml/sales_order/deleteorder'),
                )
            );
        }

        return $retValue;
    }
}
