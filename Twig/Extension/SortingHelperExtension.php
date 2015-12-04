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
namespace WellCommerce\Bundle\CoreBundle\Twig\Extension;

use WellCommerce\Bundle\CoreBundle\Helper\Helper;
use WellCommerce\Bundle\CoreBundle\Helper\Request\RequestHelperInterface;
use WellCommerce\Bundle\CoreBundle\Helper\Translator\TranslatorHelperInterface;

/**
 * Class SortingHelperExtension
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class SortingHelperExtension extends \Twig_Extension
{
    /**
     * @var RequestHelperInterface
     */
    protected $requestHelper;

    /**
     * @var TranslatorHelperInterface
     */
    protected $translatorHelper;

    /**
     * SortingHelperExtension constructor.
     *
     * @param RequestHelperInterface    $requestHelper
     * @param TranslatorHelperInterface $translatorHelper
     */
    public function __construct(RequestHelperInterface $requestHelper, TranslatorHelperInterface $translatorHelper)
    {
        $this->requestHelper    = $requestHelper;
        $this->translatorHelper = $translatorHelper;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('sortingOptions', [$this, 'getSortingOptions'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('activeSorting', [$this, 'getActiveSortingOption'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'sorting_helper';
    }

    /**
     * Returns the sorting options for given columns
     *
     * @param array $columns
     *
     * @return array
     */
    public function getSortingOptions(array $columns = [])
    {
        $sorting = [];
        foreach ($columns as $column => $directions) {
            foreach ($directions as $direction) {
                $label  = sprintf('product.options.order_by.%s.%s', Helper::snake($column), $direction);
                $active = $this->checkSortingIsActive($column, $direction);

                $sorting[] = [
                    'orderBy'  => $column,
                    'orderDir' => $direction,
                    'label'    => $this->translatorHelper->trans($label),
                    'active'   => $active
                ];
            }
        }

        return $sorting;
    }

    /**
     * Checks whether the sorting option is active
     *
     * @param $column
     * @param $direction
     *
     * @return bool
     */
    protected function checkSortingIsActive($column, $direction)
    {
        $currentOrderBy  = $this->requestHelper->getAttributesBagParam('orderBy');
        $currentOrderDir = $this->requestHelper->getAttributesBagParam('orderDir');

        return $column === $currentOrderBy && $direction === $currentOrderDir;
    }
}
