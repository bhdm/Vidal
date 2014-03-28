<?php

namespace Vidal\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="marketorder")
 */
class MarketOrder
{
    /**
     * @ORM\Id
     * @ORM\Column(type = "integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @Assert\NotBlank(message="Поле фамилия обязательно для заполнения")
     * @ORM\Column(type="string")
     */
    protected $lastName;

    /**
     * @Assert\NotBlank(message="Поле имя обязательно для заполнения")
     * @ORM\Column(type="string")
     */
    protected $firstName;

    /**
     * @Assert\NotBlank(message="Поле отчество обязательно для заполнения")
     * @ORM\Column(type="string")
     */
    protected $surName;

    /**
     * @Assert\NotBlank(message="Поле E-mail обязательно для заполнения")
     * @Assert\Email(
     *     message = "E-mail '{{ value }}' не действителен",
     *     checkMX = true
     * )
     * @ORM\Column(type="string")
     */
    protected $email;

    /**
     * @Assert\NotBlank(message="Поле телефон обязательно для заполнения")
     * @ORM\Column(type="string")
     */
    protected $phone;

    /**
     * @Assert\NotBlank(message="Поле адрес обязательно для заполнения")
     * @ORM\Column(type="text")
     */
    protected $adress;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $comment;

    /**
     * @Gedmo\Timestampable(on = "create")
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $groupApt;

    /**
     * @param mixed $adress
     */
    public function setAdress($adress)
    {
        $this->adress = $adress;
    }

    /**
     * @return mixed
     */
    public function getAdress()
    {
        return $this->adress;
    }

    /**
     * @param mixed $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param mixed $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $surName
     */
    public function setSurName($surName)
    {
        $this->surName = $surName;
    }

    /**
     * @return mixed
     */
    public function getSurName()
    {
        return $this->surName;
    }

    /**
     * @param mixed $groupApt
     */
    public function setGroupApt($groupApt)
    {
        $this->groupApt = $groupApt;
    }

    /**
     * @return mixed
     */
    public function getGroupApt()
    {
        return $this->groupApt;
    }



}