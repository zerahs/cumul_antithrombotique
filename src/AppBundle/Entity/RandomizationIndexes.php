<?php

namespace AppBundle\Entity;

/**
 * RandomizationIndexes
 */
class RandomizationIndexes
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $cardio;

    /**
     * @var int
     */
    private $mg;

    /**
     * @var int
     */
    private $control;

    /**
     * @var int
     */
    private $tool;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set cardio
     *
     * @param integer $cardio
     *
     * @return RandomizationIndexes
     */
    public function setCardio($cardio)
    {
        $this->cardio = $cardio;

        return $this;
    }

    /**
     * Get cardio
     *
     * @return int
     */
    public function getCardio()
    {
        return $this->cardio;
    }

    /**
     * Set mg
     *
     * @param integer $mg
     *
     * @return RandomizationIndexes
     */
    public function setMg($mg)
    {
        $this->mg = $mg;

        return $this;
    }

    /**
     * Get mg
     *
     * @return int
     */
    public function getMg()
    {
        return $this->mg;
    }

    /**
     * Set control
     *
     * @param integer $control
     *
     * @return RandomizationIndexes
     */
    public function setControl($control)
    {
        $this->control = $control;

        return $this;
    }

    /**
     * Get control
     *
     * @return int
     */
    public function getControl()
    {
        return $this->control;
    }

    /**
     * Set tool
     *
     * @param integer $tool
     *
     * @return RandomizationIndexes
     */
    public function setTool($tool)
    {
        $this->tool = $tool;

        return $this;
    }

    /**
     * Get tool
     *
     * @return int
     */
    public function getTool()
    {
        return $this->tool;
    }
}

