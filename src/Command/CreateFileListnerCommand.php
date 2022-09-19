<?php

namespace App\Command;

use App\Listener\CreateFileListner;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;



class CreateFileListnerCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:create-file';
    protected static $defaultDescription = 'It will create file';
    protected $listner;

    public function __construct(CreateFileListner $listner)
    {
        // best practices recommend to call the parent constructor first and
        // then set your own properties. That wouldn't work in this case
        // because configure() needs the properties set in this constructor
        // $this->requirePassword = $requirePassword;
        $this->listner = $listner;

        parent::__construct();
    }


    protected function configure(): void
    {
        $this->setHelp('This will genrate hash file');
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $output->writeln([
            'File creeating',
            '============',
            '',
        ]);

        $this->listner->listen();
        return Command::SUCCESS;
    }
}
