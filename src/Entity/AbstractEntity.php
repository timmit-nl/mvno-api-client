<?php

namespace Etki\MvnoApiClient\Entity;

use RuntimeException;
use BadMethodCallException;

/**
 * Base entity class.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\MvnoApiClient
 * @author  Etki <etki@etki.name>
 */
class AbstractEntity
{
    /**
     * Asserts that provided property has been set.
     *
     * @param string $propertyName Name of the property to be checked.
     *
     * @throws BadMethodCallException Thrown in case name of property not
     *                                declared in current class was requested.
     * @throws RuntimeException       Thrown in case provided property hasn't
     *                                been set.
     *
     * @return void
     * @since 0.1.0
     */
    public function assertPropertySet($propertyName)
    {
        if (!property_exists($this, $propertyName)) {
            $message = sprintf(
                'Property `%s` doesn\'t exist in current class',
                $propertyName
            );
            throw new BadMethodCallException($message);
        }
        if (!isset($this->$propertyName)) {
            $message = sprintf('Property `%s` isn\'t set', $propertyName);
            throw new RuntimeException($message);
        }
    }

    /**
     * Asserts that list of properties has been set.
     *
     * @param string[] $propertyNames Names of the properties.
     *
     * @throws BadMethodCallException Thrown in case name of property not
     *                                declared in current class was requested.
     * @throws RuntimeException       Thrown in case any of provided properties
     *                                hasn't been set.
     *
     * @return void
     * @since 0.1.0
     */
    public function assertPropertiesSet(array $propertyNames)
    {
        $missing = array();
        foreach ($propertyNames as $propertyName) {
            if (!property_exists($this, $propertyName)) {
                $message = sprintf(
                    'Property `%s` doesn\'t exist in current class',
                    $propertyName
                );
                throw new BadMethodCallException($message);
            }
            if (!isset($this->$propertyName)) {
                $missing[] = $propertyName;
            }
        }
        if ($missing) {
            $message = 'Missing following properties: ' .
                implode(', ', $missing);
            throw new RuntimeException($message);
        }
    }

    /**
     * Verifies that all properties have been set.
     *
     * @throws BadMethodCallException Thrown in case name of property not
     *                                declared in current class was requested.
     * @throws RuntimeException       Thrown in case any of declared properties
     *                                hasn't been set.
     *
     * @return void
     * @since 0.1.0
     */
    public function assertAllPropertiesSet()
    {
        $this->assertPropertiesSet(get_class_vars(get_class($this)));
    }


    /**
     * Verifies that all properties have been set except for provided ones.
     *
     * @throws BadMethodCallException Thrown in case name of property not
     *                                declared in current class was requested.
     * @throws RuntimeException       Thrown in case any of declared properties
     *                                hasn't been set.
     *
     * @return void
     * @since 0.1.0
     */
    public function assertAllPropertiesSetExcept(array $excludedProperties)
    {
        $allProperties = get_class_vars(get_class($this));
        $propertyNames = array_diff($allProperties, $excludedProperties);
        $this->assertAllPropertiesSet($propertyNames);
    }

    /**
     * Sets many properties at once.
     *
     * @param array $props Property data.
     *
     * @return void
     * @since 0.1.0
     */
    public function batchPropertySet(array $props)
    {
        foreach ($props as $key => $value) {
            if (!property_exists($this, $key)) {
                continue;
            }
            $this->$key = $value;
        }
    }

    /**
     * Internal setter / getter support.
     *
     * @param string $name Method name.
     * @param array  $args Arguments.
     *
     * @return $this|mixed Returns current instance for setters and anything for
     *                     getter.
     * @since 0.1.0
     */
    public function __call($name, array $args = null)
    {
        $prefix = substr($name, 0, 3);
        if (($prefix !== 'set' && $prefix !== 'get') || strlen($name) < 5) {
            $message = sprintf('Unknown method `%s`', $name);
            throw new BadMethodCallException($message);
        }
        $propertyName = strtolower($name[3]) . substr($name, 4);
        if (!property_exists($this, $propertyName)) {
            $message = sprintf('Unknown property %s', $propertyName);
            throw new RuntimeException($message);
        }
        if ($prefix === 'set') {
            if (!$args) {
                throw new BadMethodCallException('No data provided for setter');
            }
            $this->$propertyName = $args[0];
            return $this;
        }
        return $this->$propertyName;
    }
}
