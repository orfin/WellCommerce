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

namespace WellCommerce\Bundle\ApiBundle\Controller;

use Doctrine\Common\Util\Debug;
use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\CoreBundle\Controller\AbstractController;

/**
 * Class ApiController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ApiController extends AbstractController
{
    public function pingAction(Request $request)
    {
        $data       = $this->get('product.repository')->findOneBy([]);
        $serializer = $this->get('jms_serializer');
        $result     = $serializer->serialize($data, 'json');

        $json
            = '{
    "id": 1,
    "sku": "4024007129595707test",
    "created_at": "2016-02-07T11:21:18+0000",
    "updated_at": "2016-02-07T11:21:18+0000"
}';

        $data = $serializer->deserialize($json, 'WellCommerce\\Bundle\\ProductBundle\\Entity\\Product', 'json');

        Debug::dump($data);

        die();

        return $this->jsonResponse([
            'ping' => true
        ]);
    }

    public function getProductAction()
    {

    }
}
