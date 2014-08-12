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

namespace WellCommerce\Bundle\LocaleBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Exception\ValidatorException;
use WellCommerce\Bundle\LocaleBundle\Repository\LocaleRepositoryInterface;
use WellCommerce\Bundle\LocaleBundle\Entity\Locale;
use WellCommerce\Bundle\CoreBundle\Controller\Admin\AbstractAdminController;

/**
 * Class LocaleController
 *
 * @package WellCommerce\Bundle\LocaleBundle\Controller
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * @Template()
 */
class LocaleController extends AbstractAdminController
{
    public function indexAction()
    {
        return [
            'datagrid' => $this->getDataGrid($this->get('locale.datagrid'))
        ];
    }


    /**
     * Returns locale form
     *
     * @param Locale $locale
     *
     * @return \WellCommerce\Bundle\CoreBundle\Form\Elements\Form
     */
    public function getLocaleForm(Locale $locale)
    {
        return $this->getFormBuilder($this->get('locale.form'), $locale, [
            'name' => 'locale'
        ]);
    }

    /**
     * Sets repository object
     *
     * @param LocaleRepositoryInterface $repository
     */
    public function setRepository(LocaleRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}
