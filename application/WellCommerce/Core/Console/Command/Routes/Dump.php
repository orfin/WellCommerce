<?php

namespace WellCommerce\Core\Console\Command\Routes;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\XmlFileLoader;
use WellCommerce\Core\Console\Command\AbstractCommand;
use Symfony\Component\Console;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Routing\Matcher\Dumper\PhpMatcherDumper;
use Symfony\Component\Routing\Generator\Dumper\PhpGeneratorDumper;
use Symfony\Component\Routing\RouteCollection;

/**
 * Class Dump
 *
 * @package WellCommerce\Core\Console\Command\Routes
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Dump extends AbstractCommand
{
    protected function configure()
    {
        $this->setName('routes:dump');

        $this->setDescription('Dumps routes into one optimized file');

        $this->setHelp(sprintf('%Dumps routes into one optimized file.%s', PHP_EOL, PHP_EOL));
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $rootCollection = new RouteCollection();
        $files          = $this->getFinder()->files()->in(ROOTPATH . 'application')->name('routing.xml');

        foreach ($files as $file) {
            $locator    = new FileLocator(array($file->getPath()));
            $loader     = new XmlFileLoader($locator);
            $collection = $loader->load('routing.xml');
            $rootCollection->addCollection($collection);
        }

        $dumper = new PhpGeneratorDumper($rootCollection);
        $this->getFilesystem()->dumpFile(ROOTPATH . 'var' . DS . 'WellCommerceUrlGenerator.php', $dumper->dump(Array(
            'class' => 'WellCommerceUrlGenerator'
        )));

        $dumper = new PhpMatcherDumper($rootCollection);
        $this->getFilesystem()->dumpFile(ROOTPATH . 'var' . DS . 'WellCommerceUrlMatcher.php', $dumper->dump(Array(
            'class' => 'WellCommerceUrlMatcher'
        )));

        $out = sprintf('%sFinished dumping routes.%s', PHP_EOL, PHP_EOL);

        $output->write($out);
    }
}