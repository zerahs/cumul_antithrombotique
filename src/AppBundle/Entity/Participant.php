<?php

namespace AppBundle\Entity;

/**
 * Participant
 */
class Participant
{
    private $id;
    private $age;
    private $gender;
    private $specialty;
    private $thesisDate;
    private $cumulPercent;
    private $atEase;
    private $whereToReco;

    private $randomizationGroup;
    private $randomizationNumber;
    private $vignetteNumbers;

    public function __construct()
    {
        $this->gender = 'F';
        $this->age = '40';
        $this->specialty = 'cardiom';
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


    /**
     * Set vignetteNumbers
     *
     * @param array $vignetteNumbers
     *
     * @return Participant
     */
    public function setVignetteNumbers($vignetteNumbers)
    {
        $this->vignetteNumbers = $vignetteNumbers;

        return $this;
    }

    /**
     * Get vignetteNumbers
     *
     * @return array
     */
    public function getVignetteNumbers()
    {
        return $this->vignetteNumbers;
    }


    /**
     * Set thesisDate
     *
     * @param string $thesisDate
     *
     * @return Participant
     */
    public function setThesisDate($thesisDate)
    {
        $this->thesisDate = $thesisDate;

        return $this;
    }

    /**
     * Get thesisDate
     *
     * @return string
     */
    public function getThesisDate()
    {
        return $this->thesisDate;
    }

    /**
     * Set cumulPercent
     *
     * @param string $cumulPercent
     *
     * @return Participant
     */
    public function setCumulPercent($cumulPercent)
    {
        $this->cumulPercent = $cumulPercent;

        return $this;
    }

    /**
     * Get cumulPercent
     *
     * @return string
     */
    public function getCumulPercent()
    {
        return $this->cumulPercent;
    }

    /**
     * Set atEase
     *
     * @param string $atEase
     *
     * @return Participant
     */
    public function setAtEase($atEase)
    {
        $this->atEase = $atEase;

        return $this;
    }

    /**
     * Get atEase
     *
     * @return string
     */
    public function getAtEase()
    {
        return $this->atEase;
    }

    /**
     * Set whereToReco
     *
     * @param string $whereToReco
     *
     * @return Participant
     */
    public function setWhereToReco($whereToReco)
    {
        $this->whereToReco = $whereToReco;

        return $this;
    }

    /**
     * Get whereToReco
     *
     * @return string
     */
    public function getWhereToReco()
    {
        return $this->whereToReco;
    }
}
