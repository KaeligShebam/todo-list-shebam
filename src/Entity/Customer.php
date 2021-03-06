<?php

namespace App\Entity;

use App\Repository\CustomerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=CustomerRepository::class)
 * @UniqueEntity(
 * fields= {"name"},
 * message= "Le client existe déjà !"
 * )
 * 
 */
class Customer
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
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Task::class, inversedBy="customer")
     */
    private $task;

    /**
     * @ORM\OneToMany(targetEntity=Task::class, mappedBy="customer")
     */
    private $tasks;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $archived;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function __toString()
    {
    return $this->name;
    }

    public function getTache(): ?Task
    {
        return $this->task;
    }

    public function setTache(?Task $task): self
    {
        $this->task = $task;

        return $this;
    }

    /**
     * @return Collection|Task[]
     */
    public function getTaches(): Collection
    {
        return $this->task;
    }

    public function addTach(Task $tach): self
    {
        if (!$this->tasks->contains($tach)) {
            $this->tasks[] = $tach;
            $tach->setCustomer($this);
        }

        return $this;
    }

    public function removeTach(task $tach): self
    {
        if ($this->taskS->removeElement($tach)) {
            // set the owning side to null (unless already changed)
            if ($tach->getCustomer() === $this) {
                $tach->setCustomer(null);
            }
        }

        return $this;
    }

    public function getArchived(): ?bool
    {
        return $this->archived;
    }

    public function setArchived(?bool $archived): self
    {
        $this->archived = $archived;

        return $this;
    }
}
