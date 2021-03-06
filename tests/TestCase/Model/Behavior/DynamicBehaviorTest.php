<?php
/**
 * dynamic-types (https://github.com/PotatoPowered/dynamic-types)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @author      Blake Sutton <blake@potatopowered.net>
 * @copyright   Copyright (c) Potato Powered Software
 * @link        http://potatopowered.net
 * @license     http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace DynamicType\Test\TestCase\Model\Behavior;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use DynamicType\Model\Behavior\DynamicBehavior;
use DynamicType\Test\Fixture;

/**
 * App\Model\Behavior\PotatoBehavior Test Case
 */
class DynamicBehaviorTest extends TestCase
{

    public $fixtures = [
        'plugin.dynamic_type.potato_powered_dynamic_types'
    ];

    /**
     * Test subject
     *
     * @var \DynamicType\Model\Behavior\DynamicBehavior
     */
    public $Potato;

    /**
     * Test table
     *
     * @var \Cake\ORM\Table
     */
    public $Table;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->Table = TableRegistry::get('PotatoPoweredDynamicTypes');
        $this->Table->addBehavior('DynamicType.Dynamic', ['view_action' => 'show']);
        $this->Potato = new DynamicBehavior(TableRegistry::get('PotatoPoweredDynamicTypes'));
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Potato);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $tableLookupTest = $this->Potato->getType("test");
        $tableLookupTest2 = $this->Potato->getType("test2");
        $this->assertThat($tableLookupTest, $this->isType('int'));
        $this->assertThat($tableLookupTest2, $this->isType('int'));
        $this->assertThat($tableLookupTest < $tableLookupTest2, $this->isTrue());
    }

    /**
     * Test view lookup
     *
     * @return void
     */
    public function testViewLookup()
    {
        $this->assertThat($this->Potato->getView() === 'view', $this->isTrue());

        $this->assertThat($this->Table->getView() === 'show', $this->isTrue());
    }
}
