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

namespace WellCommerce\Bundle\CoreBundle\Definition;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Interface MappingDefinitionInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface MappingDefinitionInterface
{
    const CLASS_METADATA_METHOD_FIELD        = 'mapField';
    const CLASS_METADATA_METHOD_MANY_TO_MANY = 'mapManyToMany';
    const CLASS_METADATA_METHOD_MANY_TO_ONE  = 'mapManyToOne';
    const CLASS_METADATA_METHOD_ONE_TO_MANY  = 'mapOneToMany';
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions (OptionsResolver $resolver);
    
    /**
     * @return array
     */
    public function getOptions ();
    
    /**
     * @return string
     */
    public function getClassMetadataMethod ();
    
    /**
     * @return string
     */
    public function getPropertyName ();
}
