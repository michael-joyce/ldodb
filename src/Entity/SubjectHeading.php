<?php

declare(strict_types=1);

/*
 * (c) 2021 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * SubjectHeading.
 *
 * @ORM\Table(name="subject_heading", indexes={
 *     @ORM\Index(columns={"subject_heading"}, flags={"fulltext"}),
 * })
 * @ORM\Entity(repositoryClass="App\Repository\SubjectHeadingRepository")
 */
class SubjectHeading {
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="subject_heading", type="string", length=255, nullable=false)
     */
    private $subjectHeading;

    /**
     * @var string
     * @Assert\Url
     * @ORM\Column(name="subject_heading_uri", type="string", length=255, nullable=true)
     */
    private $subjectHeadingUri;

    /**
     * @var Book[]|Collection
     * @ORM\ManyToMany(targetEntity="Book", mappedBy="subjectHeadings")
     */
    private $books;

    /**
     * Construct SubjectHeading object.
     */
    public function __construct() {
        $this->books = new ArrayCollection();
    }

    /**
     * Return string representation of subjectHeading.
     */
    public function __toString() : string {
        return $this->subjectHeading;
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set subjectHeading.
     *
     * @param string $subjectHeading
     *
     * @return SubjectHeading
     */
    public function setSubjectHeading($subjectHeading) {
        $this->subjectHeading = $subjectHeading;

        return $this;
    }

    /**
     * Get subjectHeading.
     *
     * @return string
     */
    public function getSubjectHeading() {
        return $this->subjectHeading;
    }

    /**
     * Set subjectHeadingUri.
     *
     * @param string $subjectHeadingUri
     *
     * @return SubjectHeading
     */
    public function setSubjectHeadingUri($subjectHeadingUri) {
        $this->subjectHeadingUri = $subjectHeadingUri;

        return $this;
    }

    /**
     * Get subjectHeadingUri.
     *
     * @return string
     */
    public function getSubjectHeadingUri() {
        return $this->subjectHeadingUri;
    }

    /**
     * Add book.
     *
     * @return SubjectHeading
     */
    public function addBook(Book $book) {
        $this->books[] = $book;

        return $this;
    }

    /**
     * Remove book.
     */
    public function removeBook(Book $book) : void {
        $this->books->removeElement($book);
    }

    /**
     * Get books.
     *
     * @return Collection
     */
    public function getBooks() {
        return $this->books;
    }
}
