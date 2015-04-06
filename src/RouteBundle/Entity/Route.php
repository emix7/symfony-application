<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace RouteBundle\Entity;

class Route
{
    /**
     * @var
     */
    protected $key;

    /**
     * @var
     */
    protected $label;

    /**
     * @var
     */
    protected $name;

    /**
     * @var array
     */
    protected $parameters;

    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->parameters = array();
    }

    /**
     * Sets the key.
     *
     * @param $key
     *
     * @return Route
     */
    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Returns the key.
     *
     * @return int
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Sets the label.
     *
     * @param $label
     *
     * @return Route
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Returns the label.
     *
     * @return int
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Sets the name.
     *
     * @param $name
     *
     * @return Route
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Returns the name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the parameters.
     *
     * @param $parameters
     *
     * @return Route
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * Returns the parameters.
     *
     * @return string
     */
    public function getParameters()
    {
        return $this->parameters;
    }
}
