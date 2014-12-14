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

namespace WellCommerce\Bundle\CompanyBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\CoreBundle\Controller\Admin\AbstractAdminController;
use WellCommerce\Bundle\DataSetBundle\DataSet\Conditions\Condition;
use WellCommerce\Bundle\DataSetBundle\DataSet\Conditions\ConditionsCollection;
use WellCommerce\Bundle\DataSetBundle\DataSet\Request\DataSetRequest;

/**
 * Class CompanyController
 *
 * @package WellCommerce\Bundle\CompanyBundle\Controller
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Template()
 */
class CompanyController extends AbstractAdminController
{
    public function indexAction(Request $request)
    {
        $datagrid = $this->get('company.datagrid');

        return [
            'datagrid' => $datagrid->getInstance()
        ];

        die();

        $conditions = new ConditionsCollection();
        $conditions->add(new Condition\Lt('id', 2));
        $conditions->add(new Condition\Contains('name', 'Gibson'));

        $results = $this->get('company.dataset')->getResults(new DataSetRequest([
            'limit'      => 10,
            'orderBy'    => 'shortName',
            'orderDir'   => 'asc',
            'conditions' => $conditions
        ]));

        print_r($results);

        die();
    }
}
