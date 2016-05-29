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
use WellCommerce\Bundle\LocaleBundle\Entity\LocaleInterface;
use WellCommerce\Bundle\SearchBundle\Manager\SearchManagerInterface;
use WellCommerce\Component\Search\Model\TypeInterface;

/**
 * Class ReindexCommand
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class ReindexCommand extends ContainerAwareCommand
{
    /**
     * @var TypeInterface
     */
    private $type;

    /**
     * @var int
     */
    private $batchSize;

    /**
     * @var RepositoryInterface
     */
    private $repository;

    /**
     * @var SearchManagerInterface
     */
    private $manager;

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

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->manager    = $this->getSearchManager();
        $this->type       = $this->manager->getType($input->getOption('type'));
        $this->batchSize  = $input->getOption('batch');
        $this->repository = $this->getRepository($input->getOption('repository'));
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getLocales()->map(function (LocaleInterface $locale) use ($output) {
            $output->writeln(sprintf('<info>Reindexing locale:</info> %s', $locale->getCode()));
            $this->reindex($locale->getCode(), $output);
        });
    }

    private function reindex(string $locale, OutputInterface $output)
    {
        $totalEntities = $this->repository->getTotalCount();
        $iterations    = $this->getIterations($totalEntities, $this->batchSize);

        $output->writeln(sprintf('<comment>Total entities:</comment> %s', $totalEntities));
        $output->writeln(sprintf('<comment>Batch size:</comment> %s', $this->batchSize));
        $output->writeln(sprintf('<comment>Iterations:</comment> %s', count($iterations)));
        $output->writeln(sprintf('<comment>Locale:</comment> %s', $locale));

        $output->writeln('<info>Flushing index</info>');
        $this->manager->flushIndex($locale);

        $progress = new ProgressBar($output, $totalEntities);
        $progress->setFormat('verbose');
        $progress->setRedrawFrequency($this->batchSize);
        $progress->start();

        foreach ($iterations as $iteration) {
            $entities = $this->getEntities($iteration);
            foreach ($entities as $entity) {
                $document = $this->type->createDocument($entity, $locale);
                $this->manager->addDocument($document);
                $progress->advance();
            }
        }

        $progress->finish();
        $output->writeln('');
        $output->writeln('<info>Optimizing index</info>');
        $this->manager->optimizeIndex($locale);
    }

    private function getEntities(int $iteration) : array
    {
        return $this->repository->findBy([], null, $this->batchSize, $iteration * $this->batchSize);
    }

    private function getLocales() : Collection
    {
        return $this->getContainer()->get('locale.repository')->matching(new Criteria());
    }
    
    private function getRepository(string $serviceId) : RepositoryInterface
    {
        if (false === $this->getContainer()->has($serviceId)) {
            return $this->getContainer()->get($this->type->getName() . '.repository');
        }

        return $this->getContainer()->get($serviceId);
    }
    
    private function getIterations(int $total, int $batchSize) : array
    {
        return range(0, ceil($total / $batchSize));
    }
    
    private function getSearchManager() : SearchManagerInterface
    {
        return $this->getContainer()->get('search.manager');
    }
}
