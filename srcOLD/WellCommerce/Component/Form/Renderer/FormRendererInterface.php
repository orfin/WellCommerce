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

namespace WellCommerce\Component\Form\Renderer;

use WellCommerce\Component\Form\Elements\FormInterface;

/**
 * Interface FormRendererInterface
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
interface FormRendererInterface
{
    /**
     * Renders the form
     *
     * @param FormInterface $form
     *
     * @return string
     */
    public function renderForm(FormInterface $form);

    /**
     * Returns template name which will be used as a base template
     *
     * @return string
     */
    public function getTemplateName();
}
