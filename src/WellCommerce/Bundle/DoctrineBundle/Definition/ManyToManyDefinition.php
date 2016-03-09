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

namespace WellCommerce\Bundle\DoctrineBundle\Definition;

use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class FieldDefinition
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ManyToManyDefinition extends AbstractMappingDefinition
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'fieldName',
            'targetEntity',
            'fetch',
            'cascade',
            'mappedBy',
            'joinTable',
            'orderBy',
        ]);

        $resolver->setDefaults([
            'fetch'     => ClassMetadataInfo::FETCH_EXTRA_LAZY,
            'cascade'   => [
                'remove',
                'persist',
                'refresh',
                'merge',
                'detach',
            ],
            'mappedBy'  => null,
            'joinTable' => [],
            'orderBy'   => null,
        ]);

        $resolver->setAllowedTypes('fieldName', 'string');
        $resolver->setAllowedTypes('targetEntity', 'string');
        $resolver->setAllowedTypes('fetch', 'integer');
        $resolver->setAllowedTypes('cascade', 'array');
        $resolver->setAllowedTypes('mappedBy', ['string', 'null']);
        $resolver->setAllowedTypes('joinTable', 'array');
        $resolver->setAllowedTypes('orderBy', ['string', 'null']);
    }

    /**
     * {@inheritdoc}
     */
    public function getClassMetadataMethod()
    {
        return MappingDefinitionInterface::CLASS_METADATA_METHOD_MANY_TO_MANY;
    }
}
