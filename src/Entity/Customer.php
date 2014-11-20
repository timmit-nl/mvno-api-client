<?php

namespace Etki\MvnoApiClient\Entity;

use Etki\MvnoApiClient\Entity;

use InvalidArgumentException;

/**
 * This entity represents single customer.
 *
 * @method int getId()
 * @method $this setId(int $id)
 * @method string getEmail()
 * @method $this setEmail(string $email)
 * @method string getPassword()
 * @method $this setPassword(string $password)
 * @method int getHonorific()
 * @method $this setHonorific(int $honorific)
 * @method string getFirstName()
 * @method $this setFirstName(string $firstName)
 * @method string getLastName()
 * @method $this setLastName(string $lastName)
 * @method string getLanguage()
 * @method $this setLanguage(string $language)
 * @method string getIdentificationNumber()
 * @method $this setIdentificationNumber(string $identificationNumber)
 * @method int getIdentificationType()
 * @method $this setIdentificationType(int $identificationType)
 * @method string getNationality()
 * @method $this setNationality(string $nationality)
 * @method string getBirthDate()
 * @method $this setBirthDate(string $birthDate)
 * @method bool getConfirmed()
 * @method $this setConfirmed(bool $confirmed)
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\MvnoApiClient\Entity
 * @author  Etki <etki@etki.name>
 */
class Customer extends Entity
{
    /**
     * Constant for specifying empty title.
     *
     * @type string
     * @since 0.1.0
     */
    const TITLE_NONE = 0;
    /**
     * Constant for specifying title `ms`.
     *
     * @type string
     * @since 0.1.0
     */
    const TITLE_MS = 1;
    /**
     * Constant for specifying title `mr`.
     *
     * @type string
     * @since 0.1.0
     */
    const TITLE_MR = 2;
    /**
     * Constant for selecting passport document.
     *
     * @type string
     * @since 0.1.0
     */
    const ID_PASSPORT = 0;
    /**
     * Constant for selecting id card document.
     *
     * @type string
     * @since 0.1.0
     */
    const ID_CARD = 1;
    /**
     * Holder for customer ID.
     *
     * @type int
     * @since 0.1.0
     */
    protected $id;
    /**
     * Holder for email.
     *
     * @type string
     * @since 0.1.0
     */
    protected $email;
    /**
     * User password in plain form.
     *
     * @type string
     * @since 0.1.0
     */
    protected $password;
    /**
     * User honorific (title), 0 = %none% | 1 = ms | 2 = ms.
     *
     * @type int
     * @since 0.1.0
     */
    protected $honorific = 0;
    /**
     * Customer's first name.
     *
     * @type string
     * @since 0.1.0
     */
    protected $firstName;
    /**
     * Customer's last name.
     *
     * @type string
     * @since 0.1.0
     */
    protected $lastName;
    /**
     * Two-letter language code.
     *
     * @type string
     * @since 0.1.0
     */
    protected $language;
    /**
     * Passport or ID card number.
     *
     * @type string
     * @since 0.1.0
     */
    protected $identificationNumber;
    /**
     * Type of identification document, 0 - passport, 1 - ID card.
     *
     * @type int
     * @since 0.1.0
     */
    protected $identificationType;
    /**
     * Two-letters country code.
     *
     * @type string
     * @since 0.1.0
     */
    protected $nationality;
    /**
     * Formatted date of birth.
     *
     * @type string
     * @since 0.1.0
     */
    protected $birthDate;
    /**
     * Whether user is confirmed or has to receive an email to be invited.
     *
     * @type bool
     * @since 0.1.0
     */
    protected $confirmed;

    /**
     * Returns title (as integer).
     *
     * @return int
     * @since 0.1.0
     */
    public function getTitle()
    {
        return $this->honorific;
    }

    /**
     * Sets honorific (title).
     *
     * @param string $title Honorific.
     *
     * @return $this Current instance.
     * @since 0.1.0
     */
    public function setTitle($title)
    {
        if (is_int($title)) {
            $this->honorific = $title;
        }
        $title = strtolower($title);
        switch ($title) {
            case 'none':
                $this->honorific = self::TITLE_NONE;
                break;
            case 'mr':
                $this->honorific = self::TITLE_MR;
                break;
            case 'ms':
                $this->honorific = self::TITLE_MS;
                break;
            default:
                throw new \InvalidArgumentException('Unknown title');
        }
        return $this;
    }

    /**
     * Returns honorific in human-readable format.
     *
     * @return string
     * @since 0.1.0
     */
    public function getHonorificRepresentation()
    {
        switch ($this->honorific) {
            case self::TITLE_MS:
                return 'ms';
            case self::TITLE_MR:
                return 'mr';
            default:
                return 'none';
        }
    }

    /**
     * Creates new address based on current instance data.
     *
     * @return Address
     * @since 0.1.0
     */
    public function createAddress()
    {
        $address = new Address;
        $address->setCustomerId($this->getId());
        $address->setFirstName($this->getFirstName());
        $address->setLastName($this->getLastName());
        return $address;
    }
}
