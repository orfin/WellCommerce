<?php
/*
 * WellCommerce Open-Source E-Commerce Platform
 *
 * This file is part of the WellCommerce package.
 *
 * (c) Adam Piotrowski <adam@wellcommerce.org>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */
namespace WellCommerce\Core\Console\Command\Install;

use Illuminate\Database\Capsule\Manager;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use WellCommerce\Core\Console\Command\AbstractCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Database
 *
 * @package WellCommerce\Core\Console\Command\Install
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Database extends AbstractCommand
{

    protected function configure()
    {
        $this->setName('install:database');

        $this->setDescription('Creates and imports the database');

        $this->setDefinition([
            new InputArgument('host', InputArgument::OPTIONAL, 'Database host'),
            new InputArgument('database', InputArgument::OPTIONAL, 'Database name'),
            new InputArgument('username', InputArgument::OPTIONAL, 'Database username'),
            new InputArgument('password', InputArgument::OPTIONAL, 'Database password'),
        ]);

        $this->addOption('host', null, InputOption::VALUE_OPTIONAL, 'Database host');
        $this->addOption('database', null, InputOption::VALUE_OPTIONAL, 'Database name');
        $this->addOption('username', null, InputOption::VALUE_OPTIONAL, 'Database username');
        $this->addOption('password', null, InputOption::VALUE_OPTIONAL, 'Database password');

        $this->setHelp(sprintf('%Creates and imports the database.%s', PHP_EOL, PHP_EOL));
    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $dialog = $this->getHelper('dialog');

        $host = $dialog->ask(
            $output,
            'Please enter the database host [localhost]: ',
            'localhost'
        );

        $input->setArgument('host', $host);

        $database = $dialog->ask(
            $output,
            'Please enter the database name [wellcommerce]: ',
            'wellcommerce'
        );

        $input->setArgument('database', $database);

        $username = $dialog->ask(
            $output,
            'Please enter username [root]: ',
            'root'
        );

        $input->setArgument('username', $username);

        $password = $dialog->ask(
            $output,
            'Please enter password: ',
            ''
        );

        $input->setArgument('password', $password);
    }

    private function createDatabase($database)
    {
        $this->execute(
            sprintf(
                "CREATE DATABASE IF NOT EXISTS `%s` CHARACTER SET utf8",
                $dbName
            )
        );
    }

    /**
     * Executes install:database command
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $capsule = new Manager();

        $capsule->addConnection([
            'driver'    => 'mysql',
            'host'      => $input->getOption('host'),
            'database'  => $input->getOption('database'),
            'username'  => $input->getOption('username'),
            'password'  => $input->getOption('password'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]);

        $capsule->setAsGlobal();
    }
}