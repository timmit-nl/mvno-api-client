<?php

namespace Etki\MvnoApiClient\SearchCriteria;

use BadMethodCallException;

/**
 * Base functionality for search criteria.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\MvnoApiClient\SearchCriteria
 * @author  Etki <etki@etki.name>
 */
abstract class AbstractSearchCriteria
{
    /**
     * Virtual getter and setter.
     *
     * @param string $name Method name.
     * @param array  $args Additional arguments.
     *
     * @return $this|mixed Current instance for setters, mixed for getters.
     * @since 0.1.0
     */
    public function __call($name, array $args = null)
    {
        $prefix = substr($name, 0, 3);
        if (($prefix !== 'set' && $prefix !== 'get') || strlen($name) < 5) {
            $message = sprintf('Method `%s` doesn\'t exist', $name);
            throw new BadMethodCallException($message);
        }
        $propertyName = strtolower($name[3]) . substr($name, 4);
        if (!property_exists($this, $propertyName)) {
            $message = sprintf('Method `%s` doesn\'t exist', $name);
            throw new BadMethodCallException($message);
        }
        if ($prefix === 'get') {
            return $this->$propertyName;
        }
        if (!$args) {
            $message = 'Setter is missing it\'s arguments';
            throw new BadMethodCallException($message);
        }
        $this->$propertyName = $args[0];
        return $this;
    }

    /**
     * Returns all properties.
     *
     * @return array
     * @since 0.1.0
     */
    public function getProperties()
    {
        return get_object_vars($this);
    }

    /**
     * Returns list of properties.
     *
     * @return string[]
     * @since 0.1.0
     */
    public function getPropertyNames()
    {
        return array_keys(get_class_vars(get_class($this)));
    }
}
