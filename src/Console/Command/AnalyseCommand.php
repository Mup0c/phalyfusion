<?php


namespace Phalyfusion\Console\Command;

use Nette\Neon\Exception as NeonException;
use Nette\Neon\Neon;
use Phalyfusion\Core;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class AnalyseCommand
 * Default and main command of the tool
 * @package Phalyfusion\Console\Command
 */
class AnalyseCommand extends Command
{

    /**
     * Path to the root directory of the tool
     * @var string
     */
    private string $rootDir;

    /**
     * AnalyseCommand constructor.
     * @param string $rootDir
     */
    public function __construct(string $rootDir)
    {
        $this->rootDir = $rootDir;
        parent::__construct();
    }

    /**
     * Called after constructor.
     */
    protected function configure()
    {
        $this
            ->setName('analyse')
            ->setDescription('Initiate analysis.')
            ->setHelp('This command will execute analysers stated in config file')
            ->addOption(
                'config',
                'c',
                InputOption::VALUE_REQUIRED,
                'Path to neon config file. phalyfusion.neon located in project root is used by default.',
                $this->rootDir . '/phalyfusion.neon' #TODO: we really dont want to use rootDir (при подключении этой тулзы в другой проект конфиг будет в жопе vendor)
            );
    }

    /**
     * Called on tool run
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->setDecorated(true);

        $config = $this->readConfig($input, $output);
        $usedPlugins = $config["plugins"]["usePlugins"];
        $runCommands = $config["plugins"]["runCommands"];
        $core = new Core($this->rootDir, $usedPlugins, $runCommands);
        var_dump($core->runPlugins());
        #$output->writeln("OMG ANALYSED&!&!&");
        #$output->writeln($input->getOption('config'));
        return 0;
    }

    /**
     * Parse config file
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return array decoded Neon config
     */
    private function readConfig(InputInterface $input, OutputInterface $output): array #TODO: nice error output
    {
        $configFile = $input->getOption('config');
        if (!file_exists($configFile))
        {
            $output->writeln("<error>Config not found at $configFile</error>");
            exit(1);
        }
        $neon = file_get_contents($configFile);
        try {
            $decoded = Neon::decode($neon);
        } catch (NeonException $e) {
            $output->writeln(["<error>Failed parsing config ($configFile)</error>", "Error: $e"]);
            exit(1);
        }

        return $decoded;
    }

}