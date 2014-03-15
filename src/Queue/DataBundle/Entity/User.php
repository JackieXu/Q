<?php

namespace Queue\DataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Queue\DataBundle\Repository\UserRepository")
 * @ORM\Table(name="users")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="id")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", name="username", length=100)
     */
    protected $username;

    /**
     * @ORM\Column(type="string", name="password_hash", length=100)
     */
    protected $passwordHash;

    /**
     * @ORM\Column(type="string", name="password_salt", length=100)
     */
    protected $passwordSalt;

    /** 
     * @ORM\Column(type="string", name="roles", length=100)
     */
    protected $roles;

    public function __construct()
    {
        $this->passwordSalt = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
    }

    public function getRoles()
    {
        $roles = array();

        if ($this->roles) {
            $roles = explode(',', $this->roles);
        }

        return $roles;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->passwordHash;
    }

    public function getSalt()
    {
        return $this->passwordSalt;
    }

    public function eraseCredentials()
    {
        return $this;
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

    /**
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Set passwordHash
     *
     * @param string $passwordHash
     * @return User
     */
    public function setPasswordHash($passwordHash)
    {
        $this->passwordHash = $passwordHash;

        return $this;
    }

    /**
     * Get passwordHash
     *
     * @return string 
     */
    public function getPasswordHash()
    {
        return $this->passwordHash;
    }

    /**
     * Set passwordSalt
     *
     * @param string $passwordSalt
     * @return User
     */
    public function setPasswordSalt($passwordSalt)
    {
        $this->passwordSalt = $passwordSalt;

        return $this;
    }

    /**
     * Get passwordSalt
     *
     * @return string 
     */
    public function getPasswordSalt()
    {
        return $this->passwordSalt;
    }

    /**
     * Set roles
     *
     * @param string $roles
     * @return User
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }
}
