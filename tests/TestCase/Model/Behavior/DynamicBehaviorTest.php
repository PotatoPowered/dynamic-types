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
namespace DynamicTypes\Test\TestCase\Model\Behavior;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use DynamicTypes\Model\Behavior\DynamicBehavior;
use DynamicTypes\Test\Fixture;

/**
 * DynamicTypes\Model\Behavior\PotatoBehavior Test Case
 */
class DynamicBehaviorTest extends TestCase
{

    /**
     * Fixtures used for testing
     *
     * @var array A list of the fixtures to be used
     */
    public $fixtures = [
        'plugin.dynamic_types.potato_powered_dynamic_types'
    ];

    /**
     * Test subject
     *
     * @var \DynamicTypes\Model\Behavior\DynamicBehavior
     */
    public $Potato;

    /**
     * Test table
     *
     * @var \Cake\ORM\Table
     */
    public $DynamicTypes;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->DynamicTypes = TableRegistry::get('PotatoPoweredDynamicTypes');
        $this->DynamicTypes->addBehavior('DynamicTypes.Dynamic', ['view_action' => 'show']);
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
        // setup
        $tableLookupTest = null;
        $tableLookupTest2 = null;

        // manipulate
        $tableLookupTest = $this->Potato->getType("test");
        $tableLookupTest2 = $this->Potato->getType("test2");

        // assert
        $this->assertThat($tableLookupTest, $this->isType('int'));
        $this->assertThat($tableLookupTest2, $this->isType('int'));
        $this->assertThat($tableLookupTest < $tableLookupTest2, $this->isTrue());
    }

    /**
     * Test get type by id
     *
     * @return void
     */
    public function testGetTypeById()
    {
        // setup
        $validId = 1;
        $tableName = null;
        $expectedTableName = 'users';

        // manipulate
        $tableName = $this->Potato->getTypeById($validId);

        // assert
        $this->assertEquals($expectedTableName, $tableName);
    }

    /**
     * Test get type by id exception
     *
     * @return void
     */
    public function testGetTypeByIdException()
    {
        // setup
        $invalidId = 999;
        $this->expectException('\DynamicTypes\Datasource\Exception\DynamicTypeNotFoundException');

        // manipulate
        $this->Potato->getTypeById($invalidId);
    }


    /**
     * Test view lookup
     *
     * @return void
     */
    public function testViewLookup()
    {
        // assert
        $this->assertThat($this->Potato->getView() === 'view', $this->isTrue());
        $this->assertThat($this->DynamicTypes->getView() === 'show', $this->isTrue());
    }
}
