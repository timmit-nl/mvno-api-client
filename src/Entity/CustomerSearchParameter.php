<?php

namespace Etki\MvnoApiClient\Entity;

use InvalidArgumentException;

/**
 * This class is used as an entity representing customer search parameter.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\MvnoApiClient\Entity
 * @author  Etki <etki@etki.name>
 */
class CustomerSearchParameter
{
    /**
     * Constant for specifying customer search by ID.
     *
     * @type int
     * @since 0.1.0
     */
    const SEARCH_PARAMETER_ID = 1;
    /**
     * Constant for specifying customer search by email.
     *
     * @type int
     * @since 0.1.0
     */
    const SEARCH_PARAMETER_EMAIL = 2;
    /**
     * Constant for specifying customer search by MSISDN.
     */
    const SEARCH_PARAMETER_MSISDN = 3;
    /**
     * Parameter type.
     *
     * @type int
     * @since 0.1.0
     */
    protected $type;
    /**
     * Search query holder.
     *
     * @type string|int
     * @since 0.1.0
     */
    protected $value;

    /**
     * Inner variable initializer.
     *
     * @param int        $type  Parameter type.
     * @param string|int $value Parameter value.
     *
     * @throws InvalidArgumentException Thrown if unknown parameter type is
     * provided.
     *
     * @return self
     * @since 0.1.0
     */
    public function __construct($type, $value)
    {
        $types = array(
            self::SEARCH_PARAMETER_ID,
            self::SEARCH_PARAMETER_EMAIL,
            self::SEARCH_PARAMETER_MSISDN,
        );
        if (!in_array($type, $types)) {
            throw new InvalidArgumentException('Unknown parameter type');
        }
        $this->type = $type;
        $this->value = $value;
    }

    /**
     * Returns search query type.
     *
     * @return int
     * @since 0.1.0
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Returns search query.
     *
     * @return string|int
     * @since 0.1.0
     */
    public function getValue()
    {
        return $this->value;
    }
}
