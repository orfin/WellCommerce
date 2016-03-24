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

namespace WellCommerce\Component\Form\DataMapper;

use WellCommerce\Component\Form\Elements\FormInterface;

/**
 * Class FormDataMapper
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class FormDataMapper implements FormDataMapperInterface
{
    /**
     * {@inheritdoc}
     */
    public function mapModelDataToForm($modelData, FormInterface $form)
    {
        $modelDataMapper = new ModelDataMapper($modelData);
        $modelDataMapper->mapDataToForm($form);
    }

    /**
     * {@inheritdoc}
     */
    public function mapFormToData(FormInterface $form, $modelData)
    {
        $modelDataMapper = new ModelDataMapper($modelData);
        $modelDataMapper->mapFormToData($form);
    }

    /**
     * {@inheritdoc}
     */
    public function mapRequestDataToForm($data, FormInterface $form)
    {
        $requestDataMapper = new RequestDataMapper($data);
        $requestDataMapper->mapDataToForm($form);
    }
}
