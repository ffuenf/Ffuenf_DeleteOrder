<?php
class Em_DeleteOrder_Helper_Data extends Mage_Core_Helper_Abstract
{
  /**
  * Path for the config for extension active status
  */
  const CONFIG_EXTENSION_ACTIVE = 'system/em_deleteorder/enable';

  /**
  * Variable for if the extension is active
  *
  * @var bool
  */
  protected $bExtensionActive;

  /**
  * Check to see if the extension is active
  *
  * @return bool
  */
  public function isExtensionActive()
  {
    if ($this->bExtensionActive === null) {
      $this->bExtensionActive = Mage::getStoreConfigFlag(self::CONFIG_EXTENSION_ACTIVE);
    }
    return $this->bExtensionActive;
  }
}