<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration;

use Codeception\Test\Unit;
use SprykerSdk\Spryk\Exception\SprykWrongDevelopmentLayerException;

/**
 * Auto-generated group annotations
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group AddModuleLicenseTest
 * Add your own group annotations below this line
 */
class AddModuleLicenseTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsLicenseFile(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--organization' => 'Spryker',
        ]);

        static::assertFileExists($this->tester->getModuleDirectory() . 'LICENSE');
    }

    /**
     * @return void
     */
    public function testAddsLicenseFileOnProjectLayer(): void
    {
        $this->expectException(SprykWrongDevelopmentLayerException::class);

        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--organization' => 'Spryker',
            '--mode' => 'project',
        ]);

        static::assertFileExists($this->tester->getProjectModuleDirectory() . 'LICENSE');
    }
}