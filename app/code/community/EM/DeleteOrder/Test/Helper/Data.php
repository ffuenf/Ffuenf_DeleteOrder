<?php

/**
* Test for class EM_DeleteOrder_Helper_Data
*
* @category    EM
* @package     EM_DeleteOrder
*/
class EM_DeleteOrder_Test_Helper_Data extends EcomDev_PHPUnit_Test_Case
{
  /**
  * Tests is extension active
  *
  * @test
  * @loadFixture
  */
  public function testIsExtensionActive()
  {
    $this->assertTrue(
      Mage::helper('em_deleteorder')->isExtensionActive(),
      'Extension is not active please check config'
    );
  }
}