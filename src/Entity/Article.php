<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Article{
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     *  @Assert\Length(
     * min=5,
     * max=70,
     * minMessage = "Le nom est trop court",
     * maxMessage = "Le nom est trop long"
     * )
     * @Assert\NotBlank(message="Le titre ne peut pas être vide")
     * @ORM\Column(type="string")
     */

    private $title;

    /**
     *  @Assert\Length(
     * min=30,
     * max=500,
     * minMessage = "Le contenu est trop court",
     * maxMessage = "Le contenu est trop long"
     * )
     *  @Assert\NotBlank(message="Le contenu ne peut pas être vide")
     * @ORM\Column(type="text")
     */
    private $content;
    
    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;
    
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment",mappedBy="article")
     */
    private $comments;
       /**
     * @ORM\Column(type="string")
     */
    private $price;
    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Le contenu ne peut pas être vide")
     */
    private $difficulty;
    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Le contenu ne peut pas être vide")
     */
    private $time;
    /**
     * @ORM\Column(type="string")
     */
    private $brochureFilename;

    /**
     * @ORM\Column(type="json")
     */
    public $mainColor;

    public function __construct()
    {
        $this->comments=new ArrayCollection();
    }
    public function getId()
    {
        return $this->id;
    }
    public function getTitle()
    {
        return $this->title;
    }
    public function getContent()
    {
        return $this->content;
    }
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    public function setId(int $newId)
    {
        $this->id =$newId ;
    }
    public function setTitle(string $newTitle)
    {
        $this->title = $newTitle;
    }
    public function setContent(string $newContent)
    {
        $this->content = $newContent;
    }
    public function setCreatedAt($newCreatedAt)
    {
        $this->createdAt = $newCreatedAt;
    }

    /**
     * Get the value of comments
     */ 
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set the value of comments
     *
     * @return  self
     */ 
    public function setComments($comments)
    {
        $this->comments = $comments;

        return $this;
    }
    /**
     * Get the value of price
     */ 
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of price
     *
     * @return  self
     */ 
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get the value of difficulty
     */ 
    public function getDifficulty()
    {
        return $this->difficulty;
    }

    /**
     * Set the value of difficulty
     *
     * @return  self
     */ 
    public function setDifficulty($difficulty)
    {
        $this->difficulty = $difficulty;

        return $this;
    }

    /**
     * Get the value of time
     */ 
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set the value of time
     *
     * @return  self
     */ 
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get the value of brochureFilename
     */ 
    public function getBrochureFilename()
    {
        return $this->brochureFilename;
    }

    /**
     * Set the value of brochureFilename
     *
     * @return  self
     */ 
    public function setBrochureFilename($brochureFilename)
    {
        $this->brochureFilename = $brochureFilename;

        return $this;
    }

    /**
     * Get the value of mainColor
     */ 
    public function getMainColor()
    {
        return $this->mainColor;
    }

    /**
     * Set the value of mainColor
     *
     * @return  self
     */ 
    public function setMainColor($mainColor)
    {
        $this->mainColor = $mainColor;

        return $this;
    }
}
