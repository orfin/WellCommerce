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
use WellCommerce\Bundle\DistributionBundle\Resolver\ConfigurationFileResolverInterface;
use WellCommerce\Bundle\DoctrineBundle\Helper\Doctrine\DoctrineHelperInterface;

/**
 * Class GenerateMetadataCommand
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class GenerateSerializationMetadataCommand extends Command
{
    /**
     * @var array
     */
    private $hiddenFields = ['createdAt', 'updatedAt', 'createdBy', 'updatedBy', 'deletedBy', 'password', 'salt'];

    /**
     * @var ConfigurationFileResolverInterface
     */
    private $resolver;

    /**
     * @var DoctrineHelperInterface
     */
    private $doctrineHelper;
    
    /**
     * @var array
     */
    private $mapping;
    
    /**
     * @var Filesystem
     */
    private $filesystem;
    
    /**
     * GenerateSerializationMetadataCommand constructor.
     *
     * @param ConfigurationFileResolverInterface $resolver
     * @param DoctrineHelperInterface            $doctrineHelper
     * @param array                              $mapping
     */
    public function __construct(ConfigurationFileResolverInterface $resolver, DoctrineHelperInterface $doctrineHelper, array $mapping = [])
    {
        parent::__construct();
        $this->resolver       = $resolver;
        $this->doctrineHelper = $doctrineHelper;
        $this->mapping        = $mapping;
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
        $force = true === $input->getOption('force');
        
        foreach ($this->mapping as $className => $options) {
            $metadata = $this->doctrineHelper->getClassMetadata($className);
            $this->dumpSerializationFile($metadata, $options, $output, $force);
        }
    }
    
    protected function dumpSerializationFile(ClassMetadata $metadata, array $options, OutputInterface $output, $force = false)
    {
        $targetPath = $this->resolver->resolvePath($options['mapping']);

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
    
    private function prepareMetadataAssociations(ClassMetadata $metadata)
    {
        $associations = [];
        foreach ($metadata->getAssociationNames() as $associationName) {
            $associations[$associationName]['groups'] = [Inflector::tableize($metadata->getReflectionClass()->getShortName())];
        }
        
        return $associations;
    }
}
