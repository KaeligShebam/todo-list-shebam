<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\WaitingReturnRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=WaitingReturnRepository::class)
 */
class WaitingReturn
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $object;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sub_object1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sub_object2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sub_object3;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="tasks")
     */
    private $users;

    /**
     * @ORM\ManyToOne(targetEntity=Customer::class, inversedBy="tasks")
     */
    private $customer;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $nextweek;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        $this->users->removeElement($user);

        return $this;
    }

    public function getObject(): ?string
    {
        return $this->object;
    }

    public function setObject(string $object): self
    {
        $this->object = $object;

        return $this;
    }

    public function getSubObject1(): ?string
    {
        return $this->sub_object1;
    }

    public function setSubObject1(?string $sub_object1): self
    {
        $this->sub_object1 = $sub_object1;

        return $this;
    }

    public function getSubObject2(): ?string
    {
        return $this->sub_object2;
    }

    public function setSubObject2(?string $sub_object2): self
    {
        $this->sub_object2 = $sub_object2;

        return $this;
    }

    public function getSubObject3(): ?string
    {
        return $this->sub_object3;
    }

    public function setSubObject3(?string $sub_object3): self
    {
        $this->sub_object3 = $sub_object3;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getNextweek()
    {
        return $this->nextweek;
    }

    public function setNextweek(?bool $nextweek): self
    {
        $this->nextweek = $nextweek;

        return $this;
    }
}