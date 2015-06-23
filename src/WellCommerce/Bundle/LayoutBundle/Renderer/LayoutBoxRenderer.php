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

use WellCommerce\Bundle\CoreBundle\DependencyInjection\AbstractContainer;
use WellCommerce\Bundle\LayoutBundle\Collection\LayoutBoxSettingsCollection;
use WellCommerce\Bundle\LayoutBundle\Configurator\LayoutBoxConfiguratorCollection;
use WellCommerce\Bundle\LayoutBundle\Entity\LayoutBox;
use WellCommerce\Bundle\LayoutBundle\Repository\LayoutBoxRepositoryInterface;

/**
 * Class LayoutBoxRenderer
 *
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
        $service    = $this->configurators->get($box->getBoxType())->getControllerService();
        $controller = $this->container->get($service);
        $action     = $this->getControllerAction($controller);
        $settings   = $this->getSettingsCollection($box, $params);
        $content    = call_user_func_array([$controller, $action], [$settings]);

        return $content->getContent();
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

    private function getSettingsCollection(LayoutBox $layoutBox, array $params = [])
    {
        $collection        = new LayoutBoxSettingsCollection();
        $layoutBoxSettings = $layoutBox->getSettings();
        $settings          = array_merge($layoutBoxSettings, $params);

        foreach ($settings as $name => $value) {
            $collection->add($name, $value);
        }

        return $collection;
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
}
