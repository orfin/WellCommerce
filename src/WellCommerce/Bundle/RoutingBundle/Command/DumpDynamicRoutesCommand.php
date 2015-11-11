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

namespace WellCommerce\Bundle\RoutingBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Dumper;

/**
 * Class ReindexProductsCommand
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DumpDynamicRoutesCommand extends ContainerAwareCommand
{
    /**
     * @var \WellCommerce\Bundle\RoutingBundle\Generator\RouteGeneratorCollection
     */
    protected $generators;

    /**
     * @var \WellCommerce\Bundle\RoutingBundle\Repository\RouteRepositoryInterface
     */
    protected $repository;

    /**
     * @var \WellCommerce\Bundle\RoutingBundle\Provider\RouteProvider
     */
    protected $provider;

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        parent::initialize($input, $output);
        $this->repository = $this->getContainer()->get('routing.repository');
        $this->provider   = $this->getContainer()->get('router.provider.endpoint');
    }

    protected function configure()
    {
        $this->setDescription('Dumps all dynamic routes into single YML file');
        $this->setName('wellcommerce:routing:dump');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $collection = $this->repository->findAll();
        $routes     = [];
        foreach ($collection as $item) {
            $route                               = $this->provider->getRouteByName($item->getId());
            $routes['dynamic_' . $item->getId()] = [
                'path'         => $route->getPath(),
                'defaults'     => $route->getDefaults(),
                'requirements' => $route->getRequirements(),
            ];
        }

        $dumper = new Dumper();
        $yaml   = $dumper->dump($routes, 3);
        $kernel = $this->getContainer()->get('kernel');
        $path   = $kernel->getRootDir() . '/config/dynamic_routing.yml';
        file_put_contents($path, $yaml);

        $output->write('Dumping done.', true);
    }
}
