<?php

namespace Etki\MvnoApiClient\SearchCriteria;

/**
 * Search criteria for MSISDN records.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\MvnoApiClient\SearchCriteria
 * @author  Etki <etki@etki.name>
 */
class MsisdnSearchCriteria extends AbstractSearchCriteria
{
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
    protected $unassigned;
    /**
     * Set to true to receive random set of MSISDN.
     *
     * @type bool
     * @since 0.1.0
     */
    protected $randomSet;
    /**
     * Set this to specific country code to restrict MSISDNs to specific
     * country.
     *
     * @type string
     * @since 0.1.0
     */
    protected $countryCode;
}
