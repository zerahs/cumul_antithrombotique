<?php

namespace AppBundle\Manager;

use AppBundle\Repository\RandomizationIndexesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Asset\Exception\LogicException;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Serializer\SerializerInterface;

class RandomizationManager
{
    private $session;
    private $repo;
    private $randomizationDir;
    private $em;
    private $serializer;

    const GROUP_CONTROL = 'A';
    const GROUP_TOOL = 'B';

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

    private function getThenIncrementIndex($indexName, $increment=1)
    {
        $indexes = $this->getIndexes();
        $getter = 'get'.ucfirst($indexName);
        $index = $indexes->$getter();
        $setter = 'set'.ucfirst($indexName);
        $indexes->$setter($index + $increment);
        $this->em->persist($indexes);
        $this->em->flush();
        return $index;
    }

    private function getCsv($indexName)
    {
        $path = $this->dir.'/'.$indexName.'.csv';
        return $this->serializer->decode(file_get_contents($path), 'csv');
    }

    private function randomizeGroup($indexName, $index)
    {
        $data = $this->getCsv($indexName);
        $randomizationNumber = $data[$index]['NUMERO'];
        $randomizationGroup = $data[$index]['BRAS'];
        return [
            'number' => $randomizationNumber,
            'group' => $randomizationGroup,
        ];
    }

    private function randomizeVignettes($indexName, $index)
    {
        $data = $this->getCsv($indexName);
        $numbers = [
            $data[$index]['NUMERO_VIGNETTE'],
            $data[$index+1]['NUMERO_VIGNETTE'],
            $data[$index+2]['NUMERO_VIGNETTE'],
        ];
        return $numbers;
    }

    public function randomizeCardio()
    {
        $index = $this->getThenIncrementIndex('cardio');
        return $this->randomizeGroup('cardio', $index);
    }

    public function randomizeMg()
    {
        $index = $this->getThenIncrementIndex('mg');
        return $this->randomizeGroup('mg', $index);
    }

    public function randomizeVignettesByGroup($group)
    {
        if($group == self::GROUP_CONTROL){
            $indexName = 'control';
        }
        elseif($group == self::GROUP_TOOL){
            $indexName = 'tool';
        }
        else{
            throw new LogicException('wrong group');
        }
        $index = $this->getThenIncrementIndex($indexName, 3);
        return $this->randomizeVignettes($indexName, $index);
    }
}
