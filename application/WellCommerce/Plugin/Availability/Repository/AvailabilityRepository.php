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
namespace WellCommerce\Plugin\Availability\Repository;

use WellCommerce\Core\Component\Repository\AbstractRepository;
use WellCommerce\Core\Component\Repository\RepositoryInterface;
use WellCommerce\Plugin\Availability\Model\Availability;
use WellCommerce\Plugin\Availability\Model\AvailabilityTranslation;

/**
 * Class AvailabilityAbstractRepository
 *
 * @package WellCommerce\Plugin\Availability\AbstractRepository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AvailabilityRepository extends AbstractRepository implements RepositoryInterface
{
    public function all()
    {
        return Availability::with('translation')->get();
    }

    public function find($id)
    {
        return Availability::with('translation')->findOrFail($id);
    }

    public function delete($id)
    {
        $this->dispatchEvent('availability.repository.pre_delete', [], $id);

        $this->transaction(function () use ($id) {
            return Availability::destroy($id);
        });

        $this->dispatchEvent('availability.repository.post_delete', [], $id);
    }

    public function save(array $data, $id = null)
    {
        $data = $this->dispatchEvent('availability.repository.pre_save', $data, $id);

        $this->transaction(function () use ($data, $id) {

            $availability = Availability::firstOrNew([
                'id' => $id
            ]);

            $availability->save();

            $accessor = $this->getPropertyAccessor();

            foreach ($this->getLanguageIds() as $language) {

                $translation = AvailabilityTranslation::firstOrNew([
                    'availability_id' => $availability->id,
                    'language_id'     => $language
                ]);

                $languageData = $accessor->getValue($data, sprintf('[required_data][language_data][%s]', $language));

                $translation->setTranslationData($languageData);
                $translation->save();
            }
        });

        $this->dispatchEvent('availability.repository.post_save', $data, $id);
    }
}
