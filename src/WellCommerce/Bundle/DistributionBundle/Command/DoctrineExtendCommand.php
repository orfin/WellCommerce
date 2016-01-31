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

namespace WellCommerce\Bundle\DistributionBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\SplFileInfo;
use WellCommerce\Bundle\DistributionBundle\Console\Action\UpdateSchemaAction;
use WellCommerce\Bundle\DistributionBundle\Console\ConsoleActionExecutorInterface;
use WellCommerce\Bundle\DistributionBundle\Definition\MappingDefinition;
use WellCommerce\Bundle\DistributionBundle\Executor\DoctrineExtendExecutor;

/**
 * Class DoctrineExtendCommand
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DoctrineExtendCommand extends Command
{
    /**
     * @var DoctrineExtendExecutor
     */
    protected $doctrineExtendExecutor;

    /**
     * @var
     */
    protected $consoleActionExecutor;

    /**
     * DoctrineExtendCommand constructor.
     *
     * @param DoctrineExtendExecutor         $doctrineExtendExecutor
     * @param ConsoleActionExecutorInterface $consoleActionExecutor
     */
    public function __construct(DoctrineExtendExecutor $doctrineExtendExecutor, ConsoleActionExecutorInterface $consoleActionExecutor)
    {
        parent::__construct();
        $this->doctrineExtendExecutor = $doctrineExtendExecutor;
        $this->consoleActionExecutor  = $consoleActionExecutor;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('wellcommerce:doctrine:extend');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $mappings = $this->doctrineExtendExecutor->execute();
        $output->write(sprintf('Generated extra traits and mappings for <info>%s</info> classes.', $mappings->count()), true);
        $mappings->forAll(function (MappingDefinition $definition) use ($output) {
            $output->write(sprintf('<comment>%s</comment>', $definition->getClassName()), true);
        });
    }
}
