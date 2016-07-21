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

namespace WellCommerce\Bundle\CoreBundle\DependencyInjection;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use WellCommerce\Bundle\DoctrineBundle\Entity\EntityInterface;
use WellCommerce\Bundle\DoctrineBundle\Factory\EntityFactoryInterface;
use WellCommerce\Bundle\DoctrineBundle\Manager\ManagerInterface;
use WellCommerce\Component\DataGrid\DataGridInterface;
use WellCommerce\Component\DataSet\DataSetInterface;
use WellCommerce\Component\Form\FormBuilderInterface;

/**
 * Class ClassFinder
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class ClassFinder
{
    public function findEntityClasses(BundleInterface $bundle) : array
    {
        $directory = $bundle->getPath() . '/Entity';
        $namespace = $bundle->getNamespace() . '\Entity';
        $interface = EntityInterface::class;
        $classes   = $this->findClassesImplementingInterface($directory, $namespace, $interface);
        
        return $classes;
    }
    
    public function findEntityFactoryClasses(BundleInterface $bundle) : array
    {
        $directory = $bundle->getPath() . '/Factory';
        $namespace = $bundle->getNamespace() . '\Factory';
        $interface = EntityFactoryInterface::class;
        $classes   = $this->findClassesImplementingInterface($directory, $namespace, $interface);
        
        return $classes;
    }
    
    public function findManagerClasses(BundleInterface $bundle) : array
    {
        $directory = $bundle->getPath() . '/Manager';
        $namespace = $bundle->getNamespace() . '\Manager';
        $interface = ManagerInterface::class;
        $classes   = $this->findClassesImplementingInterface($directory, $namespace, $interface);
        
        return $classes;
    }
    
    public function findDataGridClasses(BundleInterface $bundle) : array
    {
        $directory = $bundle->getPath() . '/DataGrid';
        $namespace = $bundle->getNamespace() . '\DataGrid';
        $interface = DataGridInterface::class;
        $classes   = $this->findClassesImplementingInterface($directory, $namespace, $interface);
        
        return $classes;
    }
    
    public function findDataSetClasses(BundleInterface $bundle, string $type)
    {
        $directory = $bundle->getPath() . '/DataSet/' . $type;
        $namespace = $bundle->getNamespace() . '\DataSet\\' . $type;
        $interface = DataSetInterface::class;
        $classes   = $this->findClassesImplementingInterface($directory, $namespace, $interface);
        
        return $classes;
    }
    
    public function findFormBuilderClasses(BundleInterface $bundle, string $type)
    {
        $directory = $bundle->getPath() . '/Form/' . $type;
        $namespace = $bundle->getNamespace() . '\Form\\' . $type;
        $interface = FormBuilderInterface::class;
        $classes   = $this->findClassesImplementingInterface($directory, $namespace, $interface);
        
        return $classes;
    }
    
    private function findClassesImplementingInterface(string $directory, string $namespace, string $interface) : array
    {
        $classes    = [];
        $filesystem = new Filesystem();
        if ($filesystem->exists($directory)) {
            $finder = new Finder();
            $finder->files();
            $finder->in($directory);
            $finder->depth(0);
            
            foreach ($finder as $fileInfo) {
                $baseName        = $fileInfo->getBasename('.php');
                $class           = $namespace . '\\' . $baseName;
                $reflectionClass = new \ReflectionClass($class);
                if ($reflectionClass->isInstantiable() && $reflectionClass->implementsInterface($interface)) {
                    $classes[$baseName] = $class;
                }
            }
        }
        
        return $classes;
    }
}
