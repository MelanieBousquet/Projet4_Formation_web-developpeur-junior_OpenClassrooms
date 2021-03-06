<?php

namespace Ebookblog\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Comment
 *
 * @ORM\Table(name="comment")
 * @ORM\Entity(repositoryClass="Ebookblog\BlogBundle\Repository\CommentRepository")
 */
class Comment
{
    /**
     * @ORM\ManyToOne(targetEntity="Ebookblog\BlogBundle\Entity\Chapter")
     * @ORM\JoinColumn(nullable=false)
     *
     */
    private $chapter;
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     * @Assert\DateTime())
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=255)
     * @Assert\NotBlank(message = "Votre commentaire doit spécifier un auteur")
     */
    private $author;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     *
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="gravatar", type="string", length=255, nullable=true)
     *
     */
    private $gravatar;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     * @Assert\NotBlank(message = "Le commentaire ne peut pas être vide")
     */
    private $content;

    /**
    * @ORM\Column(name="published", type="boolean")
    * @Assert\Type("bool")
    */
    private $published = false;

    public function __construct()
    {
        // Par défaut, la date de publication est la date d'aujourd'hui
        $this->date = new \Datetime();
        $this->published = false;
    }
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Comment
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set author
     *
     * @param string $author
     *
     * @return Comment
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     *
     *Get email
     *
     *@return Comment
     */
    public function setEmail($email) {

        $this->email = $email;

        return $this;
    }

    /**
     *
     * Get email
     *
     *@return string
     */
    public function getEmail() {

        return $this->email;
    }

    /**
     *
     *Get gravatar
     *
     *@return Comment
     */
    public function setGravatar($gravatar) {

        $this->gravatar = $gravatar;

        return $this;
    }

    /**
     *
     * Get gravatar
     *
     *@return string
     */
    public function getGravatar() {

        return $this->gravatar;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Comment
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set chapter
     *
     * @param \Ebookblog\BlogBundle\Entity\Chapter $chapter
     *
     * @return Comment
     */
    public function setChapter(\Ebookblog\BlogBundle\Entity\Chapter $chapter)
    {
        $this->chapter = $chapter;

        return $this;
    }

    /**
     * Get chapter
     *
     * @return \Ebookblog\BlogBundle\Entity\Chapter
     */
    public function getChapter()
    {
        return $this->chapter;
    }

    /**
     * Set published
     *
     * @param boolean $published
     *
     * @return Comment
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return boolean
     */
    public function getPublished()
    {
        return $this->published;
    }
}
