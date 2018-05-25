<?php

namespace AppBundle\Model;

class Vignette
{
    // private $participant;
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

    public function getJson()
    {
        return $this->json;
    }

}
