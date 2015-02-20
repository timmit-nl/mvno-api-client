<?php

namespace Etki\MvnoApiClient\SearchCriteria;

/**
 * Search criteria for MSISDN records.
 *
 * @method $this setFilter(string $filter)
 * @method string getFilter()
 * @method $this setRangeFrom(string $rangeFrom)
 * @method string getRangeFrom()
 * @method $this setRangeTo(string $rangeTo)
 * @method string getRangeTo()
 * @method $this setUnassigned(bool $unassigned)
 * @method bool getUnassigned()
 * @method $this setRandomSet(bool $randomSet)
 * @method bool getRandomSet()
 * @method $this setCountryCode(string $countryCode)
 * @method string getCountryCode()
 *
 * @version 0.1.1
 * @since   0.1.0
 * @package Etki\MvnoApiClient\SearchCriteria
 * @author  Etki <etki@etki.name>
 */
class MsisdnSearchCriteria extends AbstractSearchCriteria
{
    /**
     * Default country code to use.
     *
     * @since 0.1.1
     */
    const DEFAULT_COUNTRY_CODE = 'JEY';
    /**
     * MSISDN wildcard filter.
     *
     * @type string
     * @since 0.1.0
     */
    protected $filter;
    /**
     * Starting point.
     *
     * @type string
     * @since 0.1.0
     */
    protected $rangeFrom;
    /**
     * Ending point.
     *
     * @type string
     * @since 0.1.0
     */
    protected $rangeTo;
    /**
     * Set to true to receive only free MSISDN,
     *
     * @type bool
     * @since 0.1.0
     */
    protected $unassigned = false;
    /**
     * Set to true to receive random set of MSISDN.
     *
     * @type bool
     * @since 0.1.0
     */
    protected $randomSet = false;
    /**
     * Set this to specific country code to restrict MSISDNs to specific
     * country.
     *
     * @type string
     * @since 0.1.0
     */
    protected $countryCode = self::DEFAULT_COUNTRY_CODE;
}
