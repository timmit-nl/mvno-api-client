<?php

namespace Etki\MvnoApiClient\Entity;

/**
 * This entity represents single sim card balance.
 *
 * @method $this setBalance(int $balance)
 * @method int getBalance()
 * @method $this setCurrency(string $currency)
 * @method string getCurrency()
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\MvnoApiClient\Entity
 * @author  Etki <etki@etki.name>
 */
class SimCardBalance extends AbstractEntity
{
    /**
     * Non-normalized balance.
     *
     * @type int
     * @since 0.1.0
     */
    protected $balance;
    /**
     * Currency used for card.
     *
     * @type string
     * @since 0.1.0
     */
    protected $currency;
    /**
     * Tells if card is postpaid.
     *
     * @type bool
     * @since 0.1.0
     */
    protected $postPaid;

    /**
     * Tells if sim card is postpaid.
     *
     * @return bool
     * @since 0.1.0
     */
    public function isPostPaid()
    {
        return $this->postPaid;
    }

    /**
     * Post paid setter,
     *
     * @param boolean $postPaid Postpaid flag.
     *
     * @return void
     * @since 0.1.0
     */
    public function setIsPostPaid($postPaid)
    {
        $this->postPaid = $postPaid;
    }
}
