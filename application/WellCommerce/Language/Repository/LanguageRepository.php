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
namespace WellCommerce\Language\Repository;

use Symfony\Component\Intl\Intl;
use WellCommerce\Core\Component\Repository\AbstractRepository;
use WellCommerce\Language\Model\Language;

/**
 * Class LanguageAbstractRepository
 *
 * @package WellCommerce\Language\AbstractRepository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LanguageRepository extends AbstractRepository implements LanguageRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return Language::all();
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return Language::with('currency')->findOrFail($id);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        $language = $this->find($id);
        $language->delete();
        $this->dispatchEvent(LanguageRepositoryInterface::POST_DELETE_EVENT, $language);
    }

    /**
     * {@inheritdoc}
     */
    public function save(array $data, $id = null)
    {
        $this->transaction(function () use ($data, $id) {

            $language = Language::firstOrCreate([
                'id' => $id
            ]);

            $data = $this->dispatchEvent(LanguageRepositoryInterface::PRE_SAVE_EVENT, $language, $data);

            $language->update($data);

            $this->dispatchEvent(LanguageRepositoryInterface::POST_SAVE_EVENT, $language, $data);
        });
    }

    /**
     * {@inheritdoc}
     */
    public function getPopulateData($id)
    {
        $languageData = $this->find($id);
        $populateData = [];
        $accessor     = $this->getPropertyAccessor();

        $accessor->setValue($populateData, '[required_data]', [
            'name'        => $languageData->name,
            'translation' => $languageData->translation,
            'locale'      => $languageData->locale,
        ]);

        $accessor->setValue($populateData, '[currency_data]', [
            'currency_id' => $languageData->currency_id
        ]);

        return $populateData;
    }

    /**
     * {@inheritdoc}
     */
    public function getAllLanguageToSelect()
    {
        return $this->all()->toSelect('id', 'name');
    }

    /**
     * {@inheritdoc}
     */
    public function getAllLocaleToSelect()
    {
        $locales = Intl::getLocaleBundle()->getLocaleNames();

        $Data = [];

        foreach ($locales as $locale => $name) {
            $Data[$locale] = sprintf('%s (%s)', $name, $locale);
        }

        return $Data;
    }
}