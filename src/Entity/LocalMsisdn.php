<?php

namespace Etki\MvnoApiClient\Entity;

/**
 * This entity represents sim card.
 *
 * @method string getMsisdn()
 * @method $this setMsisdn(string $msisdn)
 * @method string getCountryCode()
 * @method $this setCountryCode(string $countryCode)
 * @method string getLocalMsisdn()
 * @method $this setLocalMsisdn(string $localMsisdn)
 * @method bool getVerifyOnly()
 * @method $this setVerifyOnly(bool $verifyOnly)
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\MvnoApiClient\Entity
 * @author  Etki <etki@etki.name>
 */
class LocalMsisdn extends AbstractEntity
{
    /**
     * Requested MSISDN.
     *
     * @type string
     * @since 0.1.0
     */
    protected $msisdn;
    /**
     * countryCode,
     *
     * @type string
     * @since 0.1.0
     */
    protected $countryCode;
    /**
     * localMsisdn.
     *
     * @type string
     * @since 0.1.0
     */
    protected $localMsisdn;
    /**
     * Whether verify record or not,
     *
     * @type bool
     * @since 0.1.0
     */
    protected $verifyOnly = false;
}
