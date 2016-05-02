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

namespace WellCommerce\Bundle\AdminBundle\Provider;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\KernelInterface;
use WellCommerce\Bundle\AdminBundle\Entity\AdminMenuInterface;
use WellCommerce\Bundle\AdminBundle\Repository\AdminMenuRepositoryInterface;

/**
 * Class AdminMenuProvider
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AdminMenuProvider
{
    const CACHE_FILENAME = 'admin_menu.php';
    
    /**
     * @var KernelInterface
     */
    protected $kernel;
    
    /**
     * @var AdminMenuRepositoryInterface
     */
    protected $adminMenuRepository;
    
    /**
     * AdminMenuProvider constructor.
     *
     * @param KernelInterface              $kernel
     * @param AdminMenuRepositoryInterface $repository
     */
    public function __construct(KernelInterface $kernel, AdminMenuRepositoryInterface $repository)
    {
        $this->kernel              = $kernel;
        $this->adminMenuRepository = $repository;
    }
    
    public function getMenu()
    {
        if (is_file($cache = $this->kernel->getCacheDir() . '/' . self::CACHE_FILENAME)) {
            $menu = require $cache;
        } else {
            $menu = $this->generateMenu();
            $this->writeCache($menu);
        }
        
        return $menu;
    }
    
    protected function generateMenu()
    {
        $criteria = new Criteria();
        $criteria->orderBy(['hierarchy' => 'asc']);
        
        $collection = $this->adminMenuRepository->matching($criteria);
        $elements   = $this->filterElements($collection, null);
        $tree       = $this->generateTree($collection, $elements);
        
        return $tree;
    }
    
    /**
     * Generates a tree for given children elements
     *
     * @param Collection $collection
     * @param Collection $children
     *
     * @return array
     */
    protected function generateTree(Collection $collection, Collection $children)
    {
        $children->map(function (AdminMenuInterface $menuItem) use ($collection, &$tree) {
            $tree[] = [
                'routeName' => $menuItem->getRouteName(),
                'cssClass'  => $menuItem->getCssClass(),
                'name'      => $menuItem->getName(),
                'children'  => $this->generateTree($collection, $this->filterElements($collection, $menuItem))
            ];
        });
        
        return $tree;
    }
    
    protected function writeCache(array $menu)
    {
        $file    = $this->kernel->getCacheDir() . '/' . self::CACHE_FILENAME;
        $content = sprintf('<?php return %s;', var_export($menu, true));
        $fs      = new Filesystem();
        $fs->dumpFile($file, $content);
    }
    
    /**
     * Filters the collection and returns only children elements for given parent element
     *
     * @param Collection              $collection
     * @param AdminMenuInterface|null $parent
     *
     * @return Collection
     */
    protected function filterElements(Collection $collection, AdminMenuInterface $parent = null)
    {
        $children = $collection->filter(function (AdminMenuInterface $menuItem) use ($parent) {
            return $menuItem->getParent() === $parent;
        });
        
        return $children;
    }
}
