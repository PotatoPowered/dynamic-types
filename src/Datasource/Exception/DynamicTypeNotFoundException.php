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
namespace DynamicTypes\Datasource\Exception;

use RuntimeException;

/**
 * Exception raised when attempting to load a DynamicType that does not exist.
 */
class DynamicTypeNotFoundException extends RuntimeException
{

    /**
     * Constructor.
     *
     * @param string $message The error message
     * @param int $code The code of the error, is also the HTTP status code for the error.
     * @param \Exception|null $previous the previous exception.
     */
    public function __construct($message, $code = 404, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
