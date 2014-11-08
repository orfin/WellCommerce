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

namespace WellCommerce\Bundle\LayoutBundle\Renderer;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use WellCommerce\Bundle\CoreBundle\DependencyInjection\AbstractContainer;
use WellCommerce\Bundle\LayoutBundle\Configurator\LayoutBoxConfiguratorCollection;
use WellCommerce\Bundle\LayoutBundle\Entity\LayoutBox;
use WellCommerce\Bundle\LayoutBundle\Repository\LayoutBoxRepositoryInterface;

/**
 * Class LayoutBoxRenderer
 *
 * @package WellCommerce\Bundle\LayoutBundle\Renderer
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutBoxRenderer extends AbstractContainer implements LayoutBoxRendererInterface
{
    /**
     * @var LayoutBoxRepositoryInterface
     */
    protected $repository;

    /**
     * @var \WellCommerce\Bundle\LayoutBundle\Collection\LayoutBoxCollection
     */
    protected $collection;

    /**
     * @var LayoutBoxConfiguratorCollection
     */
    protected $configurators;

    /**
     * Constructor
     *
     * @param LayoutBoxRepositoryInterface $repository
     */
    public function __construct(
        LayoutBoxRepositoryInterface $repository,
        LayoutBoxConfiguratorCollection $configurators
    ) {
        $this->repository    = $repository;
        $this->collection    = $repository->getLayoutBoxesCollection();
        $this->configurators = $configurators;
    }

    /**
     * {@inheritdoc}
     */
    public function render($identifier, $params)
    {
        if ($this->collection->has($identifier)) {
            $box = $this->collection->get($identifier);
            return $this->getControllerContent($box, $params);
        }

        return '';
    }

    /**
     * Forwards request to box controller and returns its contents
     *
     * @param LayoutBox $box
     * @param           $params
     *
     * @return string
     * @throws \Exception
     */
    private function getControllerContent(LayoutBox $box, $params)
    {
        $currentRequest                   = $this->getRequest();
        $request                          = $currentRequest->attributes->all();
        $request['_controller']           = $this->getLayoutBoxController($box);
        $request['_template_vars']['box'] = $this->getBoxTemplateVars($box, $params);
        $subRequest                       = $currentRequest->duplicate($currentRequest->query->all(), null, $request);

        $content = $this->container->get('http_kernel')->handle($subRequest, HttpKernelInterface::SUB_REQUEST);

        return $content->getContent();
    }

    /**
     * Returns controller name needed to forward the request
     *
     * @param LayoutBox $box
     *
     * @return string
     */
    private function getLayoutBoxController(LayoutBox $box)
    {
        $service    = $this->configurators->get($box->getBoxType())->getControllerService();
        $controller = $this->container->get($service);
//        $controller->setBoxSettings($box->getSettings());

        return sprintf('%s:%s', $service, $this->getControllerAction($controller));
    }

    /**
     * Checks whether current action is accessible in box controller.
     * If not, default indexAction will be returned.
     *
     * @param $controller
     *
     * @return mixed|string
     */
    private function getControllerAction($controller)
    {
        $currentAction   = $this->getCurrentAction();
        $reflectionClass = new \ReflectionClass($controller);

        if ($reflectionClass->hasMethod($currentAction)) {
            $reflectionMethod = new \ReflectionMethod($controller, $currentAction);
            if ($reflectionMethod->isPublic()) {
                return $currentAction;
            }
        }

        return 'indexAction';
    }

    /**
     * Returns master request controller action
     *
     * @return mixed
     */
    private function getCurrentAction()
    {
        $currentPath  = $this->getRouterContext()->getPathInfo();
        $currentRoute = $this->getRouter()->match($currentPath);
        list(, $action) = explode(':', $currentRoute['_controller']);

        return $action;
    }

    /**
     * Returns current router context
     *
     * @return \Symfony\Component\Routing\RequestContext
     */
    private function getRouterContext()
    {
        return $this->getRouter()->getContext();
    }

    /**
     * Returns variables needed to inject in _template_vars
     *
     * @param LayoutBox $box
     *
     * @return array
     */
    private function getBoxTemplateVars(LayoutBox $box, $params)
    {
        return [
            'id'       => $box->getIdentifier(),
            'settings' => array_merge_recursive($box->getSettings(), $params)
        ];
    }
} 