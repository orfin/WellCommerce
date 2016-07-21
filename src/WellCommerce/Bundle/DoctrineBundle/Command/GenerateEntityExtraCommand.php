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

namespace WellCommerce\Bundle\DoctrineBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use WellCommerce\Bundle\CoreBundle\Helper\Environment\EnvironmentHelperInterface;
use WellCommerce\Bundle\DoctrineBundle\Enhancer\TraitGenerator\TraitGeneratorEnhancerCollection;
use WellCommerce\Bundle\DoctrineBundle\Enhancer\TraitGenerator\TraitGeneratorEnhancerTraverserInterface;
use Wingu\OctopusCore\CodeGenerator\PHP\OOP\TraitGenerator;
use Wingu\OctopusCore\Reflection\ReflectionClass;

/**
 * Class GenerateEntityExtraCommand
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class GenerateEntityExtraCommand extends ContainerAwareCommand
{
    /**
     * @var TraitGeneratorEnhancerCollection
     */
    protected $collection;
    
    /**
     * @var TraitGeneratorEnhancerTraverserInterface
     */
    protected $traverser;
    
    /**
     * @var Filesystem
     */
    protected $filesystem;
    
    /**
     * @var EnvironmentHelperInterface
     */
    protected $environmentHelper;
    
    /**
     * GenerateEntityExtraCommand constructor.
     *
     * @param TraitGeneratorEnhancerCollection         $collection
     * @param TraitGeneratorEnhancerTraverserInterface $traverser
     * @param EnvironmentHelperInterface               $environmentHelper
     */
//    public function __construct(
//        TraitGeneratorEnhancerCollection $collection,
//        TraitGeneratorEnhancerTraverserInterface $traverser,
//        EnvironmentHelperInterface $environmentHelper
//    ) {
//        parent::__construct();
//        $this->collection        = $collection;
//        $this->traverser         = $traverser;
//        $this->filesystem        = new Filesystem();
//        $this->environmentHelper = $environmentHelper;
//    }
    
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setDescription('Generates extra trait classes for entities');
        $this->setName('wellcommerce:doctrine:generate-entity-extra');
    }
    
    /**
     * Executes the command
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $traits = $this->collection->keys();
        $output->write('Enhancers: <info>' . $this->collection->count() . '</info>', true);
        foreach ($traits as $traitName) {
            $reflectionClass = new ReflectionClass($traitName);
            $output->write('Extending <info>' . $traitName . '</info> finished', true);
            $code = $this->generateTrait($reflectionClass);
            $this->filesystem->dumpFile($reflectionClass->getFileName(), $code);
        }
        
        $this->executeMetadataCacheClear($output);
        $this->executeSchemaUpdate($output);
    }
    
    /**
     * Executes the cache clear through separate process
     *
     * @param OutputInterface $output
     */
    protected function executeMetadataCacheClear(OutputInterface $output)
    {
        $arguments = [
            'app/console',
            'doctrine:cache:clear-metadata'
        ];
        
        $process = $this->environmentHelper->getProcess($arguments, 360);
        $process->run();
        $output->write($process->getOutput());
    }
    
    /**
     * Executes the schema update through separate process
     *
     * @param OutputInterface $output
     */
    protected function executeSchemaUpdate(OutputInterface $output)
    {
        $arguments = [
            'app/console',
            'doctrine:schema:update',
            '--force'
        ];
        
        $process = $this->environmentHelper->getProcess($arguments, 360);
        $process->run();
        $output->write($process->getOutput());
    }
    
    /**
     * Generates a trait class
     *
     * @param ReflectionClass $reflectionClass
     *
     * @return string
     */
    protected function generateTrait(ReflectionClass $reflectionClass) : string
    {
        $generator = new TraitGenerator($reflectionClass->getShortName(), $reflectionClass->getNamespaceName());
        $this->traverser->traverse($generator);
        
        return '<?php' . str_repeat(PHP_EOL, 2) . $generator->generate();
    }
    
    private function getTraitGeneratorEnhancer() : TraitGeneratorEnhancerTraverserInterface
    {
        
    }
}
