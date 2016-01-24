<?php

# WellCommerce Open-Source E-Commerce Platform
#
# This file is part of the WellCommerce package.
# (c) Adam Piotrowski <adam@wellcommerce.org>
#
# For the full copyright and license information,
# please view the LICENSE file that was distributed with this source code.

namespace WellCommerce\Bundle\AvailabilityBundle\Entity {

    /**
     * Class AvailabilityTranslationExtended
     *
     * The file was auto-generated.
     *
     * @author Adam Piotrowski <adam@wellcommerce.org>
     */
    class AvailabilityTranslationExtended extends AvailabilityTranslation {

        protected $type;

        public function getType() {
            return $this->type;
        }

        public function setType($type) {
            $this->type = $type;
        }
    }
}