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

namespace WellCommerce\Bundle\ProductBundle\Command;

use Symfony\Component\Console\Input\InputOption;
use WellCommerce\Bundle\DoctrineBundle\Repository\RepositoryInterface;
use WellCommerce\Bundle\SearchBundle\Command\AbstractReindexCommand;
use WellCommerce\Bundle\SearchBundle\Type\IndexTypeInterface;

/**
 * Class ReindexProductCommand
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ReindexProductCommand extends AbstractReindexCommand
{
    protected function configure()
    {
        parent::configure();
        $this->setName('wellcommerce:search:product-reindex');
    }

    protected function getRepository() : RepositoryInterface
    {
        // TODO: Implement getRepository() method.
    }
    
    protected function getIndexType() : IndexTypeInterface
    {
        // TODO: Implement getIndexType() method.
    }
}
