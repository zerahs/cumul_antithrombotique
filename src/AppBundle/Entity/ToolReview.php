<?php

namespace AppBundle\Entity;

/**
 * ToolReview
 */
class ToolReview
{
    private $id;
    private $prescription;
    private $changes;
    private $clear;
    private $operational;
    private $useful;
    private $ready;
    private $recommend;
    private $remarks;
    private $participant;

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
     * Set prescription
     *
     * @param integer $prescription
     *
     * @return ToolReview
     */
    public function setPrescription($prescription)
    {
        $this->prescription = $prescription;

        return $this;
    }

    /**
     * Get prescription
     *
     * @return int
     */
    public function getPrescription()
    {
        return $this->prescription;
    }

    /**
     * Set changes
     *
     * @param integer $changes
     *
     * @return ToolReview
     */
    public function setChanges($changes)
    {
        $this->changes = $changes;

        return $this;
    }

    /**
     * Get changes
     *
     * @return int
     */
    public function getChanges()
    {
        return $this->changes;
    }

    /**
     * Set clear
     *
     * @param integer $clear
     *
     * @return ToolReview
     */
    public function setClear($clear)
    {
        $this->clear = $clear;

        return $this;
    }

    /**
     * Get clear
     *
     * @return int
     */
    public function getClear()
    {
        return $this->clear;
    }

    /**
     * Set operational
     *
     * @param integer $operational
     *
     * @return ToolReview
     */
    public function setOperational($operational)
    {
        $this->operational = $operational;

        return $this;
    }

    /**
     * Get operational
     *
     * @return int
     */
    public function getOperational()
    {
        return $this->operational;
    }

    /**
     * Set useful
     *
     * @param integer $useful
     *
     * @return ToolReview
     */
    public function setUseful($useful)
    {
        $this->useful = $useful;

        return $this;
    }

    /**
     * Get useful
     *
     * @return int
     */
    public function getUseful()
    {
        return $this->useful;
    }

    /**
     * Set ready
     *
     * @param integer $ready
     *
     * @return ToolReview
     */
    public function setReady($ready)
    {
        $this->ready = $ready;

        return $this;
    }

    /**
     * Get ready
     *
     * @return int
     */
    public function getReady()
    {
        return $this->ready;
    }

    /**
     * Set recommend
     *
     * @param integer $recommend
     *
     * @return ToolReview
     */
    public function setRecommend($recommend)
    {
        $this->recommend = $recommend;

        return $this;
    }

    /**
     * Get recommend
     *
     * @return int
     */
    public function getRecommend()
    {
        return $this->recommend;
    }

    /**
     * Set remarks
     *
     * @param string $remarks
     *
     * @return ToolReview
     */
    public function setRemarks($remarks)
    {
        $this->remarks = $remarks;

        return $this;
    }

    /**
     * Get remarks
     *
     * @return string
     */
    public function getRemarks()
    {
        return $this->remarks;
    }


    /**
     * Set participant
     *
     * @param \AppBundle\Entity\Participant $participant
     *
     * @return ToolReview
     */
    public function setParticipant(\AppBundle\Entity\Participant $participant = null)
    {
        $this->participant = $participant;

        return $this;
    }

    /**
     * Get participant
     *
     * @return \AppBundle\Entity\Participant
     */
    public function getParticipant()
    {
        return $this->participant;
    }
}
