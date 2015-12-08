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

namespace WellCommerce\Component\Form\Request;

use Symfony\Component\HttpFoundation\RequestStack;
use WellCommerce\Component\Form\Elements\FormInterface;

/**
 * Class FormRequestHandler
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class FormRequestHandler implements FormRequestHandlerInterface
{
    /**
     * @var null|\Symfony\Component\HttpFoundation\Request
     */
    protected $request;

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
     * {@inheritdoc}
     */
    public function getFormSubmitValues()
    {
        return $this->request->request->all();
    }

    /**
     * {@inheritdoc}
     */
    public function isSubmitted(FormInterface $form)
    {
        $hasAttribute  = $this->request->request->has(sprintf('%s_submitted', $form->getName()));
        $isValidMethod = $this->request->isMethod($form->getOption('method'));

        return ($hasAttribute && $isValidMethod);
    }

    /**
     * {@inheritdoc}
     */
    public function isFormAction($actionName)
    {
        $actionName = '_Action_'.$actionName;

        return $this->request->request->has($actionName);
    }
}
