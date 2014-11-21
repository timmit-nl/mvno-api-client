<?php

namespace Etki\MvnoApiClient\Entity;

/**
 * Address entity.
 *
 * @method $this setId(int $id)
 * @method int getId()
 * @method $this setCustomerId(int $customerId)
 * @method int getCustomerId()
 * @method $this setEmail(string $email)
 * @method string getEmail()
 * @method $this setFirstName(string $firstName)
 * @method string getFirstName()
 * @method $this setLastName(string $lastName)
 * @method string getLastName()
 * @method $this setCompany(string $company)
 * @method string getCompany()
 * @method $this setStreet(string $street)
 * @method string getStreet()
 * @method $this setPostOfficeBox(string $postOfficeBox)
 * @method string getPostOfficeBox()
 * @method $this setPostCode(string $postCode)
 * @method string getPostCode()
 * @method $this setCity(string $city)
 * @method string getCity()
 * @method $this setState(string $state)
 * @method string getState()
 * @method $this setAdditionalInformation(string $additionalInformation)
 * @method string getAdditionalInformation()
 * @method $this setCountryCode(string $countryCode)
 * @method string getCountryCode()
 * @method $this setPhone(string $phone)
 * @method string getPhone()
 * @method $this setFax(string $fax)
 * @method string getFax()
 *
 * @SuppressWarnings(PHPMD.TooManyFields)
 * @SuppressWarnings(PHPMD.ShortVariableName)
 * @SuppressWarnings(PHPMD.LongVariableName)
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\MvnoApiClient\Entity
 * @author  Etki <etki@etki.name>
 */
class Address extends AbstractEntity
{
    /**
     * Address record identifier.
     *
     * @type int
     * @since 0.1.0
     */
    protected $id;
    /**
     * ID of the related customer
     *
     * @type string
     * @since 0.1.0
     */
    protected $customerId;
    /**
     * Person's email.
     *
     * @type string
     * @since 0.1.0
     */
    protected $email;
    /**
     * Person's honorific. 0 for none, 1 for 'ms' and 2 for 'mr'.
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
     * Customer's company (if any).
     *
     * @type string
     * @since 0.1.0
     */
    protected $company;
    /**
     * Street.
     *
     * @type string
     * @since 0.1.0
     */
    protected $street;
    /**
     * Postal box.
     *
     * @type string
     * @since 0.1.0
     */
    protected $postOfficeBox;
    /**
     * Postal code.
     *
     * @type string
     * @since 0.1.0
     */
    protected $postCode;
    /**
     * Customer's city.
     *
     * @type string
     * @since 0.1.0
     */
    protected $city;
    /**
     * Customer state.
     *
     * @type string
     * @since 0.1.0
     */
    protected $state;
    /**
     * Additional address info.
     *
     * @type string
     * @since 0.1.0
     */
    protected $additionalInformation;
    /**
     * Country.
     *
     * @type string
     * @since 0.1.0
     */
    protected $countryCode;
    /**
     * Phone,
     *
     * @type string
     * @since 0.1.0
     */
    protected $phone;
    /**
     * Customer's fax.
     *
     * @type string
     * @since 0.1.0
     */
    protected $fax;

    /**
     * Sets title.
     *
     * @param string $title Title (honorific) to set.
     *
     * @return void
     * @since 0.1.0
     */
    public function setTitle($title)
    {
        $this->honorific = $title;
    }

    /**
     * Returns title (honorific).
     *
     * @return int
     * @since 0.1.0
     */
    public function getTitle()
    {
        return $this->honorific;
    }

    /**
     * Converts honorific (title) to it's string representation.
     *
     * @return string Returns honorific representation.
     * @since 0.1.0
     */
    public function getHonorificRepresentation()
    {
        switch ($this->honorific) {
            case 1:
                return 'Ms';
            case 2:
                return 'Mr';
            default:
                return 'None';
        }
    }

    /**
     * Sets country code.
     *
     * @param string $country Two-letter country code.
     *
     * @return $this Current instance.
     * @since 0.1.0
     */
    public function setCountry($country)
    {
        $this->countryCode = $country;
        return $this;
    }

    /**
     * Returns country code, duplicates self::getCountryCode().
     *
     * @return string Two-letter country code.
     * @since 0.1.0
     */
    public function getCountry()
    {
        return $this->countryCode;
    }

    /**
     * Sets post office box, duplicates self::setPostOfficeBox().
     *
     * @param string $poBox Post office box.
     *
     * @return $this Current instance.
     * @since 0.1.0
     */
    public function setPoBox($poBox)
    {
        $this->postOfficeBox = $poBox;
        return $this;
    }

    /**
     * Returns post office box, duplicates self::getPostOfficeBox().
     *
     * @return string Post office box.
     * @since 0.1.0
     */
    public function getPoBox()
    {
        return $this->postOfficeBox;
    }

    /**
     * Sets additional information, duplicates self::setAdditionalInformation().
     *
     * @param string $additional Additional information.
     *
     * @return $this Current instance.
     * @since 0.1.0
     */
    public function setAdditional($additional)
    {
        $this->additionalInformation = $additional;
        return $this;
    }

    /**
     * Returns additional information, duplicates
     * self::getAdditionalInformation()
     *
     * @return string Additional information.
     * @since 0.1.0
     */
    public function getAdditional()
    {
        return $this->additionalInformation;
    }
}
