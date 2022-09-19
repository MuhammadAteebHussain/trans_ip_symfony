<?php


// src/Command/CreateUserCommand.php
namespace App\Command;

use App\Service\GenerateHashService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;


/**
 * UrlHasherCommand class
 * @package App\Listener\GenerateHashService
 * @author Ateeb <muhammad_ateeb_hussain@hotmail.com>
 */
class UrlHasherCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:generate-hash';
    protected static $defaultDescription = 'It will generate Hash When command executes';

    public function __construct(GenerateHashService $service)
    {
        // best practices recommend to call the parent constructor first and
        // then set your own properties. That wouldn't work in this case
        // because configure() needs the properties set in this constructor
        // $this->requirePassword = $requirePassword;
        
        $this->service = $service;

        parent::__construct();
    }

    /**
     * configure function
     *
     * @return void
     */
    protected function configure(): void
    {
        $this->setHelp('This command will take URL and then fetch create hash of URL response into a file');
       
    }


    /**
     * execute function
     * Note:- result it will asks some question  E.g URL format and file path 
     * where you want to store generated hash make sure file path correct 
     * other wise system will throw exception
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $helper = $this->getHelper('question');

        $url_question = new Question('Please enter the URL if you want multiple please add with comma seperated ', 'url');

        $url_answer = $helper->ask($input, $output, $url_question);

        $path_question = new Question('Please enter the Valid File Path?   ', 'path');

        $path_answer = $helper->ask($input, $output, $path_question);


        $output->writeln([
            'Hasher Send...',
            '============'
        ]);

        $data = array(
            'url' => $url_answer,
            'path' => $path_answer
        );

        $this->service->execute($data);
      

        return Command::SUCCESS;
    }
}
