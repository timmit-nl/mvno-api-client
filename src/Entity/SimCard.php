<?php

namespace Etki\MvnoApiClient\Entity;

/**
 *
 *
 * @version 0.1.0
 * @since   
 * @package Etki\MvnoApiClient\Entity
 * @author  Etki <etki@etki.name>
 */
class SimCard
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

    /**
     * Returns customerId.
     *
     * @return int
     * @since 0.1.0
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * Sets customerId.
     *
     * @param int $customerId
     *
     * @return void
     * @since 0.1.0
     */
    public function setCustomerId($customerId)
    {
        $this->customerId = $customerId;
    }

    /**
     * Returns msisdn.
     *
     * @return string
     * @since 0.1.0
     */
    public function getMsisdn()
    {
        return $this->msisdn;
    }

    /**
     * Sets msisdn.
     *
     * @param string $msisdn
     *
     * @return void
     * @since 0.1.0
     */
    public function setMsisdn($msisdn)
    {
        $this->msisdn = $msisdn;
    }

    /**
     * Returns iccid.
     *
     * @return string
     * @since 0.1.0
     */
    public function getIccid()
    {
        return $this->iccid;
    }

    /**
     * Sets iccid.
     *
     * @param string $iccid
     *
     * @return void
     * @since 0.1.0
     */
    public function setIccid($iccid)
    {
        $this->iccid = $iccid;
    }

    /**
     * Returns puk.
     *
     * @return string
     * @since 0.1.0
     */
    public function getPuk()
    {
        return $this->puk;
    }

    /**
     * Sets puk.
     *
     * @param string $puk
     *
     * @return void
     * @since 0.1.0
     */
    public function setPuk($puk)
    {
        $this->puk = $puk;
    }

    /**
     * Returns verifyOnly.
     *
     * @return boolean
     * @since 0.1.0
     */
    public function isVerifyOnly()
    {
        return $this->verifyOnly;
    }

    /**
     * Sets verifyOnly.
     *
     * @param boolean $verifyOnly
     *
     * @return void
     * @since 0.1.0
     */
    public function setVerifyOnly($verifyOnly)
    {
        $this->verifyOnly = $verifyOnly;
    }

}
