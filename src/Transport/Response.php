<?php

namespace Etki\MvnoApiClient\Transport;

/**
 * This class represents API response.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\MvnoApiClient
 * @author  Etki <etki@etki.name>
 */
class Response
{
    /**
     * Data holder.
     *
     * @type array
     * @since 0.1.0
     */
    protected $data;

    /**
     * Sets data.
     *
     * @param array $data Sets incoming data.
     *
     * @return void
     * @since 0.1.0
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }

    /**
     * Returns response data.
     *
     * @return array.
     * @since 0.1.0
     */
    public function getData()
    {
        return $this->data;
    }
}
