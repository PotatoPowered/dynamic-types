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
namespace DynamicTypes;

use Migrations\AbstractMigration;

/**
 * Class CreateDynamicTypes
 *
 * Injects the main table used for holding the DynamicTypes reference table.
 *
 * @package DynamicTypes
 */
class CreateDynamicTypes extends AbstractMigration
{
    /**
     * Create DynamicTypes
     *
     * @return void
     */
    public function change()
    {
        $table = $this->table('potato_powered_dynamic_types');
        $table
            ->addColumn('table_name', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('view_action', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true
            ])
            ->create();
    }
}
