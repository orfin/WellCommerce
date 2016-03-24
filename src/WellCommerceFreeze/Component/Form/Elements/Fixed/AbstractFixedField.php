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

namespace WellCommerce\Component\Form\Elements\Fixed;

use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Component\Form\Elements\AbstractField;
use WellCommerce\Component\Form\Elements\ElementInterface;
use WellCommerce\Component\Form\Filters\FilterInterface;

/**
 * Class AbstractFixedField
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractFixedField extends AbstractField implements ElementInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setNormalizer('property_path', function () {
            return;
        });
    }
    /**
     * {@inheritdoc}
     */
    public function addFilter(FilterInterface $filter)
    {
        return false;
    }
}
