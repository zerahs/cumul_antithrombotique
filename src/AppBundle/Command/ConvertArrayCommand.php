<?php
namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConvertArrayCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('app:convert-array')
            ->setDescription('Export a new csv converting php array format to string')
            ->addArgument('path', InputArgument::REQUIRED, 'The path to the csv file to convert')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $path = $input->getArgument('path');

        $fopen = fopen($path,"r");
        $fp = fopen('/Users/zerahs/Documents/combi-at/exports/export.csv','wa+');
        $i = 0;
        while( ($data = fgetcsv($fopen)) !== false){
            // var_dump($data);
            if($i==0){
                fputcsv($fp,$data);
                $i++;
                continue;
            }
            $index = 6;
            $array = unserialize($data[$index]);
            $string = implode(';',$array);
            $data[$index] = $string;
            fputcsv($fp,$data);
            $i++;
        }
        fclose($fopen);
        fclose($fp); 

        return;
    }
}