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

namespace WellCommerce\Bundle\LayoutBundle\Manager\Front;

use WellCommerce\Bundle\CoreBundle\Controller\Box\BoxControllerInterface;
use WellCommerce\Bundle\CoreBundle\Manager\Front\AbstractFrontManager;
use WellCommerce\Bundle\LayoutBundle\Collection\LayoutBoxCollection;
use WellCommerce\Bundle\LayoutBundle\Collection\LayoutBoxSettingsCollection;
use WellCommerce\Bundle\LayoutBundle\Exception\LayoutBoxNotFoundException;
use WellCommerce\Bundle\LayoutBundle\Repository\LayoutBoxRepositoryInterface;
use WellCommerce\Bundle\LayoutBundle\Resolver\ServiceResolverInterface;

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
     * Constructor
     *
     * @param LayoutBoxRepositoryInterface $layoutBoxRepository
     * @param ServiceResolverInterface     $serviceResolver
     * @param LayoutBoxCollection          $layoutBoxCollection
     */
    public function __construct(LayoutBoxRepositoryInterface $layoutBoxRepository, ServiceResolverInterface $serviceResolver, LayoutBoxCollection $layoutBoxCollection)
    {
        parent::__construct($layoutBoxRepository);
        $this->serviceResolver     = $serviceResolver;
        $this->layoutBoxCollection = $layoutBoxCollection;
    }


    /**
     * Returns a layout box by its identifier
     *
     * @param string $identifier
     *
     * @return \WellCommerce\Bundle\LayoutBundle\Entity\LayoutBox
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
