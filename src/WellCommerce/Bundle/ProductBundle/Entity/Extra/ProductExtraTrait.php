<?php

namespace WellCommerce\Bundle\ProductBundle\Entity\Extra {

    trait ProductExtraTrait {

        protected $author;

        protected $isbn;

        protected $pagesCount;

        protected $publicationYear;

        protected $coverType;

        protected $format;

        protected $publisher;

        public function getAuthor() {
            return $this->author;
        }

        public function setAuthor($author) {
            $this->author = $author;
        }

        public function getIsbn() {
            return $this->isbn;
        }

        public function setIsbn($isbn) {
            $this->isbn = $isbn;
        }

        public function getPagesCount() {
            return $this->pagesCount;
        }

        public function setPagesCount($pagesCount) {
            $this->pagesCount = $pagesCount;
        }

        public function getPublicationYear() {
            return $this->publicationYear;
        }

        public function setPublicationYear($publicationYear) {
            $this->publicationYear = $publicationYear;
        }

        public function getCoverType() {
            return $this->coverType;
        }

        public function setCoverType($coverType) {
            $this->coverType = $coverType;
        }

        public function getFormat() {
            return $this->format;
        }

        public function setFormat($format) {
            $this->format = $format;
        }

        public function getPublisher() {
            return $this->publisher;
        }

        public function setPublisher($publisher) {
            $this->publisher = $publisher;
        }
    }
}