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

namespace WellCommerce\Bundle\AvailabilityBundle\Plugin;

use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use WellCommerce\Bundle\DistributionBundle\Plugin\BundlePluginInterface;
use WellCommerce\Component\DataGrid\DataGridInterface;
use WellCommerce\Component\DataSet\DataSetInterface;
use WellCommerce\Component\Form\Elements\FormInterface;
use WellCommerce\Component\Form\FormBuilderInterface;

/**
 * Class AvailabilityBundlePlugin
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AvailabilityBundlePlugin implements BundlePluginInterface
{
    public function extendMetadata(ClassMetadata $metadata)
    {
    }

    public function extendForm(FormInterface $form, FormBuilderInterface $formBuilder)
    {
    }

    public function extendDataSet(DataSetInterface $dataset)
    {
    }

    public function extendDataGrid(DataGridInterface $datagrid)
    {
    }

    public function extendTwig()
    {
    }

    public function supportsMetadata($class)
    {
        return $class === \WellCommerce\Bundle\AvailabilityBundle\Entity\Availability::class;
    }

    public function getName()
    {
        return 'availability';
    }
}
