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

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Memio\Memio\Config\Build;
use Memio\Model\File;
use Memio\Model\Object;
use Memio\Model\Property;
use Memio\Model\Method;
use Memio\Model\Argument;

class GenerateEntitiesExtraCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setDescription('Generates entities extra traits');
        $this->setName('wellcommerce:entity:generate-extra');
    }

    /**
     * Executes the command
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Describe the code you want to generate using "Models"
        $file = File::make('src/Vendor/Project/MyService.php')
            ->setStructure(
                Object::make('Vendor\Project\MyService')
                    ->addProperty(new Property('createdAt'))
                    ->addProperty(new Property('filename'))
                    ->addMethod(
                        Method::make('__construct')
                            ->addArgument(new Argument('DateTime', 'createdAt'))
                            ->addArgument(new Argument('string', 'filename'))
                        ->setBody('return $filename')
                    )
            )
        ;

        $prettyPrinter = Build::prettyPrinter();
        $generatedCode = $prettyPrinter->generateCode($file);
        echo $generatedCode;
        die();
    }
}
