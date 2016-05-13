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

namespace WellCommerce\Bundle\SearchBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use WellCommerce\Bundle\SearchBundle\Manager\SearchManagerInterface;

/**
 * Class ReindexProductsCommand
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ReindexProductsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setDescription('Reindexes search data');
        $this->setName('wellcommerce:search:reindex');
        $this->addArgument(
            'index',
            InputArgument::REQUIRED,
            'Index name'
        );
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $index   = $input->getArgument('index');
        $manager = $this->getSearchManager($index);
        $manager->getIndexer()->setConsoleOutput($output);
        $manager->reindex();
        
        $output->write('<info>Reindexing done.</info>', true);
    }
    
    private function getSearchManager(string $index) : SearchManagerInterface
    {
        if (false === $this->getContainer()->has('search.manager.' . $index)) {
            throw new \InvalidArgumentException('Search manager for given index does not exists');
        }
        
        return $this->getContainer()->get('search.manager.' . $index);
    }
}
