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

    /**
     * @var int
     */
    private $questionId;
    
    /**
     * @var array
     */
    private $data;

    /**
     * @var \AppBundle\Entity\Participant
     */
    private $participant;


    public function __construct(Participant $participant, $questionId, array $data)
    {
        $this->participant = $participant;
        $this->questionId = $questionId;
        $this->data = $data;
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

    /**
     * Set questionId
     *
     * @param integer $questionId
     *
     * @return Answer
     */
    public function setQuestionId($questionId)
    {
        $this->questionId = $questionId;

        return $this;
    }

    /**
     * Get questionId
     *
     * @return int
     */
    public function getQuestionId()
    {
        return $this->questionId;
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
}
