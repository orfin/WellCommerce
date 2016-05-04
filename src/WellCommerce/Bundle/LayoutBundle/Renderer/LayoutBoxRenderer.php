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

use Symfony\Component\HttpFoundation\Response;
use WellCommerce\Bundle\CoreBundle\Controller\Box\BoxControllerInterface;
use WellCommerce\Bundle\CoreBundle\Helper\Router\RouterHelperInterface;
use WellCommerce\Bundle\DoctrineBundle\Manager\ManagerInterface;
use WellCommerce\Bundle\LayoutBundle\Collection\LayoutBoxSettingsCollection;
use WellCommerce\Bundle\LayoutBundle\Entity\LayoutBoxInterface;
use WellCommerce\Bundle\LayoutBundle\Exception\LayoutBoxNotFoundException;
use WellCommerce\Bundle\LayoutBundle\Resolver\ServiceResolverInterface;

/**
 * Class LayoutBoxRenderer
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class LayoutBoxRenderer implements LayoutBoxRendererInterface
{
    /**
     * @var ManagerInterface
     */
    private $manager;
    
    /**
     * @var ServiceResolverInterface
     */
    private $serviceResolver;

    /**
     * @var RouterHelperInterface
     */
    private $routerHelper;

    /**
     * LayoutBoxRenderer constructor.
     *
     * @param ServiceResolverInterface $serviceResolver
     * @param ManagerInterface         $manager
     * @param RouterHelperInterface    $routerHelper
     */
    public function __construct(ServiceResolverInterface $serviceResolver, ManagerInterface $manager, RouterHelperInterface $routerHelper)
    {
        $this->manager         = $manager;
        $this->serviceResolver = $serviceResolver;
        $this->routerHelper    = $routerHelper;
    }
    
    public function render(string $identifier, array $params) : string
    {
        $content = $this->getLayoutBoxContent($identifier, $params);
        
        return $content->getContent();
    }

    private function findLayoutBox($identifier) : LayoutBoxInterface
    {
        $layoutBox = $this->manager->getRepository()->findOneBy(['identifier' => $identifier]);
        if (!$layoutBox instanceof LayoutBoxInterface) {
            throw new LayoutBoxNotFoundException($identifier);
        }

        return $layoutBox;
    }

    private function getLayoutBoxContent(string $identifier, array $params = []) : Response
    {
        $layoutBox  = $this->findLayoutBox($identifier);
        $controller = $this->serviceResolver->resolveControllerService($layoutBox);
        $action     = $this->resolveControllerAction($controller);
        $settings   = $this->makeSettingsCollection($layoutBox->getSettings(), $params);
        
        return call_user_func_array([$controller, $action], [$settings]);
    }
    
    private function makeSettingsCollection(array $defaultSettings = [], array $params = []) : LayoutBoxSettingsCollection
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
    private function resolveControllerAction(BoxControllerInterface $controller)
    {
        $currentAction = $this->routerHelper->getCurrentAction();

        if ($this->routerHelper->hasControllerAction($controller, $currentAction)) {
            return $currentAction;
        }

        return 'indexAction';
    }
}
