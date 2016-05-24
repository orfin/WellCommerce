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

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use WellCommerce\Bundle\ProductBundle\Repository\ProductRepositoryInterface;
use WellCommerce\Bundle\SearchBundle\Document\ProductDocument;
use WellCommerce\Bundle\SearchBundle\Manager\SearchEngineManager;

/**
 * Class ReindexProductsCommand
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class ReindexProductsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setDescription('Reindexes search data');
        $this->setName('wellcommerce:search:reindex-products');

        $this->addOption(
            'batch_size',
            null,
            InputOption::VALUE_REQUIRED,
            'Batch size',
            100
        );
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $batchSize     = $input->getOption('batch_size');
        $manager       = $this->getSearchEngineManager();
        $repository    = $this->getProductRepository();
        $totalProducts = $repository->getTotalCount();
        $iterations    = $this->getIterations($totalProducts, $batchSize);
        
        $output->writeln(sprintf('<comment>Total products:</comment> %s', $totalProducts));
        $output->writeln(sprintf('<comment>Batch size:</comment> %s', $batchSize));
        $output->writeln(sprintf('<comment>Iterations:</comment> %s', $iterations));
        
        $progress = new ProgressBar($output, $totalProducts);
        $progress->setFormat('verbose');
        $progress->setRedrawFrequency($batchSize);
        $progress->start();

        $manager->getAdapter()->flushIndex();

        for ($i = 0; $i < $iterations; $i++) {
            $products = $this->getProducts($i * $batchSize, $batchSize);
            $collection = new ArrayCollection();
            foreach ($products as $product) {
                $document = new ProductDocument($product);
                $collection->add($document);
                $progress->advance();
            }

            $manager->getAdapter()->addDocuments($collection);
        }

        $progress->finish();
        $manager->getAdapter()->optimizeIndex();
    }
    
    private function getIterations(int $total, int $batchSize) : int
    {
        return ceil($total / $batchSize);
    }
    
    private function getSearchEngineManager() : SearchEngineManager
    {
        return $this->getContainer()->get('search.engine.manager');
    }

    private function getProducts(int $firstResult, int $maxResults)
    {
        return $this->getProductRepository()->findBy(['enabled' => true], null, $maxResults, $firstResult);
    }

    private function getProductRepository() : ProductRepositoryInterface
    {
        return $this->getContainer()->get('product.repository');
    }
}
