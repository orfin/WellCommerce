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

namespace WellCommerce\Bundle\CoreBundle\DataSet\Column;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class Column
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Column extends AbstractColumn implements ColumnInterface
{
    protected function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'alias',
            'source',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return $this->options['alias'];
    }

    /**
     * {@inheritdoc}
     */
    public function getSource()
    {
        return $this->options['source'];
    }

    /**
     * {@inheritdoc}
     */
    public function getRawSelect()
    {
        return sprintf('%s AS %s', $this->options['source'], $this->options['alias']);
    }
}