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
namespace WellCommerce\Core\Console\Command\Documentation;

use WellCommerce\Core\Console\Command\AbstractCommand;
use Symfony\Component\Console;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Sami\Sami;

/**
 * Class Generate
 *
 * @package WellCommerce\Core\Console\Command\Documentation
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Generate extends AbstractCommand
{

    protected function configure()
    {
        $this->setName('documentation:generate');

        $this->setDescription('Generates documentation');

        $this->setHelp(sprintf('%Generates documentation.%s', PHP_EOL, PHP_EOL));
    }

    /**
     * Executes documentation:generate command
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $iterator = $this->getFinder()->create()
            ->files()
            ->name('*.php')
            ->exclude('Resources')
            ->exclude('Tests')
            ->in(ROOTPATH . 'application');

        return new Sami($iterator, [
            'theme'                => 'symfony',
            'title'                => 'WellCommerce API',
            'build_dir'            => ROOTPATH . 'docs' . DS . 'build',
            'cache_dir'            => ROOTPATH . 'docs' . DS . 'cache',
            'default_opened_level' => 2,
        ]);
    }
}