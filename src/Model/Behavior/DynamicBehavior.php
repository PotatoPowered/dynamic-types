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
namespace DynamicTypes\Model\Behavior;

use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\ORM\Behavior;
use Cake\ORM\TableRegistry;
use DynamicTypes\Datasource\Exception\DynamicTypeNotFoundException;

/**
 * Class DynamicBehavior
 *
 * The DynamicBehavior class aims to help access entities without knowing what table they are stored in. To make this
 * work we need to know what field of the entity to save off as a primary key.
 *
 * @package Model\Behavior
 */
class DynamicBehavior extends Behavior
{
    /**
     * @var array This array contains the default configuration for the Dynamic Behavior
     */
    protected $_defaultConfig = [
        'lookup_table' => 'potato_powered_dynamic_types',
        'primary_key' => 'id',
        'view_action' => 'view',
        'associations' => [],
    ];

    /**
     * Initialize the configuration
     *
     * @param array $config An array used to overwrite the default configuration listed above.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);
    }

    /**
     * Takes in the string representation of a table and return the key for it in the DynamicBehavior lookup table.
     *
     * If an entry for this object is not already in the lookup table a new entry will be made.
     *
     * @param string $type The tables alias from CakePHP
     * @return int The id of the type in the object_types table
     */
    public function getType($type)
    {
        $table = TableRegistry::get($type);
        $config = $this->config();
        $action = 'view';

        if ($table->hasBehavior('Activity')) {
            $action = $table->getView();
        }

        return $this->_getFromLookup(
            $config['lookup_table'],
            [
                'table_name' => $type,
                'view_action' => $action
            ]
        );
    }

    /**
     * Takes in the DynamicType id representation of a table and return the table name stored in the DynamicTypes
     * database.
     *
     * @param int $id The ID of the type in the types table
     * @return string The name of the table in the DynamicTypes table
     */
    public function getTypeById($id)
    {
        $config = $this->config();

        $table = TableRegistry::get($config['lookup_table']);

        try {
            return $table->get($id)->table_name;
        } catch (RecordNotFoundException $notFoundException) {
            throw new DynamicTypeNotFoundException(
                sprintf(
                    'The table could not be found for id %s',
                    $id
                )
            );
        }
    }

    /**
     * Returns the default view action of this entity type.
     *
     * This will usually return view but in some cases we will need to override this.
     *
     * @return string The default view action of this entity.
     */
    public function getView()
    {
        $config = $this->config();

        return $config['view_action'];
    }

    /**
     * Takes the alias of a table from CakePHP and a search conditions array
     * returns its index in the table specified. If it does not exist the entry
     * will be created and the new id returned.
     *
     * @param string $table The tables alias from CakePHP
     * @param array $search An array of search conditions ['name' => 'Users']
     * @return int The id of the type in the object_types table
     */
    private function _getFromLookup($table, $search)
    {
        $table = TableRegistry::get($table);
        $entity = $table->findOrCreate($search);

        return $entity->id;
    }
}
