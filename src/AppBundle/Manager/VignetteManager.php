<?php

namespace AppBundle\Manager;

use AppBundle\Model\Vignette;
use AppBundle\Repository\AnswerRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class VignetteManager
{
    private $vignette;
    private $questionId;
    private $vignetteId;
    private $participantId;
    private $session;
    private $answerRepository;

    public function __construct(Vignette $vignette, SessionInterface $session, AnswerRepository $answerRepository)
    {
        $this->vignette = $vignette;
        $this->session = $session;
        $this->answerRepository = $answerRepository;
        $this->init();
    }

    private function init()
    {
        $this->loadVignette();
        $this->questionId = $this->session->get('question_id', 0);
        $this->participantId = $this->session->get('participant_id'); 
    }

    public function getVignetteId()
    {
        return $this->vignetteId;
    }

    public function loadVignette()
    {
        $this->vignetteId = $this->session->get('vignette_id');
        // TODO remove this when all vignette jsons are loaded
        $this->vignetteId = 29;
        $this->vignette->load($this->vignetteId);
    }

    public function getVignette()
    {
        return $this->vignette;
    }

    public function getQuestionData()
    {
        $questionData = $this->vignette->getQuestionData($this->questionId);
        // Load next question if this question should not appear
        if(!$this->questionShouldAppear($questionData)){
            $this->loadNextQuestion();
            return $this->getQuestionData();
        }
        return $questionData;
    }

    public function questionIsMultiple()
    {
        return isset($this->getQuestionData()["multiple"]) ? false : true;
    }

    public function answerIsValid($answer)
    {
        $valid = $this->getQuestionData()['valid'];
        if( !empty($valid) && is_array($valid[0]) ){
            return in_array($answer, $valid);
        }
        return $valid == $answer;
    }

    public function loadNextQuestion()
    {
        $this->questionId += 1;
        $this->session->set('question_id', $this->questionId);
    }

    private function questionShouldAppear($questionData)
    {
        if( in_array($questionData['ref'], ['1','5']))
        {
            return true;
        }

        // If answer to question 1 is 0, go to question 5
        $answer1 = $this->answerRepository->findOneBy([
            'vignetteId' => $this->vignetteId,
            'questionRef' => '1',
            'participant' => $this->participantId,
        ]);
        if( $answer1->getData() == ['0'] ){
            return false;
        }

        // Question 3 is conditional to question 2
        if(strpos($questionData['ref'], '3') === false) {
            return true;
        }

        // Get answer number for question 2 corresponding to this question (3a=>0, ..., 3e => 4)
        $letter = strtolower(substr($questionData['ref'], -1));
        $number = ord($letter) - 97;

        // Get answer to question 2
        $answer2 = $this->answerRepository->findOneBy([
            'vignetteId' => $this->vignetteId,
            'questionRef' => '2',
            'participant' => $this->participantId,
        ]);

        // Question should appear
        if(in_array($number, $answer2->getData())){
            return true;
        }

        return false;   
    }


}
