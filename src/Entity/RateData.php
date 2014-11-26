<?php

namespace Etki\MvnoApiClient\Entity;

/**
 * This entity represents rates data structure coming from API.
 *
 * @method $this setMt(int $incoming)
 * @method int getMt()
 * @method $this setMofix(int $toFixedLine)
 * @method int getMofix()
 * @method $this setMomob(int $toMobile)
 * @method int getMomob()
 * @method $this setMolocal(int $toLocal)
 * @method int getMolocal()
 * @method $this setSms(int $sms)
 * @method int getSms()
 * @method $this setVoipfix(int $voipToFixed)
 * @method int getVoipfix()
 * @method $this setVoipmob(int $voipToMobile)
 * @method int getVoipmob()
 * @method $this setData(int $data)
 * @method int getData()
 * @method $this setType(string $type)
 * @method string getType()
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\MvnoApiClient\Entity
 * @author  Etki <etki@etki.name>
 */
class RateData extends AbstractEntity
{
    protected $mt;      // $incoming;
    protected $mofix;   // $toFixedLine;
    protected $momob;   // $toMobile;
    protected $molocal; // $toLocal;
    protected $sms;
    protected $voipfix; // $voipToFixed;
    protected $voipmob; // $voipToMobile;
    protected $data;
    protected $type;
    const TYPE_SETUP = 'setup';
    const TYPE_RATE = 'rate';
}
 