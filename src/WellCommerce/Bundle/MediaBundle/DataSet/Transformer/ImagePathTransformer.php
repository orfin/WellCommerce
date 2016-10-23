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

namespace WellCommerce\Bundle\MediaBundle\DataSet\Transformer;

use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Bundle\CoreBundle\Helper\Image\ImageHelperInterface;
use WellCommerce\Component\DataSet\Transformer\AbstractDataSetTransformer;

/**
 * Class ImagePathTransformer
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ImagePathTransformer extends AbstractDataSetTransformer
{
    /**
     * @var ImageHelperInterface
     */
    protected $imageHelper;
    
    /**
     * Constructor
     *
     * @param ImageHelperInterface $imageHelper
     */
    public function __construct (ImageHelperInterface $imageHelper)
    {
        $this->imageHelper = $imageHelper;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions (OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'filter',
        ]);
        
        $resolver->setDefaults([
            'filter' => 'medium',
        ]);
        
        $resolver->setAllowedTypes('filter', 'string');
    }
    
    /**
     * {@inheritdoc}
     */
    public function transformValue ($value)
    {
        if (null === $value) {
            return '';
        }
        
        return $this->imageHelper->getImage($value, $this->options['filter']);
    }
}
