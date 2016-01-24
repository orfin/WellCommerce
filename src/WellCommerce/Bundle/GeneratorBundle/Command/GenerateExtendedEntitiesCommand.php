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

namespace WellCommerce\Bundle\GeneratorBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Yaml;
use WellCommerce\Bundle\GeneratorBundle\Resolver\ExtraMappingResolver;
use Wingu\OctopusCore\CodeGenerator\PHP\OOP\ClassGenerator;
use Wingu\OctopusCore\CodeGenerator\PHP\OOP\Modifiers;
use Wingu\OctopusCore\CodeGenerator\PHP\OOP\PropertyGenerator;
use Wingu\OctopusCore\Reflection\ReflectionClass;

/**
 * Class GenerateExtendedEntitiesCommand
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class GenerateExtendedEntitiesCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setDescription('Generates the extension classes for entities');
        $this->setName('wellcommerce:generate:extended-entities');
    }

    /**
     * Executes the command
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $extraMappingResolver = new ExtraMappingResolver();
        $extraMapping         = $extraMappingResolver->resolve();
        $entityGenerator      = $this->getContainer()->get('generator.extended_entity.generator');

        foreach ($extraMapping as $extraMappingClass => $extraMappingContent) {
            $reflectionClass = new ReflectionClass($extraMappingClass);
            $output->writeln('<info>' . $reflectionClass->getShortName() . '</info>');
            $generatedCode = $entityGenerator->generateExtendedEntity($reflectionClass, $extraMappingContent);
        }

        die();

        file_put_contents('app/config/generated/mappings.yml', Yaml::dump($extraMapping, 6));
        die();
        die();

        $this->getContainer()->get('generator.merger.doctrine_mapping')->merge();
        die();

        $bundles           = $this->getContainer()->get('kernel')->getBundles();
        $allowedExtensions = [];

        /** @var $bundle \Symfony\Component\HttpKernel\Bundle\BundleInterface */
        foreach ($bundles as $bundle) {
            $extension = $bundle->getContainerExtension();
            if ($extension instanceof ExtensionInterface) {
                $extensionReflection = new ReflectionClass($extension);
                if ($extensionReflection->hasConstant('EXTENSION_NAME')) {
                    $allowedExtensions[] = $extensionReflection->getConstant('EXTENSION_NAME');
                }
            }
        }

        $finder = new Finder();
        $finder->name('wellcommerce.yml');
        $files         = $finder->in('src/*/*/*/Resources/config');
        $configuration = [];

        foreach ($finder->in('src/*/*/*/Resources/config') as $file) {
            $contents = $file->getContents();
            $yaml     = Yaml::parse($contents);
            if (is_array($yaml)) {
                $treeRoot = current(array_keys($yaml));
                if (in_array($treeRoot, $allowedExtensions) && isset($yaml[$treeRoot]['services'])) {
                    $configuration = array_replace_recursive($configuration, $yaml);
                }
            }
        }

        file_put_contents('app/config/generated/extensions.yml', Yaml::dump($configuration, 6));
        die();

        print_r($configuration);

        die();

        $cg = new ClassGenerator('myClass', 'MyTests\MyNamespace');
        $cg->setAbstract(true);
        $cg->setExtends('c1');
        $cg->setImplements(['i1', 'i2']);

        $properties   = [];
        $properties[] = new PropertyGenerator('publicProperty');
        $properties[] = new PropertyGenerator('protectedProperty', 1, Modifiers::MODIFIER_PROTECTED);
        $properties[] = new PropertyGenerator('privateProperty', 'private', Modifiers::MODIFIER_PRIVATE);
        $cg->setProperties($properties);

        echo $cg;

        die();

//        $generator     = new EntitiesExtraGenerator();
//        $finder        = new ExtraMappingFinder();
//        $extraMappings = $finder->getExtraMappings();
//        $traitAnalyzer = new TraitAnalyzer();
//
//        foreach ($extraMappings as $className => $extraMapping) {
//            $reflectionClass = new \ReflectionClass($className);
//            $shortName       = $reflectionClass->getShortName();
//
//            if (false === $traitAnalyzer->hasEntityExtraTrait($reflectionClass)) {
//                $output->write('Skipped generation for <error>' . $shortName . '</error>. No corresponding trait was found', true);
//            } else {
//                $generator->generateEntityExtra($reflectionClass, $extraMapping);
//                $output->write('Generating extra fields for <info>' . $shortName . '</info> entity', true);
//            }
//        }
    }
}
