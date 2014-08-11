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

use Doctrine\ORM\EntityRepository;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use WellCommerce\Bundle\CoreBundle\Form\Elements\Form;
use WellCommerce\Bundle\CoreBundle\Form\FormInterface;

/**
 * Class FormRequestHandler
 *
 * @package WellCommerce\Bundle\CoreBundle\Form\RequestHandler
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class FormRequestHandler implements FormRequestHandlerInterface
{

    private $form;
    private $eventDispatcher;
    private $request;
    private $entity;

    /**
     * Constructor
     *
     * @param FormInterface            $form
     * @param EventDispatcherInterface $eventDispatcher
     * @param FormRequestInterface     $request
     * @param EntityRepository         $entity
     */
    public function __construct(
        Form $form,
        EventDispatcherInterface $eventDispatcher,
        FormRequestInterface $request,
        EntityRepository $entity
    ) {
        $this->form            = $form;
        $this->eventDispatcher = $eventDispatcher;
        $this->request         = $request;
        $this->entity          = $entity;
    }

    public function isFormSubmitted()
    {
        return $this->form->isSubmitted();
    }

    public function isFormValid()
    {
        return $this->form->isValid();
    }
} 