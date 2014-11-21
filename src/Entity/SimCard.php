<?php

namespace Etki\MvnoApiClient\Entity;

/**
 * This entity represents sim card.
 *
 * @method int getCustomerId()
 * @method $this setCustomerId(int $customerId)
 * @method string getMsisdn()
 * @method $this setMsisdn(string $msisdn)
 * @method string getIccid()
 * @method $this setIccid(string $iccid)
 * @method string getPuk()
 * @method $this setPuk(string $puk)
 * @method bool getVerifyOnly()
 * @method $this setVerifyOnly(bool $verifyOnly)
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\MvnoApiClient\Entity
 * @author  Etki <etki@etki.name>
 */
class SimCard extends AbstractEntity
{
    /**
     * Customer ID.
     *
     * @type int
     * @since 0.1.0
     */
    protected $customerId;
    /**
     * Requested MSISDN.
     *
     * @type string
     * @since 0.1.0
     */
    protected $msisdn;
    /**
     * SIM serial,
     *
     * @type string
     * @since 0.1.0
     */
    protected $iccid;
    /**
     * PUK code.
     *
     * @type string
     * @since 0.1.0
     */
    protected $puk;
    /**
     * Whether verify record or not,
     *
     * @type bool
     * @since 0.1.0
     */
    protected $verifyOnly;
}
