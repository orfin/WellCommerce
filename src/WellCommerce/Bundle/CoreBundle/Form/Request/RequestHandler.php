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

namespace WellCommerce\Bundle\CoreBundle\Form\Request;

use Symfony\Component\HttpFoundation\RequestStack;
use WellCommerce\Bundle\CoreBundle\Form\Elements\FormInterface;

/**
 * Class RequestHandler
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class RequestHandler implements RequestHandlerInterface
{
    protected $request;

    public function __construct(RequestStack $requestStack)
    {
        $this->request = $requestStack->getCurrentRequest();
    }

    public function handleRequest(FormInterface $form)
    {
        print_r($form);
        print_r($this->request);
        die();
    }

    protected function isSubmitted(){

    }
} 