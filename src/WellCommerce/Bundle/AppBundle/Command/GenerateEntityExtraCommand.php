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

namespace WellCommerce\Bundle\AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;
use WellCommerce\Bundle\AppBundle\Doctrine\Generator\EntitiesExtraGenerator;
use WellCommerce\Bundle\AppBundle\Doctrine\Generator\ExtraMappingFinder;
use WellCommerce\Bundle\AppBundle\Doctrine\Generator\TraitAnalyzer;

/**
 * Class GenerateEntityExtraCommand
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class GenerateEntityExtraCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setDescription('Generates extra fields for entities');
        $this->setName('wellcommerce:entities:generate-extra');
    }

    /**
     * Executes the command
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $generator     = new EntitiesExtraGenerator();
        $finder        = new ExtraMappingFinder();
        $extraMappings = $finder->getExtraMappings();
        $traitAnalyzer = new TraitAnalyzer();

        foreach ($extraMappings as $className => $extraMapping) {
            $reflectionClass = new \ReflectionClass($className);
            $shortName       = $reflectionClass->getShortName();

            if (false === $traitAnalyzer->hasEntityExtraTrait($reflectionClass)) {
                $output->write('Skipped generation for <error>' . $shortName . '</error>. No corresponding trait was found', true);
            } else {
                $generator->generateEntityExtra($reflectionClass, $extraMapping);
                $output->write('Generating extra fields for <info>' . $shortName . '</info> entity', true);
            }
        }
    }
}
