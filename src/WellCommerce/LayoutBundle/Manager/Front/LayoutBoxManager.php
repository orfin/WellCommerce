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

namespace WellCommerce\LayoutBundle\Manager\Front;

use WellCommerce\AppBundle\Controller\Box\BoxControllerInterface;
use WellCommerce\AppBundle\Manager\Front\AbstractFrontManager;
use WellCommerce\LayoutBundle\Collection\LayoutBoxCollection;
use WellCommerce\LayoutBundle\Collection\LayoutBoxSettingsCollection;
use WellCommerce\LayoutBundle\Exception\LayoutBoxNotFoundException;
use WellCommerce\LayoutBundle\Resolver\ServiceResolverInterface;

/**
 * Class LayoutBoxManager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutBoxManager extends AbstractFrontManager
{
    /**
     * @var ServiceResolverInterface
     */
    protected $serviceResolver;

    /**
     * @var LayoutBoxCollection
     */
    protected $layoutBoxCollection;

    /**
     * @param ServiceResolverInterface $serviceResolver
     */
    public function setServiceResolver(ServiceResolverInterface $serviceResolver)
    {
        $this->serviceResolver = $serviceResolver;
    }

    /**
     * @param LayoutBoxCollection $layoutBoxCollection
     */
    public function setLayoutBoxesCollection(LayoutBoxCollection $layoutBoxCollection)
    {
        $this->layoutBoxCollection = $layoutBoxCollection;
    }

    /**
     * Returns a layout box by its identifier
     *
     * @param string $identifier
     *
     * @return \WellCommerce\LayoutBundle\Entity\LayoutBox
     */
    public function findLayoutBox($identifier)
    {
        if (!$this->layoutBoxCollection->has($identifier)) {
            throw new LayoutBoxNotFoundException($identifier);
        }

        return $this->layoutBoxCollection->get($identifier);
    }

    /**
     * Returns layout box content object
     *
     * @param string $identifier
     * @param array  $params
     *
     * @return object
     */
    public function getLayoutBoxContent($identifier, array $params = [])
    {
        $layoutBox  = $this->findLayoutBox($identifier);
        $controller = $this->serviceResolver->resolveControllerService($layoutBox);
        $action     = $this->resolveControllerAction($controller);
        $settings   = $this->makeSettingsCollection($layoutBox->getSettings(), $params);

        return call_user_func_array([$controller, $action], [$settings]);
    }

    /**
     * Creates a collection of box settings
     *
     * @param array $defaultSettings
     * @param array $params
     *
     * @return LayoutBoxSettingsCollection
     */
    protected function makeSettingsCollection(array $defaultSettings = [], array $params = [])
    {
        $settings   = array_merge($defaultSettings, $params);
        $collection = new LayoutBoxSettingsCollection();

        foreach ($settings as $name => $value) {
            $collection->add($name, $value);
        }

        return $collection;
    }

    /**
     * Resolves action which can be used in controller method call
     *
     * @param BoxControllerInterface $controller
     *
     * @return string
     */
    protected function resolveControllerAction(BoxControllerInterface $controller)
    {
        $currentAction = $this->getRouterHelper()->getCurrentAction();

        if ($this->getRouterHelper()->hasControllerAction($controller, $currentAction)) {
            return $currentAction;
        }

        return 'indexAction';
    }
}
