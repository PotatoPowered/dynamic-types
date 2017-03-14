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
use DynamicTypes\Datasource\Exception\DynamicTypeNotFoundException;
use DynamicTypes\Model\Behavior\DynamicBehavior;
use DynamicTypes\Model\Table\DynamicTypesTable;
use DynamicTypes\Test\Fixture;
use InvalidArgumentException;

/**
 * DynamicTypes\Model\Behavior\DynamicBehavior Test Case
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

        $this->DynamicTypes = TableRegistry::get((new DynamicTypesTable())->table());
        $this->Potato = new DynamicBehavior(TableRegistry::get($this->DynamicTypes->table()));
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
        // assert errors
        $this->expectException(DynamicTypeNotFoundException::class);

        // setup
        $invalidId = 999;

        // manipulate
        $this->Potato->getTypeById($invalidId);
    }

    /**
     * Test beforeSave throws invalid error
     *
     * @return void
     */
    public function testBeforeSaveError()
    {
        // assert errors
        $this->expectException(InvalidArgumentException::class);

        // setup
        $this->DynamicTypes->addBehavior('DynamicTypes.Dynamic', ['view_action' => 'show']);
        $dynamicType = $this->DynamicTypes->newEntity();

        // assert
        $this->DynamicTypes->save($dynamicType);
    }

    /**
     * Test beforeSave success
     *
     * @return void
     */
    public function testBeforeSave()
    {
        // setup
        $data = [
            'table_name' => 'test_before_saved_table',
            'view_action' => 'view',
            'created' => '2017-01-01 12:13:14',
            'modified' => '2017-01-01 12:13:14'
        ];

        $this->DynamicTypes->addBehavior('DynamicTypes.Dynamic', ['view_action' => 'show']);
        $dynamicType = $this->DynamicTypes->newEntity();
        $this->DynamicTypes->patchEntity($dynamicType, $data);
        $dynamicType->set('dynamic_type', 'users');
        $this->DynamicTypes->save($dynamicType);
        $query = $this->DynamicTypes->find()->where(['table_name' => $data['table_name']]);

        // assert
        $this->assertEquals(1, $query->count());
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
    }
}
