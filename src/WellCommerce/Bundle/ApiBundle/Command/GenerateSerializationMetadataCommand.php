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

namespace WellCommerce\Bundle\ApiBundle\Command;

use Doctrine\Common\Inflector\Inflector;
use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Yaml;
use WellCommerce\Bundle\DoctrineBundle\Helper\Doctrine\DoctrineHelperInterface;

/**
 * Class GenerateMetadataCommand
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class GenerateSerializationMetadataCommand extends Command
{
    protected $hiddenFields = ['createdBy', 'updatedBy', 'deletedBy', 'password', 'salt'];
    
    /**
     * @var DoctrineHelperInterface
     */
    protected $doctrineHelper;
    
    /**
     * @var Filesystem
     */
    protected $filesystem;
    
    /**
     * GenerateMetadataCommand constructor.
     *
     * @param DoctrineHelperInterface $doctrineHelper
     */
    public function __construct(DoctrineHelperInterface $doctrineHelper)
    {
        parent::__construct();
        $this->doctrineHelper = $doctrineHelper;
        $this->filesystem     = new Filesystem();
    }
    
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setDescription('Generates serialization metadata for entities');
        $this->setName('api:generate:metadata');
        $this->addOption('force', null, InputOption::VALUE_NONE, 'Force to overwrite existing configuration files.');
    }
    
    /**
     * Executes the actions
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $metadataCollection = $this->doctrineHelper->getMetadataFactory()->getAllMetadata();
        $force              = true === $input->getOption('force');
        
        foreach ($metadataCollection as $entityMetadata) {
            $this->dumpSerializationFile($entityMetadata, $output, $force);
        }
    }
    
    protected function dumpSerializationFile(ClassMetadata $metadata, OutputInterface $output, $force = false)
    {
        $targetPath = $this->resolvePath($metadata->getReflectionClass());
        
        $config = [
            $metadata->getName() => [
                'fields'       => $this->prepareMetadataFields($metadata),
                'associations' => $this->prepareMetadataAssociations($metadata),
                'callbacks'    => [],
            ]
        ];
        
        $message = 'Dumped serialization config for <info>%s</info>';
        
        if ($force) {
            $this->filesystem->dumpFile($targetPath, Yaml::dump($config, 6));
        } else {
            if (false === $this->filesystem->exists($targetPath)) {
                $this->filesystem->dumpFile($targetPath, Yaml::dump($config, 6));
            } else {
                $message = 'Skipped dumping serialization config for <info>%s</info>';
            }
        }
        
        $output->write(sprintf($message, $metadata->getName()), true);
    }
    
    protected function prepareMetadataFields(ClassMetadata $metadata)
    {
        $fields = [];
        
        foreach ($metadata->getFieldNames() as $fieldName) {
            $groups = [];
            list($realName,) = explode('.', $fieldName);
            if (!in_array($realName, $this->hiddenFields)) {
                $groups = ['default', Inflector::tableize($metadata->getReflectionClass()->getShortName())];
            }
            $fields[$realName]['groups'] = $groups;
        }
        
        return $fields;
    }
    
    protected function prepareMetadataAssociations(ClassMetadata $metadata)
    {
        $associations = [];
        foreach ($metadata->getAssociationNames() as $associationName) {
            $associations[$associationName]['groups'] = [Inflector::tableize($metadata->getReflectionClass()->getShortName())];
        }
        
        return $associations;
    }
    
    protected function resolvePath(\ReflectionClass $reflectionClass)
    {
        return dirname($reflectionClass->getFileName()) . '/../Resources/config/serialization/' . $reflectionClass->getShortName() . '.yml';
    }
}
