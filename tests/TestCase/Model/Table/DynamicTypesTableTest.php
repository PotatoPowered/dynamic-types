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
namespace DynamicTypes\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use DynamicTypes\Model\Table\DynamicTypesTable;

class DynamicTypesTableTest extends TestCase
{

    /**
     * Fixtures used for testing
     *
     * @var array A list of the fixtures to be used
     */
    public $fixtures =
        [
            'plugin.dynamic_types.potato_powered_dynamic_types'
        ];

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
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DynamicTypes);

        parent::tearDown();
    }

    public function testFindByTableName()
    {
        // setup
        $expected = [
            [
                'id' => 1,
                'table_name' => 'users',
                'view_action' => 'view',
                'created' => new \Cake\I18n\Time('2016-01-01 12:13:14'),
                'modified' => new \Cake\I18n\Time('2016-01-01 12:13:14')
            ]
        ];

        // manipulate
        $query = $this->DynamicTypes->findByTableName('users');
        $result = $query->hydrate(false)->toArray();

        // assert
        $this->assertInstanceOf('Cake\ORM\Query', $query);
        $this->assertEquals($expected, $result);
    }
}
