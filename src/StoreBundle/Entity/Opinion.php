<?php

namespace StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Opinion
 *
 * @ORM\Entity(repositoryClass="StoreBundle\Entity\Repository\OpinionRepository")
 * @ORM\Table(name="opinion")
 */
class Opinion
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=255)
     */
    private $author;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="string", length=255)
     */
    private $content;

    /**
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="StoreBundle\Entity\Product")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    public function __construct()
    {
        $this->date = new \DateTime();
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
 * @param string $author
 */
public function setAuthor($author)
{
    $this->author = $author;
}

/**
 * @return string
 */
public function getContent()
{
    return $this->content;
}

/**
 * @param string $content
 */
public function setContent($content)
{
    $this->content = $content;
}

/**
 * @return mixed
 */
public function getDate()
{
    return $this->date;
}

/**
 * @param mixed $date
 */
public function setDate($date)
{
    $this->date = $date;
}

/**
 * Get product
 *
 * @return \StoreBundle\Entity\Product
 */
public function getProduct()
{
    return $this->product;
}

/**
 * Set product
 *
 * @param \StoreBundle\Entity\Product $product
 *
 * @return Opinion
 */
public function setProduct($product)
{
    $this->product = $product;

    return $this;
}
}