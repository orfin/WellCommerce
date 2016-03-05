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
namespace WellCommerce\Bundle\DictionaryBundle\Repository;

use WellCommerce\Bundle\DoctrineBundle\Repository\AbstractEntityRepository;

/**
 * Class DictionaryRepository
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DictionaryRepository extends AbstractEntityRepository implements DictionaryRepositoryInterface
{
    /**
     * @var array
     */
    private $domains = ['admin', 'front', 'flashes', 'validators'];

    /**
     * Returns possible translation domains
     *
     * @return array
     */
    public function getTranslationDomains()
    {
        $domains = [];
        foreach ($this->domains as $domain) {
            $domains[$domain] = $domain;
        }

        return $domains;
    }

    /**
     * {@inheritdoc}
     */
    public function getDictionaryTranslations()
    {
        $qb = parent::getQueryBuilder()
            ->leftJoin('WellCommerce\Bundle\DictionaryBundle\Entity\DictionaryTranslation',
                'dictionary_translation',
                'WITH',
                'dictionary.id = dictionary_translation.translatable')
            ->groupBy('dictionary.identifier, dictionary_translation.locale')
            ->select('dictionary.identifier,dictionary_translation.locale,dictionary_translation.translation');

        $query = $qb->getQuery();

        return $query->getArrayResult();
    }
}
