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

use Doctrine\Common\Collections\Criteria;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use WellCommerce\Bundle\DoctrineBundle\Entity\EntityInterface;
use WellCommerce\Bundle\SearchBundle\Document\DocumentInterface;
use WellCommerce\Bundle\SearchBundle\Manager\IndexManager;

/**
 * Class ReindexCommand
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class ReindexCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setDescription('Reindexes search data');
        $this->setName('wellcommerce:search:reindex');

        $this->addOption(
            'index',
            null,
            InputOption::VALUE_REQUIRED,
            'Index name',
            'product'
        );

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
        $indexName      = $input->getOption('index');
        $batchSize      = $input->getOption('batch_size');
        $indexManager   = $this->getIndexManager($indexName);
        $totalDocuments = $indexManager->getTotalEntities();
        $iterations     = $this->getIterations($totalDocuments, $batchSize);
        
        $output->writeln(sprintf('<info>Reindexing</info> "%s"', $indexName));
        $output->writeln(sprintf('<comment>Total documents:</comment> %s', $totalDocuments));
        $output->writeln(sprintf('<comment>Batch size:</comment> %s', $batchSize));
        $output->writeln(sprintf('<comment>Iterations:</comment> %s', $iterations));
        
        $progress = new ProgressBar($output, $totalDocuments);
        $progress->setFormat('verbose');
        $progress->setRedrawFrequency($batchSize);
        $progress->start();
        
        $indexManager->purgeIndex();

        for ($i = 0; $i < $iterations; $i++) {
            $criteria = new Criteria();
            $criteria->setMaxResults($batchSize);
            $criteria->setFirstResult($i * $batchSize);
            $collection = $indexManager->getEntitiesCollection($criteria);
            $collection->map(function (EntityInterface $entity) use ($indexManager, $progress) {
                $indexManager->addEntity($entity);
                $progress->advance();
            });
        }

        $progress->finish();
        $output->writeln('');

        $output->writeln(sprintf('<info>Optimizing "%s"</info>', $indexName));
        $indexManager->optimizeIndex();
    }
    
    private function getIterations(int $total, int $batchSize) : int
    {
        return ceil($total / $batchSize);
    }
    
    private function getIndexManager(string $indexName) : IndexManager
    {
        $serviceId = $indexName . '.index.manager';
        
        if (false === $this->getContainer()->has($serviceId)) {
            throw new InvalidArgumentException(sprintf('Wrong index "%s" was given', $indexName));
        }
        
        return $this->getContainer()->get($serviceId);
    }
}
