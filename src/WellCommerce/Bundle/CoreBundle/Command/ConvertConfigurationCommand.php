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
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Yaml;
use WellCommerce\Bundle\CoreBundle\DependencyInjection\AbstractExtension;

/**
 * Class ConvertConfigurationCommand
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class ConvertConfigurationCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('wellcommerce:convert:configuration');
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fs      = new Filesystem();
        $bundles = $this->getContainer()->get('kernel')->getBundles();
        foreach ($bundles as $bundle) {
            $extension = $bundle->getContainerExtension();
            if ($extension instanceof AbstractExtension) {
                $reflection = new \ReflectionClass($extension);
                $directory  = dirname($reflection->getFileName());
                $locator    = new FileLocator($directory . '/../Resources/config');

                //container
                $container = new ContainerBuilder(new ParameterBag());
                $loader    = new XmlFileLoader($container, $locator);
                $loader->load('services.xml');
                $dumper = new \Symfony\Component\DependencyInjection\Dumper\YamlDumper($container);

                $fs->dumpFile($directory . '/../Resources/config/services.yml', $dumper->dump());

                $resource = $directory . '/../Resources/config/routing.xml';

                if ($fs->exists($resource)) {
                    $loader         = new \Symfony\Component\Routing\Loader\XmlFileLoader($locator);
                    $importedRoutes = $loader->import($resource);
                    $routing        = [];
                    /** @var \Symfony\Component\Routing\Route $route */
                    foreach ($importedRoutes as $key => $route) {
                        $routing[$key] = [
                            'path'         => (string)$route->getPath(),
                        ];

                        if (count($route->getDefaults()) > 0) {
                            $routing[$key]['defaults'] = $route->getDefaults();
                        }

                        if (count($route->getOptions()) > 0) {
                            $options = $route->getOptions();
                            unset($options['compiler_class']);
                            $routing[$key]['options'] = $options;
                            if(isset($routing[$key]['options']['expose']) && true == $routing[$key]['options']['expose']){
                                $routing[$key]['options']['expose'] = (bool)$routing[$key]['options']['expose'];
                            }
                        }

                        if (count($route->getRequirements()) > 0) {
                            $routing[$key]['requirements'] = $route->getRequirements();
                        }
                    }

                    $target = $directory . '/../Resources/config/routing.yml';
                    $dumper = new Yaml();
                    $fs->dumpFile($target, $dumper->dump($routing, 4));
                }

            }
        }
    }
}
