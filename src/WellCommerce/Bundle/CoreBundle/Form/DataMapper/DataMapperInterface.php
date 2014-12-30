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

namespace WellCommerce\Bundle\CoreBundle\Form\DataMapper;

use WellCommerce\Bundle\CoreBundle\Form\Elements\FormInterface;

/**
 * Interface DataMapperInterface
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
interface DataMapperInterface
{
    public function mapDataToForm($data, FormInterface $form);

    public function mapFormToData(FormInterface $form, $data);
} 