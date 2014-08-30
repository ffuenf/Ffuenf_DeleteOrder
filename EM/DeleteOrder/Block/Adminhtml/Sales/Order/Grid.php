<?php
class EM_DeleteOrder_Block_Adminhtml_Sales_Order_Grid extends Mage_Adminhtml_Block_Sales_Order_Grid {
  /**
  * Adding Delete Order Mass Action
  */
  protected function _prepareMassaction() {
    $retValue = parent::_prepareMassaction();
    $this->getMassactionBlock()->addItem('delete_order', array(
      'label'=> Mage::helper('sales')->__('Delete order'),
      'url'  => $this->getUrl('*/sales_order/deleteorder'),
    ));
    return $retValue;
  }
}
