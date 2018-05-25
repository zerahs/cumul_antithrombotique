<?php

namespace AppBundle\Manager;

use AppBundle\Repository\RandomizationIndexesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Serializer\SerializerInterface;

class RandomizationManager
{
    private $session;
    private $repo;
    private $randomizationDir;
    private $em;
    private $serializer;

    public function __construct($randomizationDir, SessionInterface $session, RandomizationIndexesRepository $repo, EntityManagerInterface $em, SerializerInterface $serializer)
    {
        $this->dir = $randomizationDir;
        $this->session = $session;
        $this->repo = $repo;
        $this->em = $em;
        $this->serializer = $serializer;
    }

    private function getIndexes()
    {
        return $this->repo->find(1);
    }


    private function getThenIncrementIndex($indexName)
    {
        $indexes = $this->getIndexes();
        $getter = 'get'.ucfirst($indexName);
        $index = $indexes->$getter();
        $setter = 'set'.ucfirst($indexName);
        $indexes->$setter($index+1);
        $this->em->persist($indexes);
        $this->em->flush();
        return $index;
    }

    private function randomize($indexName, $index)
    {
        $path = $this->dir.'/'.$indexName.'.csv';
        $data = $this->serializer->decode(file_get_contents($path), 'csv');
        $randomizationNumber = $data[$index]['NUMERO'];
        $randomizationGroup = $data[$index]['BRAS'];
        return [
            'number' => $randomizationNumber,
            'group' => $randomizationGroup,
        ];
    }

    public function randomizeCardio()
    {
        $index = $this->getThenIncrementIndex('cardio');
        return $this->randomize('cardio', $index);
    }

    public function randomizeMg()
    {
        $index = $this->getThenIncrementIndex('mg');
        return $this->randomize('mg', $index);
    }
}
