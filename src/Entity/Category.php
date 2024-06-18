<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{



    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

  

    #[ORM\Column(length: 255)] 
    #[Assert\NotBlank(message: 'Ne me laisse pas vide s\'il te plait')]
    #[Assert\Length(max: 255, maxMessage: 'La catégorie saisie {{ value }} et trop longue, elle ne devrait pas dépasser {{ limit }} caractères',)]
    #[Assert\Length(min: 5, minMessage: 'La catégorie saisie {{ value }} et trop courte, elle ne devrait avoir {{ limit }} caractères',)]

    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Program::class)]
    private $programs;

    public function __construct()
    {
        $this->programs = new ArrayCollection();
    }

    public function getPrograms(): Collection
    {
        return $this->programs;
    }
// Methode pour ajouter une série. 
    public function addProgram(Program $program): self
    {
        if (!this->programs->contains($program)) {
            $this->programs->add($program);
            $program->setCategory($this);
        }
        return $this;
    }

    // Methode pour supprimer une série.

    public function removeProgram(Program $program): self 
    {
        if ($this->programs->removeElement($program)) {
            if ($program->getCategory() === $this) {
                $program->setCategory(null);
            }
        }

        return $this;
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
}
