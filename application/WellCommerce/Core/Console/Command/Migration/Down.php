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
namespace WellCommerce\Core\Console\Command\Migration;

use WellCommerce\Core\Console\Command\AbstractCommand;
use Symfony\Component\Console;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Down
 *
 * @package WellCommerce\Core\Console\Command\Migration
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Down extends AbstractCommand
{

    protected function configure()
    {
        $this->setName('migration:down');

        $this->setDescription('Executes migration classes');

        $this->setHelp(sprintf('%Executes "down" command in migration classes.%s', PHP_EOL, PHP_EOL));
    }

    /**
     * Executes migration:down command
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $files = $this->getFinder()->files()->in($this->getMigrationClassesPath());

        foreach ($files as $file) {
            $migrationClass = '\\WellCommerce\\Core\\Migration\\' . $file->getBasename('.php');
            $migrationObj   = new $migrationClass();
            $migrationObj->down();
        }
    }
}