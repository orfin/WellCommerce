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

namespace WellCommerce\Bundle\CoreBundle\Form\Elements;

use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Bundle\CoreBundle\Form\Handler\FormHandlerInterface;

/**
 * Class Form
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class Form extends AbstractContainer implements FormInterface
{
    /**
     * @var FormHandlerInterface
     */
    protected $formHandler;

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefined([
            'action',
            'method',
            'tabs',
        ]);

        $resolver->setDefaults([
            'label'  => '',
            'action' => '',
            'method' => FormInterface::FORM_METHOD,
            'tabs'   => FormInterface::TABS_VERTICAL,
        ]);

        $resolver->setAllowedTypes([
            'action' => 'string',
            'method' => 'string',
            'tabs'   => 'integer'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function setFormHandler(FormHandlerInterface $formHandler)
    {
        $this->formHandler = $formHandler;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultFormData($data)
    {
        return $this->formHandler->setDefaultFormData($this, $data);
    }

    public function handleRequest()
    {
        return $this->formHandler->handleRequest($this);
    }

    public function isValidRequest()
    {
        return $this->formHandler->isValidRequest($this);
    }

    public function prepareAttributes()
    {
        return [
            'sFormName' => $this->getName(),
            'sAction'   => $this->getOption('action'),
            'sClass'    => $this->getOption('class'),
            'iTabs'     => $this->getOption('tabs'),
            'oValues'   => $this->getValue(),
            'oErrors'   => [],
        ];
    }
}