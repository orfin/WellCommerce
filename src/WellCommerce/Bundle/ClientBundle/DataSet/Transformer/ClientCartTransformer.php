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

namespace WellCommerce\Bundle\ClientBundle\DataSet\Transformer;

use WellCommerce\Bundle\CoreBundle\Helper\Translator\TranslatorHelperInterface;
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;
use WellCommerce\Bundle\OrderBundle\Repository\OrderRepositoryInterface;
use WellCommerce\Component\DataSet\Transformer\AbstractDataSetTransformer;

/**
 * Class ClientCartTransformer
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class ClientCartTransformer extends AbstractDataSetTransformer
{
    /**
     * @var TranslatorHelperInterface
     */
    private $translatorHelper;
    
    /**
     * @var OrderRepositoryInterface
     */
    private $repository;
    
    /**
     * ClientCartTransformer constructor.
     *
     * @param TranslatorHelperInterface $translatorHelper
     * @param OrderRepositoryInterface  $repository
     */
    public function __construct(TranslatorHelperInterface $translatorHelper, OrderRepositoryInterface $repository)
    {
        $this->translatorHelper = $translatorHelper;
        $this->repository       = $repository;
    }
    
    public function transformValue($orderId)
    {
        $lines = [];
        $order = $this->repository->find($orderId);
        if ($order instanceof OrderInterface) {
            $lines[] = sprintf(
                '<strong>%s:</strong> %s %s',
                $this->translatorHelper->trans('order.label.summary.gross_amount'),
                $order->getSummary()->getGrossAmount(),
                $order->getCurrency()
            );
            
            $lines[] = sprintf(
                '<strong>%s:</strong> %s',
                $this->translatorHelper->trans('order.label.quantity'),
                $order->getProducts()->count()
            );
            
            $lines[] = sprintf(
                '<strong>%s:</strong> %s',
                $this->translatorHelper->trans('common.label.created_at'),
                $order->getCreatedAt()->format('Y-m-d H:i:s')
            );
            
            $lines[] = sprintf(
                '<strong>%s:</strong> %s',
                $this->translatorHelper->trans('common.label.updated_at'),
                $order->getUpdatedAt()->format('Y-m-d H:i:s')
            );
        }
        
        return implode('<br />', $lines);
    }
}
