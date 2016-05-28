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

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use WellCommerce\Bundle\DoctrineBundle\Repository\RepositoryInterface;
use WellCommerce\Bundle\SearchBundle\Manager\SearchManagerInterface;

/**
 * Class ReindexCommand
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class ReindexCommand extends ContainerAwareCommand
{
    /**
     * @var string
     */
    private $defaultLocale;

    /**
     * ReindexCommand constructor.
     *
     * @param string $defaultLocale
     */
    public function __construct(string $defaultLocale)
    {
        $this->defaultLocale = $defaultLocale;
        parent::__construct(null);
    }

    protected function configure()
    {
        $this->setDescription('Reindexes search types');
        $this->setName('wellcommerce:search:reindex');
        
        $this->addOption(
            'type',
            null,
            InputOption::VALUE_REQUIRED,
            'Index type',
            'product'
        );

        $this->addOption(
            'batch',
            null,
            InputOption::VALUE_REQUIRED,
            'Batch size',
            100
        );

        $this->addOption(
            'repository',
            null,
            InputOption::VALUE_REQUIRED,
            'Repository service',
            'product.repository'
        );
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $type          = $input->getOption('type');
        $batchSize     = $input->getOption('batch');
        $manager       = $this->getSearchManager();
        $adapter       = $manager->getAdapter();
        $indexName     = $adapter->getIndexName($locale);
        $indexType     = $manager->getIndexType($type);
        $repository    = $this->getRepository($input->getOption('repository'));
        $totalEntities = $repository->getTotalCount();
        $iterations    = $this->getIterations($repository->getTotalCount(), $batchSize);
        
        $output->writeln(sprintf('<comment>Total entities:</comment> %s', $totalEntities));
        $output->writeln(sprintf('<comment>Batch size:</comment> %s', $batchSize));
        $output->writeln(sprintf('<comment>Iterations:</comment> %s', $iterations));
        $output->writeln(sprintf('<comment>Locale:</comment> %s', $locale));
        
        $output->writeln(sprintf('<info>Flushing index: </info> %s', $indexName));
        $manager->getAdapter()->flushIndex($locale);

        $output->writeln(sprintf('<info>Reindexing index: </info> %s', $indexName));
        
        $progress = new ProgressBar($output, $totalEntities);
        $progress->setFormat('verbose');
        $progress->setRedrawFrequency($batchSize);
        $progress->start();
        
        for ($i = 0; $i < $iterations; $i++) {
            $entities = $repository->findBy([], null, $batchSize, $i * $batchSize);
            foreach ($entities as $entity) {
                $manager->addEntity($entity, $indexType, $locale);
                $progress->advance();
            }
        }
        
        $progress->finish();
        $output->writeln('');
        $output->writeln(sprintf('<info>Optimizing index: </info> %s', $indexName));
        $adapter->optimizeIndex($locale);
    }
    
    private function getLocales() : Collection
    {
        return $this->getContainer()->get('locale.repository')->matching(new Criteria());
    }

    private function getRepository(string $serviceId) : RepositoryInterface
    {
        return $this->getContainer()->get($serviceId);
    }
    
    private function getIterations(int $total, int $batchSize) : int
    {
        return ceil($total / $batchSize);
    }
    
    private function getSearchManager() : SearchManagerInterface
    {
        return $this->getContainer()->get('search.manager');
    }
}
