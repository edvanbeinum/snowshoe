<?php
/**
 *
 * @author Ed van Beinum <e@edvanbeinum.com>
 * @version $Id$
 * @package Snowshoe
 */

namespace Snowshoe\Config;
/**
 * Abstract class for creating Config classes
 *
 * @package Snowshoe
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
    protected static  $_config = array();

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

        if (array_key_exists($underscoreKey, static::$_config)) {
            return static::$_config[$underscoreKey];
        }
        throw new \ErrorException('Config value for "' . $underscoreKey . '" not found in ' . get_class($this));

    }

    /**
     * Sets the config values. This completely overwrites the _config array
     * Used for unit tests
     *
     * @param array $config
     * @return void
     */
    public function setConfig(array $config)
    {
        static::$_config =  $config;
    }

    /**
     * Adds or updates a value in the config array
     *
     * @param array $config
     * @return void
     */
    public function setConfigValue(array $config)
    {
         static::$_config = array_merge(static::$_config, $config);
    }

    /**
     * Gets the config values
     * Used for unit testing
     *
     * @return array
     */
    public function getConfig()
    {
        return static::$_config;
    }

}
