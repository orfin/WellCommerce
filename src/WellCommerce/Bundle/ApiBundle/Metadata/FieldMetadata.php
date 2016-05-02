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

namespace WellCommerce\Bundle\ApiBundle\Metadata;


use Symfony\Component\OptionsResolver\OptionsResolver;

class FieldMetadata implements FieldMetadataInterface
{
    /**
     * @var string
     */
    protected $name;
    
    /**
     * @var array
     */
    protected $options;
    
    /**
     * FieldMetadata constructor.
     *
     * @param $name
     * @param $options
     */
    public function __construct($name, $options)
    {
        $this->name = $name;
        $resolver   = new OptionsResolver();
        $this->configureOptions($resolver);
        $this->options = $resolver->resolve($options);
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'groups',
        ]);
        
        $resolver->setDefaults([
            'groups' => [],
        ]);
        
        $resolver->setAllowedTypes('groups', 'array');
    }
    
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getGroups()
    {
        return $this->options['groups'];
    }
    
    /**
     * {@inheritdoc}
     */
    public function hasGroup($group)
    {
        return in_array($group, $this->getGroups());
    }
    
    /**
     * {@inheritdoc}
     */
    public function hasDefaultGroup()
    {
        return $this->hasGroup('default');
    }
}
