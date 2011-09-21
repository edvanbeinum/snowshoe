<?php
/**
 *
 * @author Ed van Beinum <e@edvanbeinum.com>
 * @version $Id$
 * @copyright Ibuildings 20/09/2011
 * @package AConfig
 */

namespace Husky\Config;
/**
 *
 * @package AConfig
 * @author Ed van Beinum <e@edvanbeinum.com>
 */
abstract class AConfig
{

    /**
     * Array of config values
     * To be overridden by the extending class
     *
     * @var array
     */
    protected $_config = array();

    /**
     * Magic method to handle getters for the $_config array
     *
     * It transforms a camelcase request into an underscored variable:
     * e.g getMultiWordVar() will return the value from te $_config array with the key 'multi_word_config'
     *
     * @param string $name
     * @param array $args
     * @return string|NULL
     */
    public function __call($name, $args = NULL)
    {
        $camelKey = ltrim($name, 'get');
        $underscoreKey = strtolower(preg_replace('/(.)([A-Z])/', "$1_$2", $camelKey));

        if (array_key_exists($underscoreKey, $this->_config)) {
            return $this->_config[$underscoreKey];
        }
        throw new \ErrorException('Config value for "' . $underscoreKey . '" not found in ' . get_class($this));

    }

    /**
     * Sets the config values
     * Used for unit testing
     *
     * @param array $config
     * @return void
     */
    public function setConfig(array $config)
    {
        $this->_config = $config;
    }

    /**
     * Gets the config values
     * Used for unit testing
     *
     * @return array
     */
    public function getConfig()
    {
        return $this->_config;
    }

}
