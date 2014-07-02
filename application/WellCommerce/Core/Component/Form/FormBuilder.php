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

namespace WellCommerce\Core\Component\Form;

use WellCommerce\Core\Component\AbstractComponent;
use WellCommerce\Core\Component\Form\Conditions\ConditionInterface;
use WellCommerce\Core\Component\Form\Elements\ElementInterface;
use WellCommerce\Core\Component\Model\ModelInterface;
use WellCommerce\Core\Event\FormEvent;

/**
 * Class FormBuilder
 *
 * @package WellCommerce\Core\Component\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class FormBuilder extends AbstractComponent
{
    const FORM_INIT_EVENT = 'form.init';

    protected $form;
    protected $formData;
    protected $options;

    /**
     * Creates the form, triggers init event and then populates form with values
     *
     * @param FormInterface  $form
     * @param ModelInterface $model
     * @param array          $options
     *
     * @return $this
     */
    public function create(FormInterface $form, $model = null, array $options)
    {
        $this->form     = $form->buildForm($this, $options);
        $this->formData = (null === $model) ? [] : $form->prepareData($model);
        $this->dispatchEvent($this->getInitEventName($options['name']));
        $this->options = $options;
        $this->form->populate($this->formData);

        return $this;
    }

    /**
     * Triggers the event for form action
     *
     * @param       $eventName
     * @param array $data
     * @param       $id
     */
    private function dispatchEvent($eventName)
    {
        $event = new FormEvent($this);
        $this->getDispatcher()->dispatch($eventName, $event);
    }

    /**
     * Returns init event name
     *
     * @param $formName
     *
     * @return string
     */
    private function getInitEventName($formName)
    {
        return sprintf('%s.%s', $formName, self::FORM_INIT_EVENT);
    }

    /**
     * Returns Form object
     *
     * @return mixed
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * Returns form data
     *
     * @return mixed
     */
    public function getFormData()
    {
        return $this->formData;
    }

    /**
     * Sets new form data
     *
     * @return mixed
     */
    public function setFormData(array $data)
    {
        $this->formData = $data;
    }

    /**
     * Shortcut for adding Form
     *
     * @param array $options
     *
     * @return Elements\Form
     */
    public function addForm(array $options)
    {
        return new Elements\Form($options);
    }

    /**
     * Shortcut for adding Fieldset node
     *
     * @param array $options
     *
     * @return Elements\Fieldset
     */
    public function addFieldset(array $options)
    {
        return new Elements\Fieldset($options);
    }

    /**
     * Shortcut for adding FieldsetRepeatable node
     *
     * @param array $options
     *
     * @return Elements\FieldsetRepeatable
     */
    public function addFieldsetRepeatable(array $options)
    {
        return new Elements\FieldsetRepeatable($options);
    }

    /**
     * Shortcut for adding LayoutBoxesList element
     *
     * @param array $options
     *
     * @return Elements\FieldsetRepeatable
     */
    public function addLayoutBoxesList(array $options)
    {
        return new Elements\LayoutBoxesList($options);
    }

    /**
     * Shortcut for adding FieldsetLanguage node
     *
     * @param array $options
     *
     * @return Elements\FieldsetLanguage
     */
    public function addFieldsetLanguage(array $options)
    {
        $options['languages'] = $this->getLanguages();

        return new Elements\FieldsetLanguage($options);
    }

    /**
     * Shortcut for adding Image element
     *
     * @param $options
     *
     * @return Elements\Image
     */
    public function addImage($options)
    {
        $options['file_types_description'] = $this->trans('Files description');

        return new Elements\Image($options, $this->container);
    }

    /**
     * Shortcut for adding LocalFile element
     *
     * @param $options
     *
     * @return Elements\LocalFile
     */
    public function addLocalFile($options)
    {
        $options['file_types_description'] = $this->trans('Files description');

        return new Elements\LocalFile($options, $this->container);
    }

    /**
     * Shortcut for adding Tip element
     *
     * @param $options
     *
     * @return Elements\Tip
     */
    public function addTip($options)
    {
        return new Elements\Tip($options);
    }

    /**
     * Shortcut for adding TextField element
     *
     * @param array $options
     *
     * @return Elements\TextField
     */
    public function addTextField(array $options)
    {
        return new Elements\TextField($options);
    }

    /**
     * Shortcut for adding Password element
     *
     * @param array $options
     *
     * @return Elements\Password
     */
    public function addPassword(array $options)
    {
        return new Elements\Password($options);
    }

    /**
     * Shortcut for adding Submit buttons
     *
     * @param array $options
     *
     * @return Elements\Submit
     */
    public function addSubmitButton(array $options)
    {
        return new Elements\Submit($options);
    }


    /**
     * Shortcut for adding Textarea element
     *
     * @param array $options
     *
     * @return Elements\Textarea
     */
    public function addTextArea(array $options)
    {
        return new Elements\Textarea($options);
    }

    /**
     * Shortcut for adding RichTextEditor element
     *
     * @param array $options
     *
     * @return Elements\RichTextEditor
     */
    public function addRichTextEditor(array $options)
    {
        return new Elements\RichTextEditor($options);
    }

    /**
     * Shortcut for adding ShopSelector element
     *
     * @param array $options
     *
     * @return Elements\ShopSelector
     */
    public function addShopSelector(array $options)
    {
        return new Elements\ShopSelector($options, $this->get('company.repository'));
    }

    /**
     * Shortcut for adding Select element
     *
     * @param array $options
     *
     * @return Elements\Select
     */
    public function addSelect(array $options)
    {
        return new Elements\Select($options);
    }

    /**
     * Shortcut for adding MultiSelect element
     *
     * @param array $options
     *
     * @return Elements\MultiSelect
     */
    public function addMultiSelect(array $options)
    {
        return new Elements\MultiSelect($options);
    }

    /**
     * Shortcut for adding Checkbox element
     *
     * @param array $options
     *
     * @return Elements\Checkbox
     */
    public function addCheckBox(array $options)
    {
        return new Elements\Checkbox($options);
    }

    /**
     * Shortcut for adding StaticText element
     *
     * @param array $options
     *
     * @return Elements\StaticText
     */
    public function addStaticText(array $options)
    {
        return new Elements\StaticText($options);
    }

    /**
     * Shortcut for adding AttributeEditor element
     *
     * @param array $options
     *
     * @return Elements\AttributeEditor
     */
    public function addAttributeEditor(array $options)
    {
        return new Elements\AttributeEditor($options, $this->get('attribute.repository'));
    }

    /**
     * Shortcut for adding Price element
     *
     * @param array $options
     *
     * @return Elements\Price
     */
    public function addPrice(array $options)
    {
        return new Elements\Price($options);
    }

    /**
     * Shortcut for adding filter CommaToDotChanger
     *
     * @return Filters\CommaToDotChanger
     */
    public function addFilterCommaToDotChanger()
    {
        return new Filters\CommaToDotChanger();
    }

    /**
     * Shortcut for adding filter NoCode
     *
     * @return Filters\NoCode
     */
    public function addFilterNoCode()
    {
        return new Filters\NoCode();
    }

    /**
     * Shortcut for adding filter Trim
     *
     * @return Filters\Trim
     */
    public function addFilterTrim()
    {
        return new Filters\Trim();
    }

    /**
     * Shortcut for adding filter Secure
     *
     * @return Filters\Secure
     */
    public function addFilterSecure()
    {
        return new Filters\Secure();
    }

    /**
     * Shortcut for adding rule Format
     *
     * @param $errorMessage
     * @param $pattern
     *
     * @return Rules\Format
     */
    public function addRuleFormat($errorMessage, $pattern)
    {
        return new Rules\Format($errorMessage, $pattern);
    }

    /**
     * Shortcut for adding rule Email
     *
     * @param $errorMessage
     *
     * @return Rules\Email
     */
    public function addRuleEmail($errorMessage)
    {
        return new Rules\Email($errorMessage);
    }

    /**
     * Shortcut for adding rule Custom
     *
     * @param          $errorMessage
     * @param callable $function
     * @param array    $params
     *
     * @return Rules\Custom
     */
    public function addRuleCustom($errorMessage, \Closure $function, array $params = [])
    {
        return new Rules\Custom($errorMessage, $function, $params, $this->container);
    }

    /**
     * Shortcut for adding rule Required
     *
     * @param $errorMessage
     *
     * @return Rules\Required
     */
    public function addRuleRequired($errorMessage)
    {
        return new Rules\Required($errorMessage);
    }

    /**
     * Shortcut for adding rule Unique
     *
     * @param       $errorMessage
     * @param array $options
     *
     * @return Rules\Unique
     */
    public function addRuleUnique($errorMessage, array $options)
    {
        return new Rules\Unique($errorMessage, $options, $this->container);
    }

    /**
     * Shortcut for adding rule LanguageUnique
     *
     * @param       $errorMessage
     * @param array $options
     *
     * @return Rules\LanguageUnique
     */
    public function addRuleLanguageUnique($errorMessage, array $options)
    {
        return new Rules\LanguageUnique($errorMessage, $options, $this->container);
    }

    /**
     * Processes options for using them in Select
     *
     * @param      $options
     * @param bool $appendDefaultValue
     *
     * @return array
     */
    public function makeOptions($options, $appendDefaultValue = false)
    {
        if (true === $appendDefaultValue) {
            $options['0'] = $this->trans('Choose option');
        }

        ksort($options);

        return Option::Make($options);
    }

    /**
     * Shortcut for adding Tree element
     *
     * @param array $options
     *
     * @return Elements\Tree
     */
    public function addTree(array $options)
    {
        return new Elements\Tree($options, $this->container);
    }

    public function addSortableList(array $options)
    {
        return new Elements\SortableList($options, $this->container);
    }

    /**
     * Shortcut for adding RangeEditor element
     *
     * @param array $options
     *
     * @return Elements\RangeEditor
     */
    public function addRangeEditor(array $options)
    {
        $options['prefixes'] = [
            $this->trans('net'),
            $this->trans('gross')
        ];

        $options['vat_values'] = $this->get('tax.repository')->getAllTaxToSelect();

        return new Elements\RangeEditor($options, $this->get('tax.repository'));
    }

    /**
     * Shortcut for adding Dependency
     *
     * @param                    $type
     * @param ElementInterface   $element
     * @param ConditionInterface $condition
     * @param                    $argument
     *
     * @return Dependency
     */
    public function addDependency($type, ElementInterface $element, ConditionInterface $condition, $argument)
    {
        return new Dependency($type, $element, $condition, $argument, $this->container);
    }
}