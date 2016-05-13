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

namespace WellCommerce\Bundle\SearchBundle\Indexer;

use Symfony\Component\Console\Output\OutputInterface;

/**
 * Interface ProductIndexerInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface IndexerInterface
{
    public function create();

    public function get();

    public function remove();

    public function erase();

    public function reindex();

    public function setConsoleOutput(OutputInterface $output);
}
