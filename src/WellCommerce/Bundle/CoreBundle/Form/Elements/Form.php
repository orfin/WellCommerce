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

namespace WellCommerce\Bundle\CoreBundle\Form\Elements;

use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\CoreBundle\Form\DataCollector\DataCollectorInterface;
use WellCommerce\Bundle\CoreBundle\Form\Elements\Container\ContainerCollection;
use WellCommerce\Bundle\CoreBundle\Form\Elements\Container\ContainerInterface;
use WellCommerce\Bundle\CoreBundle\Form\FormConfiguration;
use WellCommerce\Bundle\CoreBundle\Form\Renderer\FormRendererInterface;
use WellCommerce\Bundle\CoreBundle\Form\Request\RequestHandlerInterface;
use WellCommerce\Bundle\CoreBundle\Form\Validator\ValidatorInterface;

/**
 * Class Form
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class Form implements FormInterface
{
    protected $configuration;
    protected $containers;
    protected $renderer;
    protected $dataCollector;
    protected $validator;
    protected $requestHandler;

    public function __construct($options)
    {
        $this->configuration = new FormConfiguration($options);
        $this->containers    = new ContainerCollection();
    }

    public function setRenderer(FormRendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    public function setDataCollector(DataCollectorInterface $dataCollector)
    {
        $this->dataCollector = $dataCollector;
    }

    public function setValidator(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function setRequestHandler(RequestHandlerInterface $requestHandler)
    {
        $this->requestHandler = $requestHandler;
    }

    /**
     * Appends new container to form
     *
     * @param ContainerInterface $container
     *
     * @return ContainerInterface
     */
    public function addContainer(ContainerInterface $container)
    {
        $this->containers->add($container);

        return $container;
    }

    public function handleRequest(Request $request)
    {
        $this->requestHandler->handleRequest($this, $request);
    }

    public function isSubmitted()
    {
        return $this->requestHandler->isSubmitted($this);
    }

    public function isValid()
    {
        return $this->validator->isValid($this);
    }

} 