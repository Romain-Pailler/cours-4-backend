<?php

namespace App\Entity;

use App\Repository\BuildingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BuildingRepository::class)]
class Building
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Person>
     */
    #[ORM\OneToMany(mappedBy: 'building', targetEntity: Person::class)]
    private Collection $Person;

    public function __construct()
    {
        $this->Person = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Person>
     */
    public function getPerson(): Collection
    {
        return $this->Person;
    }

    public function addPerson(Person $person): static
    {
        if (!$this->Person->contains($person)) {
            $this->Person->add($person);
            $person->setBuilding($this);
        }

        return $this;
    }

    public function removePerson(Person $person): static
    {
        if ($this->Person->removeElement($person)) {
            // set the owning side to null (unless already changed)
            if ($person->getBuilding() === $this) {
                $person->setBuilding(null);
            }
        }

        return $this;
    }
}
