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

namespace WellCommerce\Bundle\DistributionBundle\Plugin;

use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use WellCommerce\Component\DataGrid\DataGridInterface;
use WellCommerce\Component\DataSet\DataSetInterface;
use WellCommerce\Component\Form\Elements\FormInterface;
use WellCommerce\Component\Form\FormBuilderInterface;

/**
 * Interface BundlePluginInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface BundlePluginInterface
{
    public function extendMetadata(ClassMetadata $metadata);

    public function extendForm(FormInterface $form, FormBuilderInterface $formBuilder);

    public function extendDataSet(DataSetInterface $dataset);

    public function extendDataGrid(DataGridInterface $datagrid);

    public function extendTwig();

    public function supportsMetadata($class);

    public function getName();
}
