<?php

namespace App\Entity;

use App\Repository\ExpansionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ExpansionRepository::class)
 */
class Expansion
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Mount::class, mappedBy="expansion")
     */
    private $mounts;

    public function __toString()
    {
        return $this->name;
        // TODO: Implement __toString() method.
    }

    public function __construct()
    {
        $this->mounts = new ArrayCollection();
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

    /**
     * @return Collection|Mount[]
     */
    public function getMounts(): Collection
    {
        return $this->mounts;
    }

    public function addMount(Mount $mount): self
    {
        if (!$this->mounts->contains($mount)) {
            $this->mounts[] = $mount;
            $mount->setExpansion($this);
        }

        return $this;
    }

    public function removeMount(Mount $mount): self
    {
        if ($this->mounts->removeElement($mount)) {
            // set the owning side to null (unless already changed)
            if ($mount->getExpansion() === $this) {
                $mount->setExpansion(null);
            }
        }

        return $this;
    }
}
