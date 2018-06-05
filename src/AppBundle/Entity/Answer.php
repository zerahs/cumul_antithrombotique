<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Participant;

/**
 * Answer
 */
class Answer
{
    /**
     * @var int
     */
    private $id;

    private $questionRef;
    private $vignetteId;
    
    /**
     * @var array
     */
    private $data;

    /**
     * @var \AppBundle\Entity\Participant
     */
    private $participant;

    private $valid;

    public function __construct(Participant $participant, $vignetteId, $questionRef, array $data, $valid)
    {
        $this->participant = $participant;
        $this->vignetteId = $vignetteId;
        $this->questionRef = $questionRef;
        $this->data = $data;
        $this->valid = $valid;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function setQuestionRef($questionRef)
    {
        $this->questionRef = $questionRef;

        return $this;
    }

    public function getQuestionRef()
    {
        return $this->questionRef;
    }


    /**
     * Set data
     *
     * @param array $data
     *
     * @return Answer
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set participant
     *
     * @param \AppBundle\Entity\Participant $participant
     *
     * @return Answer
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


    /**
     * Set vignetteId
     *
     * @param integer $vignetteId
     *
     * @return Answer
     */
    public function setVignetteId($vignetteId)
    {
        $this->vignetteId = $vignetteId;

        return $this;
    }

    /**
     * Get vignetteId
     *
     * @return integer
     */
    public function getVignetteId()
    {
        return $this->vignetteId;
    }

    /**
     * Set valid
     *
     * @param boolean $valid
     *
     * @return Answer
     */
    public function setValid($valid)
    {
        $this->valid = $valid;

        return $this;
    }

    /**
     * Get valid
     *
     * @return boolean
     */
    public function getValid()
    {
        return $this->valid;
    }
}
