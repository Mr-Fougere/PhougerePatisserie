<?php 

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Comment{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @Assert\Length(
     * min=15,
     * max=50,
     * minMessage = "Le commentaire est trop court",
     * maxMessage = "Le commentaire est trop long"
     * )
     * @ORM\Column(type="string")
     */
    private $content;
    /**
     * @Assert\Length(
     * min=5,
     * max=20,
     * minMessage = "Le pseudo est trop court",
     * maxMessage = "Le pseudo est trop long"
     * )
     * @ORM\Column(type="string")
     */
    private $author;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Article",inversedBy="comments")
     * @ORM\JoinColumn(onDelete="CASCADE") 
     */
    private $article;
    /**
     * @ORM\Column(type="datetime")
     */
    private $date;


    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of content
     */ 
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set the value of content
     *
     * @return  self
     */ 
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get the value of author
     */ 
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set the value of author
     *
     * @return  self
     */ 
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get the value of article
     */ 
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Set the value of article
     *
     * @return  self
     */ 
    public function setArticle($article)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get the value of date
     */ 
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set the value of date
     *
     * @return  self
     */ 
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }
}