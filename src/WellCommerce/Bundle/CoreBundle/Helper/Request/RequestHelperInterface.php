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
     * Returns the session identifier
     *
     * @return string
     */
    public function getSessionId();

    /**
     * Returns the request attribute from request
     *
     * @param string $name
     * @param null   $default
     *
     * @return mixed
     */
    public function getRequestAttribute($name, $default = null);

    /**
     * Checks whether request contains request attribute
     *
     * @param string $name
     *
     * @return mixed
     */
    public function hasRequestAttribute($name);

    /**
     * Returns the attribute from query string
     *
     * @param string $name
     * @param null   $default
     *
     * @return mixed
     */
    public function getQueryAttribute($name, $default = null);

    /**
     * Checks whether query string contains attribute
     *
     * @param string $name
     *
     * @return mixed
     */
    public function hasQueryAttribute($name);

    /**
     * Returns the attribute from request
     *
     * @param string $name
     * @param null   $default
     *
     * @return mixed
     */
    public function getAttribute($name, $default = null);

    /**
     * Checks whether request contains attribute
     *
     * @param string $name
     *
     * @return mixed
     */
    public function hasAttribute($name);

    /**
     * Returns the signed-in admin from security context
     *
     * @return null|\WellCommerce\Bundle\UserBundle\Entity\User
     */
    public function getAdmin();

    /**
     * Returns the signed-in client from security context
     *
     * @return null|\WellCommerce\Bundle\ClientBundle\Entity\Client
     */
    public function getClient();

    /**
     * Returns current host name
     *
     * @return string
     */
    /**
     * Returns current host
     *
     * @param null $fallbackHost
     *
     * @return string|null
     */
    public function getCurrentHost();

    /**
     * Returns current offset
     *
     * @param number $limit
     *
     * @return int|number
     */
    public function getCurrentOffset($limit);

    /**
     * Returns current page
     *
     * @return number
     */
    public function getCurrentPage();

    /**
     * Returns current limit
     *
     * @param mixed $default
     *
     * @return number
     */
    public function getCurrentLimit($default);

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
}
