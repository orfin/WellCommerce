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
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ReindexProductsCommand
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ReindexProductsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setDescription('Reindexes all products');
        $this->setName('wellcommerce:search:reindex-products');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $indexer = $this->getContainer()->get('search.indexer');
        $indexer->reindexProducts();

        $output->write('Reindexing done.', true);
    }
}
