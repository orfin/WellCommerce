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
    /**
     * @var null|\Symfony\Component\HttpFoundation\Request
     */
    protected $request;

    /**
     * @var
     */
    protected $form;

    /**
     * Constructor
     *
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->request = $requestStack->getCurrentRequest();
    }

    /**
     * Handles form submission
     *
     * @param FormInterface $form
     */
    public function handleRequest(FormInterface $form)
    {
        if (!$this->isSubmitted($form)) {
            return $form;
        }
        print_r($this->request->request);
        print_r($form);
        print_r($this->request);
        die();
    }

    /**
     * Checks whether form was submitted
     *
     * @param FormInterface $form
     *
     * @return bool
     */
    protected function isSubmitted(FormInterface $form)
    {
        $attribute = sprintf('%s_submitted', $form->getName());

        return $this->request->request->has($attribute);
    }
} 