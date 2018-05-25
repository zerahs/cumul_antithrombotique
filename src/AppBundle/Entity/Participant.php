<?php

namespace AppBundle\Entity;

/**
 * Participant
 */
class Participant
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $age;

    /**
     * @var string
     */
    private $gender;

    /**
     * @var string
     */
    private $specialty;

    /**
     * @var string
     */
    private $place;

    private $randomizationGroup;
    private $randomizationNumber;

    public function __construct()
    {
        $this->gender = 'F';
        $this->age = '40';
        $this->specialty = 'cardio';
        $this->place = 'Nantes';
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
     * Set age
     *
     * @param integer $age
     *
     * @return Participant
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return int
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set gender
     *
     * @param string $gender
     *
     * @return Participant
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set specialty
     *
     * @param string $specialty
     *
     * @return Participant
     */
    public function setSpecialty($specialty)
    {
        $this->specialty = $specialty;

        return $this;
    }

    /**
     * Get specialty
     *
     * @return string
     */
    public function getSpecialty()
    {
        return $this->specialty;
    }

    /**
     * Set place
     *
     * @param string $place
     *
     * @return Participant
     */
    public function setPlace($place)
    {
        $this->place = $place;

        return $this;
    }

    /**
     * Get place
     *
     * @return string
     */
    public function getPlace()
    {
        return $this->place;
    }


    /**
     * Set randomizationGroup
     *
     * @param string $randomizationGroup
     *
     * @return Participant
     */
    public function setRandomizationGroup($randomizationGroup)
    {
        $this->randomizationGroup = $randomizationGroup;

        return $this;
    }

    /**
     * Get randomizationGroup
     *
     * @return string
     */
    public function getRandomizationGroup()
    {
        return $this->randomizationGroup;
    }


    /**
     * Set randomizationNumber
     *
     * @param integer $randomizationNumber
     *
     * @return Participant
     */
    public function setRandomizationNumber($randomizationNumber)
    {
        $this->randomizationNumber = $randomizationNumber;

        return $this;
    }

    /**
     * Get randomizationNumber
     *
     * @return integer
     */
    public function getRandomizationNumber()
    {
        return $this->randomizationNumber;
    }
}
