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
     * Class AvailabilityExtended
     *
     * The file was auto-generated.
     *
     * @author Adam Piotrowski <adam@wellcommerce.org>
     */
    class AvailabilityExtended extends Availability {

        protected $type;

        protected $name;

        public function getType() {
            return $this->type;
        }

        public function getName() {
            return $this->name;
        }

        public function setType($type) {
            $this->type = $type;
        }

        public function setName($name) {
            $this->name = $name;
        }
    }
}