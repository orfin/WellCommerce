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
namespace WellCommerce\Core;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\TerminableInterface;
use WellCommerce\Core\DependencyInjection\ServiceContainerBuilder;

/**
 * Class Application
 *
 * @package WellCommerce\Core
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Application implements TerminableInterface, HttpKernelInterface
{
    /**
     * Container object
     *
     * @var object
     */
    protected $container;

    /**
     * Application environment
     *
     * @var string
     */
    protected $environment;

    /**
     * Debug mode
     *
     * @var bool
     */
    protected $debug;

    /**
     * Booted status
     *
     * @var bool
     */
    protected $booted = false;

    /**
     * Constructor
     *
     * @param string $environment Application environment
     * @param bool   $debug       Whether to enable debugging or not
     */
    public function __construct($environment, $debug)
    {
        $this->environment = $environment;
        $this->debug       = (bool)$debug;
    }

    /**
     * Boots the Application
     */
    public function boot()
    {
        $builder         = new ServiceContainerBuilder($this->getKernelParameters(), $this->environment, $this->debug);
        $this->container = $builder->getContainer();
        $this->booted    = true;
    }

    /**
     * Returns Container instance
     *
     * @return \Symfony\Component\DependencyInjection\ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Request $request, $type = HttpKernel::MASTER_REQUEST, $catch = true)
    {
        if (false === $this->booted) {
            $this->boot();
        }

        return $this->getHttpKernel()->handle($request, $type, $catch);
    }

    /**
     * {@inheritdoc}
     */
    public function terminate(Request $request, Response $response)
    {
        if (false === $this->booted) {
            return;
        }

        if ($this->getHttpKernel() instanceof TerminableInterface) {
            $this->getHttpKernel()->terminate($request, $response);
        }
    }

    /**
     * Returns HttpKernel service
     *
     * @return \Symfony\Component\HttpKernel\DependencyInjection\ContainerAwareHttpKernel
     */
    protected function getHttpKernel()
    {
        return $this->container->get('http_kernel');
    }


    /**
     * Returns all globally accessible kernel parameters
     *
     * @return  array
     */
    protected function getKernelParameters()
    {
        return [
            'application.root_path'   => ROOTPATH,
            'application.debug'       => $this->debug,
            'application.environment' => $this->environment
        ];
    }
}