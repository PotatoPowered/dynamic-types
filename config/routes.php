<?php
/**
 * plugin-template (https://github.com/PotatoPowered/plugin-template)
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
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

Router::plugin(
    'dynamic-types',
    ['path' => '/dynamic-types'],
    function (RouteBuilder $routes) {
        $routes->fallbacks('DashedRoute');
    }
);
