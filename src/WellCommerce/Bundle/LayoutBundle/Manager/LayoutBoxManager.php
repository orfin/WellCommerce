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

namespace WellCommerce\Bundle\LayoutBundle\Manager;

use WellCommerce\Bundle\CoreBundle\Controller\Box\BoxControllerInterface;
use WellCommerce\Bundle\CoreBundle\Manager\AbstractManager;
use WellCommerce\Bundle\LayoutBundle\Collection\LayoutBoxSettingsCollection;
use WellCommerce\Bundle\LayoutBundle\Entity\LayoutBoxInterface;
use WellCommerce\Bundle\LayoutBundle\Exception\LayoutBoxNotFoundException;
use WellCommerce\Bundle\LayoutBundle\Resolver\ServiceResolverInterface;

/**
 * Class LayoutBoxManager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutBoxManager extends AbstractManager
{
    /**
     * @var ServiceResolverInterface
     */
    protected $serviceResolver;

    /**
     * @param ServiceResolverInterface $serviceResolver
     */
    public function setServiceResolver(ServiceResolverInterface $serviceResolver)
    {
        $this->serviceResolver = $serviceResolver;
    }

    /**
     * Returns a layout box by its identifier
     *
     * @param string $identifier
     *
     * @return \WellCommerce\Bundle\LayoutBundle\Entity\LayoutBoxInterface
     */
    public function findLayoutBox($identifier)
    {
        $layoutBox = $this->repository->findOneBy(['identifier' => $identifier]);
        if (!$layoutBox instanceof LayoutBoxInterface) {
            throw new LayoutBoxNotFoundException($identifier);
        }

        return $layoutBox;
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
