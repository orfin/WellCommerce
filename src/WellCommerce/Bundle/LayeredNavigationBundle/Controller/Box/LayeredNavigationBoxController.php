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

namespace WellCommerce\Bundle\LayeredNavigationBundle\Controller\Box;

use Symfony\Component\HttpFoundation\Response;
use WellCommerce\Bundle\CategoryBundle\Entity\CategoryInterface;
use WellCommerce\Bundle\CoreBundle\Controller\Box\AbstractBoxController;
use WellCommerce\Bundle\LayoutBundle\Collection\LayoutBoxSettingsCollection;

/**
 * Class LayeredNavigationBoxController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayeredNavigationBoxController extends AbstractBoxController
{
    /**
     * {@inheritdoc}
     */
    public function indexAction(LayoutBoxSettingsCollection $boxSettings) : Response
    {
        $producers = $this->get('producer.dataset.front')->getResult('array', [
            'order_by'  => 'name',
            'order_dir' => 'asc',
        ], [
            'pagination' => false,
        ]);
        
        $category   = null;
        $attributes = [];
        
        if ($this->getCategoryStorage()->hasCurrentCategory()) {
            $category   = $this->getCategoryStorage()->getCurrentCategory();
            $attributes = $this->getAttributesForCategory($category);
        }
        
        return $this->displayTemplate('index', [
            'producers'  => $producers,
            'category'   => $category,
            'attributes' => $attributes,
        ]);
    }
    
    private function getAttributesForCategory(CategoryInterface $category) : array
    {
        $helper  = $this->get('variant.helper');
        $attributes = $this->get('variant_option.repository')->getVariantOptionsForCategory($category);
        $filter  = [];
        
        foreach ($attributes as $option) {
            $filter[$option['attributeName']][$option['value']] = $option['valueName'];
        }
    
        foreach ($filter as $id => &$data) {
            $helper->sortOptions($data);
        }
        
        return $filter;
    }
}
