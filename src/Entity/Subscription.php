<?php

namespace Etki\MvnoApiClient\Entity;

/**
 * This entity represents single subscription.
 *
 * @method $this setId(int $id)
 * @method int getId()
 * @method $this setPackageId(int $packageId)
 * @method int getPackageId()
 * @method $this setName(string $name)
 * @method string getName()
 * @method $this setPackageName(string $packageName)
 * @method string getPackageName()
 * @method $this setCost(int $cost)
 * @method int getCost()
 * @method $this setActive(bool $active)
 * @method bool getActive()
 * @method $this setRestriction(mixed $restriction)
 * @method mixed getRestriction()
 * @method $this setDestination(mixed $destination)
 * @method mixed getDestination()
 * @method $this setLocalAvailability(bool $localAvailability)
 * @method bool getLocalAvailability()
 * @method $this setMinimumDuration(string $minimumDuration)
 * @method string getMinimumDuration()
 * @method $this setBillingPeriod(int $billingPeriod)
 * @method int getBillingPeriod()
 * @method $this setStartDate(string $startDate)
 * @method string getStartDate()
 * @method $this setEndDate(string $endDate)
 * @method string getEndDate()
 * @method $this setBillingPeriodStart(string $billingPeriodStart)
 * @method string getBillingPeriodStart()
 * @method $this setLimitedServiceFlag(bool $limitedServiceFlag)
 * @method bool getLimitedServiceFlag()
 * @method $this setRecurring(bool $recurring);
 * @method bool getRecurring();
 *
 * @SuppressWarnings(PHPMD.ShortVariableName)
 *
 * @todo phpdoc + casting setters
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\MvnoApiClient\Entity
 * @author  Etki <etki@etki.name>
 */
class Subscription extends AbstractEntity
{
    public $id;
    public $subId;
    public $packageId;
    public $name;
    public $packageName;
    public $cost;
    public $active;
    public $restriction;
    public $destination;
    public $localAvailability;
    public $minimumDuration;
    public $billingPeriod;
    public $startDate;
    public $endDate;
    public $billingPeriodStart;
    public $limitedServiceFlag;
    public $recurring;
}
 