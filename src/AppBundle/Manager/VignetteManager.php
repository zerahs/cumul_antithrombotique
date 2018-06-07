<?php

namespace AppBundle\Manager;

use AppBundle\Model\Vignette;
use AppBundle\Repository\AnswerRepository;
use AppBundle\Repository\ParticipantRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class VignetteManager
{

    const MAX_QUESTION_ID = 8;
    const MAX_VIGNETTES_NB = 3;

    private $vignette;
    private $questionId;
    private $vignetteId;
    private $vignetteKey;
    private $participantId;
    private $session;
    private $answerRepository;
    private $participantRepository;

    public function __construct(Vignette $vignette, SessionInterface $session, AnswerRepository $answerRepository, ParticipantRepository $participantRepository)
    {
        $this->vignette = $vignette;
        $this->session = $session;
        $this->answerRepository = $answerRepository;
        $this->participantRepository = $participantRepository;
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
        $this->vignetteKey = $this->session->get('vignette_key');
        $this->vignette->load($this->vignetteId);
    }

    public function getVignetteKey()
    {
        return $this->vignetteKey;
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
        // Last question
        if($this->questionId >= self::MAX_QUESTION_ID){
            // @TODO THE END
            if($this->vignetteKey >= self::MAX_VIGNETTES_NB -1){
                $this->session->clear();
                return 'END';
            }
            // Set next vignette
            $participant = $this->participantRepository->find($this->participantId);
            $numbers = $participant->getVignetteNumbers();
            $this->vignetteKey += 1;
            $this->session->set('vignette_key', $this->vignetteKey);
            $this->vignetteId = $numbers[$this->vignetteKey];
            $this->session->set('vignette_id', $this->vignetteId);
            // Set to first question
            $this->questionId = 0;
            $this->session->set('question_id', $this->questionId);
            return 'NEXT_VIGNETTE';
        }

        // Or just next question
        $this->questionId += 1;
        $this->session->set('question_id', $this->questionId);
        return 'NEXT_QUESTION';
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
