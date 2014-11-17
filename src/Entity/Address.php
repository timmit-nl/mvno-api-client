<?php

namespace Etki\MvnoApiClient\Entity;

/**
 * Address entity.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\MvnoApiClient\Entity
 * @author  Etki <etki@etki.name>
 */
class Address
{
    /**
     * ID of the related customer
     *
     * @type string
     * @since 0.1.0
     */
    protected $customerId;
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
    protected $poBox;
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
    protected $additional;
    /**
     * Country.
     *
     * @type string
     * @since 0.1.0
     */
    protected $country;
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
     * Returns customerId.
     *
     * @return string
     * @since 0.1.0
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * Sets customerId.
     *
     * @param string $customerId
     *
     * @return void
     * @since 0.1.0
     */
    public function setCustomerId($customerId)
    {
        $this->customerId = $customerId;
    }

    /**
     * Returns firstName.
     *
     * @return string
     * @since 0.1.0
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Sets firstName.
     *
     * @param string $firstName
     *
     * @return void
     * @since 0.1.0
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * Returns lastName.
     *
     * @return string
     * @since 0.1.0
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Sets lastName.
     *
     * @param string $lastName
     *
     * @return void
     * @since 0.1.0
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * Returns company.
     *
     * @return string
     * @since 0.1.0
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Sets company.
     *
     * @param string $company
     *
     * @return void
     * @since 0.1.0
     */
    public function setCompany($company)
    {
        $this->company = $company;
    }

    /**
     * Returns street.
     *
     * @return string
     * @since 0.1.0
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Sets street.
     *
     * @param string $street
     *
     * @return void
     * @since 0.1.0
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }

    /**
     * Returns poBox.
     *
     * @return string
     * @since 0.1.0
     */
    public function getPoBox()
    {
        return $this->poBox;
    }

    /**
     * Sets poBox.
     *
     * @param string $poBox
     *
     * @return void
     * @since 0.1.0
     */
    public function setPoBox($poBox)
    {
        $this->poBox = $poBox;
    }

    /**
     * Returns postCode.
     *
     * @return string
     * @since 0.1.0
     */
    public function getPostCode()
    {
        return $this->postCode;
    }

    /**
     * Sets postCode.
     *
     * @param string $postCode
     *
     * @return void
     * @since 0.1.0
     */
    public function setPostCode($postCode)
    {
        $this->postCode = $postCode;
    }

    /**
     * Returns city.
     *
     * @return string
     * @since 0.1.0
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Sets city.
     *
     * @param string $city
     *
     * @return void
     * @since 0.1.0
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * Returns state.
     *
     * @return string
     * @since 0.1.0
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Sets state.
     *
     * @param string $state
     *
     * @return void
     * @since 0.1.0
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * Returns additional.
     *
     * @return string
     * @since 0.1.0
     */
    public function getAdditional()
    {
        return $this->additional;
    }

    /**
     * Sets additional.
     *
     * @param string $additional
     *
     * @return void
     * @since 0.1.0
     */
    public function setAdditional($additional)
    {
        $this->additional = $additional;
    }

    /**
     * Returns country.
     *
     * @return string
     * @since 0.1.0
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Sets country.
     *
     * @param string $country
     *
     * @return void
     * @since 0.1.0
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * Returns phone.
     *
     * @return string
     * @since 0.1.0
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Sets phone.
     *
     * @param string $phone
     *
     * @return void
     * @since 0.1.0
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * Returns fax.
     *
     * @return string
     * @since 0.1.0
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Sets fax.
     *
     * @param string $fax
     *
     * @return void
     * @since 0.1.0
     */
    public function setFax($fax)
    {
        $this->fax = $fax;
    }
}
