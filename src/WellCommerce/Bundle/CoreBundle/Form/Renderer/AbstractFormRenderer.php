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

namespace WellCommerce\Bundle\CoreBundle\Form\Renderer;

use WellCommerce\Bundle\CoreBundle\Form\Formatter\FormatterInterface;

/**
 * Class AbstractFormRenderer
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractFormRenderer
{
    /**
     * @var FormatterInterface
     */
    protected $formatter;

    /**
     * @var string
     */
    protected $template;

    /**
     * Constructor
     *
     * @param FormatterInterface $formatter
     * @param                    $template
     */
    public function __construct(FormatterInterface $formatter, $template)
    {
        $this->formatter = $formatter;
        $this->template  = $template;
    }
}
