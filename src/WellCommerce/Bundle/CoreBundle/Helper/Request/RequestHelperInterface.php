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

namespace WellCommerce\Bundle\CoreBundle\Helper\Request;

/**
 * Interface RequestHelperInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface RequestHelperInterface
{
    /**
     * Returns the master request
     *
     * @return null|\Symfony\Component\HttpFoundation\Request
     */
    public function getCurrentRequest();

    /**
     * Returns session attribute
     *
     * @param string $name
     * @param null   $default
     *
     * @return mixed
     */
    public function getSessionAttribute($name, $default = null);

    /**
     * Sets session attribute
     *
     * @param $name
     * @param $value
     *
     * @return mixed
     */
    public function setSessionAttribute($name, $value);

    /**
     * Returns true if session has attribute, else otherwise
     *
     * @param string $name
     *
     * @return mixed
     */
    public function hasSessionAttribute($name);

    /**
     * Returns the session's identifier
     *
     * @return string
     */
    public function getSessionId();

    /**
     * Returns the session's name
     *
     * @return string
     */
    public function getSessionName();

    /**
     * Returns current host
     *
     * @param null $fallbackHost
     *
     * @return string|null
     */
    public function getCurrentHost();

    /**
     * Returns current locale
     *
     * @return string
     */
    public function getCurrentLocale();

    /**
     * Returns current currency
     *
     * @return string
     */
    public function getCurrentCurrency();

    /**
     * Returns a param from query bag
     *
     * @param string $name
     * @param null   $default
     * @param int    $filter
     *
     * @return mixed
     */
    public function getQueryBagParam($name, $default = null, $filter = FILTER_SANITIZE_SPECIAL_CHARS);

    /**
     * Checks whether request has given attribute
     *
     * @param string $name
     *
     * @return bool
     */
    public function hasRequestBagParam($name);

    /**
     * Checks whether request has given attributes
     *
     * @param array $params
     *
     * @return bool
     */
    public function hasRequestBagParams(array $params = []);

    /**
     * Returns a param from request bag
     *
     * @param string $name
     * @param null   $default
     * @param int    $filter
     *
     * @return mixed
     */
    public function getRequestBagParam($name, $default = null, $filter = FILTER_SANITIZE_SPECIAL_CHARS);

    /**
     * Checks whether request has given attribute
     *
     * @param string $name
     *
     * @return bool
     */
    public function hasAttributesBagParam($name);

    /**
     * Checks whether request has given attributes
     *
     * @param array $params
     *
     * @return bool
     */
    public function hasAttributesBagParams(array $params = []);

    /**
     * Returns a param from attributes bag
     *
     * @param string $name
     * @param null   $default
     * @param int    $filter
     *
     * @return mixed
     */
    public function getAttributesBagParam($name, $default = null, $filter = FILTER_SANITIZE_SPECIAL_CHARS);
}
