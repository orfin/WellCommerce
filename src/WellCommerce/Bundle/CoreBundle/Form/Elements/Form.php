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
     * @var object
     */
    protected $modelData;

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'label'  => '',
            'action' => '',
            'method' => FormInterface::FORM_METHOD,
            'tabs'   => FormInterface::TABS_VERTICAL,
        ]);

        $resolver->setAllowedTypes([
            'action' => 'string',
            'method' => 'string',
            'tabs'   => 'integer',
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
    public function setModelData($modelData)
    {
        $this->modelData = $modelData;
    }

    /**
     * {@inheritdoc}
     */
    public function getModelData()
    {
        return $this->formHandler->getFormModelData();
    }

    /**
     * {@inheritdoc}
     */
    public function handleRequest()
    {
        return $this->formHandler->handleRequest($this);
    }

    /**
     * {@inheritdoc}
     */
    public function isValid()
    {
        return $this->formHandler->isFormValid($this);
    }

    /**
     * {@inheritdoc}
     */
    public function isAction($actionName)
    {
        return $this->formHandler->isFormAction($actionName);
    }

    /**
     * {@inheritdoc}
     */
    public function prepareAttributesCollection(AttributeCollection $collection)
    {
        parent::prepareAttributesCollection($collection);

        $collection->add(new Attribute('sFormName', $this->getName()));
        $collection->add(new Attribute('sAction', $this->getOption('action')));
        $collection->add(new Attribute('sMethod', $this->getOption('method')));
        $collection->add(new Attribute('sClass', $this->getOption('class')));
        $collection->add(new Attribute('iTabs', $this->getOption('tabs'), Attribute::TYPE_INTEGER));
        $collection->add(new Attribute('oValues', $this->getValue(), Attribute::TYPE_ARRAY));
        $collection->add(new Attribute('oErrors', [], Attribute::TYPE_ARRAY));

        $collection->remove('sName');
        $collection->remove('fType');
    }
}
