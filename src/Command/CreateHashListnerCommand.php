<?php

namespace App\Command;

use App\Listener\GenerateHashListner;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


/**
 * CreateHashListnerCommand class
 * @package App\Listener\GenerateHashListner
 * @author Ateeb <muhammad_ateeb_hussain@hotmail.com>
 */
class CreateHashListnerCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:create-hash-listen';
    protected static $defaultDescription = 'It will start hash process by queue';
    protected $listner;

    public function __construct(GenerateHashListner $listner)
    {
        // best practices recommend to call the parent constructor first and
        // then set your own properties. That wouldn't work in this case
        // because configure() needs the properties set in this constructor
        $this->listner = $listner;

        parent::__construct();
    }

    /**
     * configure function
     *
     * @return void
     */
    protected function configure(): void
    {
        $this->setHelp('This will genrate hash file');
    }

    /**
     * execute function
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return integer
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $output->writeln([
            'hash creeating',
            '============',
            '',
        ]);

        $this->listner->listen();
        return Command::SUCCESS;
    }
}
