<?php

namespace Queue\DataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Queue\DataBundle\Repository\EntryRepository")
 * @ORM\Table(name="entries")
 */
class Entry
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="id")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="datetime", name="date")
     */
    protected $date;

    /**
     * @ORM\ManyToOne(targetEntity="Queue\DataBundle\Entity\User")
     */
    protected $user;

    /**
     * @ORM\Column(type="boolean", name="is_completed", nullable=true)
     */
    protected $isCompleted;

    /**
     * @ORM\ManyToOne(targetEntity="Queue\DataBundle\Entity\Queue")
     */
    protected $queue;

    public function __construct()
    {
        $this->date = new \DateTime();
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Entry
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
     * Set user
     *
     * @param \Queue\DataBundle\Entity\User $user
     * @return Entry
     */
    public function setUser(\Queue\DataBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Queue\DataBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set queue
     *
     * @param \Queue\DataBundle\Entity\Queue $queue
     * @return Entry
     */
    public function setQueue(\Queue\DataBundle\Entity\Queue $queue = null)
    {
        $this->queue = $queue;

        return $this;
    }

    /**
     * Get queue
     *
     * @return \Queue\DataBundle\Entity\Queue 
     */
    public function getQueue()
    {
        return $this->queue;
    }

    /**
     * Set isCompleted
     *
     * @param boolean $isCompleted
     * @return Entry
     */
    public function setIsCompleted($isCompleted)
    {
        $this->isCompleted = $isCompleted;

        return $this;
    }

    /**
     * Get isCompleted
     *
     * @return boolean 
     */
    public function getIsCompleted()
    {
        return $this->isCompleted;
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
