<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykTest\Spryk\Integration\Zed\Persistence;

use Codeception\Test\Unit;
use SprykTest\Module\ClassName;

/**
 * Auto-generated group annotations
 * @group SprykerTest
 * @group Spryk
 * @group Integration
 * @group Zed
 * @group Persistence
 * @group AddZedPersistenceEntityManagerMethodTest
 * Add your own group annotations below this line
 */
class AddZedPersistenceEntityManagerMethodTest extends Unit
{
    /**
     * @var \SprykTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsZedPersistenceRepositoryMethod(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--method' => 'doSomething',
            '--input' => 'string $fooBar',
            '--output' => 'array',
        ]);

        $this->tester->assertClassHasMethod(ClassName::ZED_ENTITY_MANAGER, 'doSomething');
    }

    /**
     * @return void
     */
    public function testAddsZedPersistenceRepositoryMethodOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--method' => 'doSomething',
            '--input' => 'string $fooBar',
            '--output' => 'array',
            '--mode' => 'project',
        ]);

        $this->tester->assertClassHasMethod(ClassName::PROJECT_ZED_ENTITY_MANAGER, 'doSomething');
    }
}