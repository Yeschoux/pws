<?php

namespace App\Entity;

use App\Repository\MountRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MountRepository::class)
 */
class Mount
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
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $faction;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $type;

    /**
     * @ORM\Column(type="float")
     */
    private $currency;



    /**
     * @ORM\ManyToOne(targetEntity=CurrencyType::class, inversedBy="Gold")
     */
    private $currency_type;

    /**
     * @ORM\ManyToOne(targetEntity=Expansion::class, inversedBy="mounts")
     */
    private $expansion;

    /**
     * @ORM\ManyToOne(targetEntity=Source::class)
     */
    private $source;



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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getFaction(): ?string
    {
        return $this->faction;
    }

    public function setFaction(string $faction): self
    {
        $this->faction = $faction;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCurrency(): ?float
    {
        return $this->currency;
    }

    public function setCurrency(float $currency): self
    {
        $this->currency = $currency;

        return $this;
    }


    public function getCurrencyType(): ?CurrencyType
    {
        return $this->currency_type;
    }

    public function setCurrencyType(?CurrencyType $currency_type): self
    {
        $this->currency_type = $currency_type;

        return $this;
    }

    public function getExpansion(): ?Expansion
    {
        return $this->expansion;
    }

    public function setExpansion(?Expansion $expansion): self
    {
        $this->expansion = $expansion;

        return $this;
    }

    public function getSource(): ?source
    {
        return $this->source;
    }

    public function setSource(?source $source): self
    {
        $this->source = $source;

        return $this;
    }
}
