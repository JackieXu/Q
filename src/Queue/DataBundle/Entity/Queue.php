<?php

namespace Queue\DataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Queue\DataBundle\Repository\QueueRepository")
 * @ORM\Table(name="queues")
 */
class Queue
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="id")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", name="name", length=100)
     */
    protected $name;

    /**
     * @ORM\Column(type="text", name="message")
     */
    protected $message;

    /**
     * @ORM\OneToMany(targetEntity="Queue\DataBundle\Entity\Entry", mappedBy="queue")
     */
    protected $entries;

    /**
     * @ORM\ManyToMany(targetEntity="Queue\DataBundle\Entity\User")
     */
    protected $users;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->entries = new \Doctrine\Common\Collections\ArrayCollection();
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Queue
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set message
     *
     * @param string $message
     * @return Queue
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Add entries
     *
     * @param \Queue\DataBundle\Entity\Entry $entries
     * @return Queue
     */
    public function addEntry(\Queue\DataBundle\Entity\Entry $entries)
    {
        $this->entries[] = $entries;

        return $this;
    }

    /**
     * Remove entries
     *
     * @param \Queue\DataBundle\Entity\Entry $entries
     */
    public function removeEntry(\Queue\DataBundle\Entity\Entry $entries)
    {
        $this->entries->removeElement($entries);
    }

    /**
     * Get entries
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEntries()
    {
        return $this->entries;
    }

    /**
     * Add users
     *
     * @param \Queue\DataBundle\Entity\User $users
     * @return Queue
     */
    public function addUser(\Queue\DataBundle\Entity\User $users)
    {
        $this->users[] = $users;

        return $this;
    }

    /**
     * Remove users
     *
     * @param \Queue\DataBundle\Entity\User $users
     */
    public function removeUser(\Queue\DataBundle\Entity\User $users)
    {
        $this->users->removeElement($users);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
