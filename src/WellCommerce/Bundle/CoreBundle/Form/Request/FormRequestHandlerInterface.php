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

namespace WellCommerce\Bundle\CoreBundle\Form\RequestHandler;

/**
 * Interface FormRequestHandlerInterface
 *
 * @package WellCommerce\Bundle\CoreBundle\Form\RequestHandler
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface FormRequestHandlerInterface {

    public function isSubmitted();

    public function isValid();

    public function prepareData();
} 