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
namespace WellCommerce\Bundle\CoreBundle\Controller\Box;

use Symfony\Component\PropertyAccess\PropertyAccess;
use WellCommerce\Bundle\CoreBundle\Controller\Front\AbstractFrontController;

/**
 * Class AbstractFrontController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractBoxController extends AbstractFrontController implements BoxControllerInterface
{
    /**
     * All box controllers have default index action which returns only an empty array
     *
     * @return array
     */
    public function indexAction()
    {
        return [];
    }

    /**
     * Returns setting from box configuration
     *
     * @param string $index
     *
     * @return mixed|null
     */
    protected function getBoxParam($index, $default = null)
    {
        $request    = $this->get('request_stack')->getCurrentRequest();
        $accessor   = PropertyAccess::createPropertyAccessor();
        $parameters = $request->attributes->all();
        if ($accessor->isReadable($parameters, '[_box][settings][' . $index . ']')) {
            if (null !== $value = $accessor->getValue($parameters, '[_box][settings][' . $index . ']')) {
                return $value;
            }
        }

        return $default;
    }
}
