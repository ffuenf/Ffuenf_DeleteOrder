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
class Ffuenf_DeleteOrder_Helper_Core extends Mage_Core_Helper_Abstract
{
    /**
     * Get a store flag value and set to against the object.
     *
     * @param string $sStoreFlagPath
     * @param string $sStoreFlagAttribute
     *
     * @return bool
     */
    public function getStoreFlag($sStoreFlagPath, $sStoreFlagAttribute)
    {
        return (bool) $this->getStoreConfig($sStoreFlagPath, $sStoreFlagAttribute);
    }
    /**
     * Get a store config value and set against the object.
     *
     * @param string $sStoreConfigPath
     * @param string $sStoreConfigAttribute
     *
     * @return string
     */
    public function getStoreConfig($sStoreConfigPath, $sStoreConfigAttribute)
    {
        if ($this->$sStoreConfigAttribute === null) {
            $this->$sStoreConfigAttribute = Mage::getStoreConfig($sStoreConfigPath);
        }

        return $this->$sStoreConfigAttribute;
    }
}
