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
    public function getSessionAttribute(string $name, $default = null);

    /**
     * Sets session attribute
     *
     * @param string $name
     * @param mixed  $value
     *
     * @return mixed
     */
    public function setSessionAttribute(string $name, $value);

    /**
     * Returns true if session has attribute, else otherwise
     *
     * @param string $name
     *
     * @return bool
     */
    public function hasSessionAttribute(string $name) : bool;

    /**
     * Returns the session's identifier
     *
     * @return string
     */
    public function getSessionId() : string;

    /**
     * Returns the session's name
     *
     * @return string
     */
    public function getSessionName() : string;

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
    public function getCurrentLocale() : string;

    /**
     * Returns current currency
     *
     * @return string
     */
    public function getCurrentCurrency() : string;

    /**
     * Returns a param from query bag
     *
     * @param string $name
     * @param null   $default
     * @param int    $filter
     *
     * @return mixed
     */
    public function getQueryBagParam(string $name, $default = null, int $filter = FILTER_SANITIZE_SPECIAL_CHARS);

    /**
     * Checks whether request has given attribute
     *
     * @param string $name
     *
     * @return bool
     */
    public function hasRequestBagParam(string $name) : bool;

    /**
     * Checks whether request has given attributes
     *
     * @param array $params
     *
     * @return bool
     */
    public function hasRequestBagParams(array $params = []) : bool;

    /**
     * Returns a param from request bag
     *
     * @param string $name
     * @param null   $default
     * @param int    $filter
     *
     * @return mixed
     */
    public function getRequestBagParam(string $name, $default = null, int $filter = FILTER_SANITIZE_SPECIAL_CHARS);

    /**
     * Checks whether request has given attribute
     *
     * @param string $name
     *
     * @return bool
     */
    public function hasAttributesBagParam(string $name) : bool;

    /**
     * Checks whether request has given attributes
     *
     * @param array $params
     *
     * @return bool
     */
    public function hasAttributesBagParams(array $params = []) : bool;

    /**
     * Returns a param from attributes bag
     *
     * @param string $name
     * @param null   $default
     * @param int    $filter
     *
     * @return mixed
     */
    public function getAttributesBagParam(string $name, $default = null, int $filter = FILTER_SANITIZE_SPECIAL_CHARS);
}
