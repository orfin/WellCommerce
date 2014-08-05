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

namespace WellCommerce\Bundle\CoreBundle\Form\Rules;

use WellCommerce\Bundle\CoreBundle\Form\Rule;
use WellCommerce\Bundle\CoreBundle\Form\Node;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class Custom
 *
 * Validates field using callback function
 *
 * @package WellCommerce\Bundle\CoreBundle\Form\Rules
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Custom extends Rule implements RuleInterface
{

    protected $errorMsg;
    protected $container;
    protected $checkFunction;
    protected $jsFunction;
    protected $params;

    protected static $_nextId = 0;

    public function __construct($errorMsg, $checkFunctionCallback, $params, ContainerInterface $container)
    {
        parent::__construct($errorMsg);

        $this->errorMsg      = $errorMsg;
        $this->checkFunction = $checkFunctionCallback;
        $this->params        = $params;
        $this->container     = $container;
        $this->id            = self::$_nextId++;
        $this->jsFunction    = 'CheckCustomRule_' . $this->id;

        $this->container->get('xajax_manager')->registerFunction([
            $this->jsFunction,
            $this,
            'doAjaxCheck'
        ]);
    }

    public function doAjaxCheck($request)
    {
        return Array(
            'unique' => call_user_func($this->checkFunction, $request['value'], $request['params'])
        );
    }

    public function checkValue($value)
    {
        $params = [];
        foreach ($this->params as $paramName => $paramValue) {
            if ($paramValue instanceof Node) {
                $params[$paramName] = $paramValue->getValue();
            } else {
                $params[$paramName] = $paramValue;
            }
        }

        return (bool)call_user_func($this->checkFunction, $value, $params);
    }

    public function render()
    {
        $errorMsg = addslashes($this->errorMsg);
        $params   = [];
        foreach ($this->params as $paramName => $paramValue) {
            if ($paramValue instanceof Node) {
                $params['_field_' . $paramName] = $paramValue->getName();
            } else {
                $params[$paramName] = $paramValue;
            }
        }

        return "{sType: '{$this->getType()}', sErrorMessage: '{$errorMsg}', fCheckFunction: xajax_{$this->jsFunction}, oParams: " . json_encode($params) . "}";
    }

}
