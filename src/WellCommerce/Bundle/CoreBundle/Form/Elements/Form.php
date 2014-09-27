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

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class Form
 *
 * @package WellCommerce\Bundle\CoreBundle\Form\Elements
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Form extends AbstractContainer
{
    const FORMAT_GROUPED  = 0;
    const FORMAT_FLAT     = 1;
    const TABS_VERTICAL   = 0;
    const TABS_HORIZONTAL = 1;
    const FORM_METHOD     = 'POST';

    public $fields = [];
    public $_values = [];
    public $_flags = [];
    public $_populatingWholeForm = false;
    protected $defaultData;
    protected $isSubmitted = false;
    protected $request;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->form = $this;
    }

    /**
     * Configures Form attributes
     *
     * @param OptionsResolverInterface $resolver
     */
    public function configureAttributes(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired([
            'name'
        ]);

        $resolver->setOptional([
            'class',
            'action',
            'method',
            'tabs',
            'property_path',
            'dependencies',
            'property_path',
            'dependencies',
            'filters',
            'rules'
        ]);

        $resolver->setDefaults([
            'action'        => '',
            'class'         => '',
            'method'        => self::FORM_METHOD,
            'tabs'          => self::TABS_VERTICAL,
            'property_path' => null,
            'dependencies'  => [],
            'filters'       => [],
            'rules'         => [],
        ]);

        $resolver->setAllowedTypes([
            'class'  => 'string',
            'action' => 'string',
            'method' => 'string',
            'tabs'   => 'integer'
        ]);

    }

    /**
     * Returns flattened $_POST data
     *
     * @return array|mixed
     */
    public function getSubmitValuesFlat()
    {
        return $this->getValues(self::FORMAT_FLAT);
    }

    /**
     * Returns grouped $_POST data
     *
     * @return array|mixed
     */
    public function getSubmitValuesGrouped()
    {
        return $this->getValues(self::FORMAT_GROUPED);
    }

    public function getValues($flags = 0)
    {
        $values = [];
        if ($flags & self::FORMAT_FLAT) {
            foreach ($this->fields as $field) {
                if ($field instanceof AbstractField) {
                    $values = array_merge_recursive($values, [
                        $field->getName() => $field->getValue()
                    ]);
                }
            }

            return $values;

        } else {

            return $this->harvest([
                $this,
                'harvestValues'
            ]);
        }
    }

    /**
     * Returns an array containing all form errors
     *
     * @return array|mixed
     */
    public function getErrors()
    {
        return $this->harvest([$this, 'harvestErrors']);
    }

    /**
     * Returns form data flag
     *
     * @return array
     */
    public function getFlags()
    {
        return $this->_flags;
    }

    /**
     * Populates the form with values
     *
     * @param     $value
     * @param int $flags
     */
    public function populate($value, $flags = 0)
    {
        if ($flags & self::FORMAT_FLAT) {

            return;
        } else {
            $this->_values = $this->_values + $value;
        }
        $this->_populatingWholeForm = true;
        parent::populate($value);
        $this->_populatingWholeForm = false;
    }

    /**
     * Sets default data for each field
     *
     * @param $data
     *
     * @return $this
     */
    public function setDefaultData($data)
    {
        $isNewResource     = $this->isNewResource($data);
        $this->defaultData = $data;
        parent::setDefaults($this->defaultData, $isNewResource);

        return $this;
    }

    public function getDefaultData()
    {
        return $this->defaultData;
    }

    /**
     * Handles form request. Modifies default entity data using field values
     *
     * @param Request $request
     *
     * @return $this
     */
    public function handleRequest(Request $request)
    {
        $this->request = $request;

        // don't validate the form if it wasn't submitted
        if (!$this->isSubmitted()) {
            return $this;
        }

        // first populate the form with submitted values
        $this->populate($this->getSubmittedData());

        /**
         * @var $field ElementInterface
         */
        foreach ($this->fields as $field) {
            if (is_array($field)) {
                /**
                 * @var $element ElementInterface
                 */
                foreach ($field as $element) {
                    if($element instanceof ElementInterface){
                        $element->handleRequest($this->defaultData);
                    }

                }
            } else {
                $field->handleRequest($this->defaultData);
            }

        }

        return $this;
    }

    /**
     * Checks whether form is submitted.
     * Submitted form adds additional parameter to request
     *
     * @return bool
     */
    public function isSubmitted()
    {
        return $this->request->request->has($this->attributes['name'] . '_submitted');
    }

    /**
     * Validates the form
     *
     * @return bool
     */
    public function isValid()
    {
        // don't validate the form if it wasn't submitted
        if (!$this->isSubmitted()) {
            return false;
        }

        // harvest submit values
        $values = $this->getSubmittedData();

        // populate the form with submitted values
        $this->populate($values);

        return parent::validate($this->defaultData);
    }

    public function getSubmittedData()
    {
        return $this->request->request->all();
    }

    public function isAction($actionName)
    {
        $actionName = '_Action_' . $actionName;

        return $this->request->request->has($actionName);
    }
}
