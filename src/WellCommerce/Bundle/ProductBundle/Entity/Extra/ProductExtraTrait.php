<?php

namespace WellCommerce\Bundle\ProductBundle\Entity\Extra {

    trait ProductExtraTrait {

        protected $publisher;

        protected $author;

        protected $publicationYear;

        protected $premiereDate;

        protected $seriesName;

        protected $schoolSubject;

        protected $schoolClass;

        protected $coverType;

        protected $format;

        protected $pagesCount;

        protected $ageGroup;

        protected $isbn;

        public function getPublisher() {
            return $this->publisher;
        }

        public function setPublisher($publisher) {
            $this->publisher = $publisher;
        }

        public function getAuthor() {
            return $this->author;
        }

        public function setAuthor($author) {
            $this->author = $author;
        }

        public function getPublicationYear() {
            return $this->publicationYear;
        }

        public function setPublicationYear($publicationYear) {
            $this->publicationYear = $publicationYear;
        }

        public function getPremiereDate() {
            return $this->premiereDate;
        }

        public function setPremiereDate($premiereDate) {
            $this->premiereDate = $premiereDate;
        }

        public function getSeriesName() {
            return $this->seriesName;
        }

        public function setSeriesName($seriesName) {
            $this->seriesName = $seriesName;
        }

        public function getSchoolSubject() {
            return $this->schoolSubject;
        }

        public function setSchoolSubject($schoolSubject) {
            $this->schoolSubject = $schoolSubject;
        }

        public function getSchoolClass() {
            return $this->schoolClass;
        }

        public function setSchoolClass($schoolClass) {
            $this->schoolClass = $schoolClass;
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

        public function getPagesCount() {
            return $this->pagesCount;
        }

        public function setPagesCount($pagesCount) {
            $this->pagesCount = $pagesCount;
        }

        public function getAgeGroup() {
            return $this->ageGroup;
        }

        public function setAgeGroup($ageGroup) {
            $this->ageGroup = $ageGroup;
        }

        public function getIsbn() {
            return $this->isbn;
        }

        public function setIsbn($isbn) {
            $this->isbn = $isbn;
        }
    }
}