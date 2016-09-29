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

namespace WellCommerce\Bundle\CoreBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use WellCommerce\Bundle\CoreBundle\Enhancer\TraitGenerator\TraitGeneratorEnhancerCollection;
use WellCommerce\Bundle\CoreBundle\Enhancer\TraitGenerator\TraitGeneratorEnhancerTraverserInterface;
use WellCommerce\Bundle\CoreBundle\Helper\Environment\EnvironmentHelperInterface;
use Wingu\OctopusCore\CodeGenerator\PHP\OOP\TraitGenerator;
use Wingu\OctopusCore\Reflection\ReflectionClass;

/**
 * Class GenerateEntityExtraCommand
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class GenerateEntityExtraCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setDescription('Generates extra trait classes for entities');
        $this->setName('wellcommerce:doctrine:generate-entity-extra');
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filesystem = new Filesystem();
        $collection = $this->getTraitGeneratorEnhancerCollection();
        $traits     = $collection->keys();
        $output->write('Enhancers: <info>' . $collection->count() . '</info>', true);
        foreach ($traits as $traitName) {
            $reflectionClass = new ReflectionClass($traitName);
            $output->write('Extending <info>' . $traitName . '</info> finished', true);
            $code = $this->generateTrait($reflectionClass);
            $filesystem->dumpFile($reflectionClass->getFileName(), $code);
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
        
        $process = $this->getEnvironmentHelper()->getProcess($arguments, 360);
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
        
        $process = $this->getEnvironmentHelper()->getProcess($arguments, 360);
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
        $this->getTraitGeneratorEnhancerTraverser()->traverse($generator);
        
        return '<?php' . str_repeat(PHP_EOL, 2) . $generator->generate();
    }
    
    private function getTraitGeneratorEnhancerCollection() : TraitGeneratorEnhancerCollection
    {
        return $this->getContainer()->get('doctrine.trait_generator.enhancer_collection');
    }
    
    private function getTraitGeneratorEnhancerTraverser() : TraitGeneratorEnhancerTraverserInterface
    {
        return $this->getContainer()->get('doctrine.trait_generator.enhancer_traverser');
    }
    
    private function getEnvironmentHelper() : EnvironmentHelperInterface
    {
        return $this->getContainer()->get('environment_helper');
    }
}
