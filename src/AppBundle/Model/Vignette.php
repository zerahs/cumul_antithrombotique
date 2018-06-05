<?php

namespace AppBundle\Model;

class Vignette
{
    private $dir;
    private $json;


    public function __construct($vignettesDir)
    {
        $this->dir = $vignettesDir;
    }

    public function load($id)
    {
        $path = $this->dir."/".$id.".json";
        $vignette = file_get_contents($path);
        $this->json = json_decode($vignette, true);
    }

    public function getDescription()
    {
        return $this->json['description'];
    }

    public function getQuestions()
    {
        return $this->json["questions"];
    }

    public function getQuestionData($id)
    {
        return $this->getQuestions()[$id];
    }

}
