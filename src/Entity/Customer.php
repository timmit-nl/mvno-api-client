<?php

namespace Etki\MvnoApiClient\Entity;

/**
 * This entity represents single customer.
 *
 * @version 0.1.0
 * @since   
 * @package Etki\MvnoApiClient\Entity
 * @author  Etki <etki@etki.name>
 */
class Customer
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
     * User title, %none%|mr|ms.
     *
     * @type string
     * @since 0.1.0
     */
    protected $title;
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
     *
     *
     * @type
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
     * Returns user ID.
     *
     * @return int
     * @since 0.1.0
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * Sets customer ID.
     *
     * @return void
     * @since 0.1.0
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    /**
     * Returns email.
     *
     * @return string
     * @since 0.1.0
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Sets email.
     *
     * @param string $email
     *
     * @return void
     * @since 0.1.0
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Returns password.
     *
     * @return string
     * @since 0.1.0
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Sets password.
     *
     * @param string $password
     *
     * @return void
     * @since 0.1.0
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Returns title.
     *
     * @return string
     * @since 0.1.0
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets title.
     *
     * @param string $title
     *
     * @return void
     * @since 0.1.0
     */
    public function setTitle($title)
    {
        $this->title = $title;
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
     * Returns language.
     *
     * @return string
     * @since 0.1.0
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Sets language.
     *
     * @param string $language
     *
     * @return void
     * @since 0.1.0
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }

    /**
     * Returns identification number.
     *
     * @return string
     * @since 0.1.0
     */
    public function getIdentificationNumber()
    {
        return $this->identificationNumber;
    }

    /**
     * Sets identification number.
     *
     * @param string $identificationNumber
     *
     * @return void
     * @since 0.1.0
     */
    public function setIdentificationNumber($identificationNumber)
    {
        $this->identificationNumber = $identificationNumber;
    }

    /**
     * Returns identification type.
     *
     * @return mixed
     * @since 0.1.0
     */
    public function getIdentificationType()
    {
        return $this->identificationType;
    }

    /**
     * Sets identification type.
     *
     * @param mixed $identificationType
     *
     * @return void
     * @since 0.1.0
     */
    public function setIdentificationType($identificationType)
    {
        $this->identificationType = $identificationType;
    }

    /**
     * Returns nationality.
     *
     * @return string
     * @since 0.1.0
     */
    public function getNationality()
    {
        return $this->nationality;
    }

    /**
     * Sets nationality.
     *
     * @param string $nationality
     *
     * @return void
     * @since 0.1.0
     */
    public function setNationality($nationality)
    {
        $this->nationality = $nationality;
    }

    /**
     * Returns birth date.
     *
     * @return string
     * @since 0.1.0
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * Sets birthDate.
     *
     * @param string $birthDate
     *
     * @return void
     * @since 0.1.0
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;
    }

    /**
     * Returns confirmed.
     *
     * @return boolean
     * @since 0.1.0
     */
    public function isConfirmed()
    {
        return $this->confirmed;
    }

    /**
     * Sets confirmed.
     *
     * @param boolean $confirmed
     *
     * @return void
     * @since 0.1.0
     */
    public function setConfirmed($confirmed)
    {
        $this->confirmed = $confirmed;
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
