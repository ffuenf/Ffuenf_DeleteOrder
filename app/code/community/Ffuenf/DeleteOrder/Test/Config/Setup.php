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
 * @copyright  Copyright (c) 2016 ffuenf (http://www.ffuenf.de)
 * @license    http://opensource.org/licenses/mit-license.php MIT License
 */

class Ffuenf_DeleteOrder_Test_Config_Setup extends EcomDev_PHPUnit_Test_Case_Config
{
    /**
     * Check if setup resources are defined
     *
     * @test
     */
    public function testSetupDefined() {
        $this->assertSetupResourceDefined();
        $this->assertSchemeSetupExists();
    }

    /**
     * Check if update scripts exists for the correct module version
     *
     * @test
     */
    public function testSetupExists() {
        $this->assertSchemeSetupScriptVersions(
            '1.0.0', $this->expected('module')->getVersion(), null, 'ffuenf_deleteorder_setup'
        );
    }
}