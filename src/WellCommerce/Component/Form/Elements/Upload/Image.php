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

namespace WellCommerce\Component\Form\Elements\Upload;

use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Component\Form\Elements\ElementInterface;

/**
 * Class Image
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Image extends File implements ElementInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'file_types' => ['jpg', 'jpeg', 'png', 'gif'],
        ]);
    }
}
