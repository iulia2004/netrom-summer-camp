<?php

namespace App\Entity;

use App\Repository\FestivalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FestivalRepository::class)]
class Festival
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $location = null;

    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $start_date = null;

    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $end_date = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 0)]
    private ?string $price = null;

    /**
     * @var Collection<int, FestivalArtist>
     */
    #[ORM\OneToMany(targetEntity: FestivalArtist::class, mappedBy: 'festival', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $festivalArtists;

    /**
     * @var Collection<int, Purchase>
     */
    #[ORM\OneToMany(targetEntity: Purchase::class, mappedBy: 'festival', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $purchases;

    public function __construct()
    {
        $this->festivalArtists = new ArrayCollection();
        $this->purchases = new ArrayCollection();
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

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->start_date;
    }

    public function setStartDate(?\DateTimeInterface $start_date): static
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->end_date;
    }

    public function setEndDate(?\DateTimeInterface $end_date): static
    {
        $this->end_date = $end_date;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): static
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection<int, FestivalArtist>
     */
    public function getFestivalArtists(): Collection
    {
        return $this->festivalArtists;
    }

    public function addFestivalArtist(FestivalArtist $festivalArtist): static
    {
        if (!$this->festivalArtists->contains($festivalArtist)) {
            $this->festivalArtists->add($festivalArtist);
            $festivalArtist->setFestival($this);
        }

        return $this;
    }

    public function removeFestivalArtist(FestivalArtist $festivalArtist): static
    {
        if ($this->festivalArtists->removeElement($festivalArtist)) {
            // set the owning side to null (unless already changed)
            if ($festivalArtist->getFestival() === $this) {
                $festivalArtist->setFestival(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Purchase>
     */
    public function getPurchases(): Collection
    {
        return $this->purchases;
    }

    public function addPurchase(Purchase $purchase): static
    {
        if (!$this->purchases->contains($purchase)) {
            $this->purchases->add($purchase);
            $purchase->setFestival($this);
        }

        return $this;
    }

    public function removePurchase(Purchase $purchase): static
    {
        if ($this->purchases->removeElement($purchase)) {
            // set the owning side to null (unless already changed)
            if ($purchase->getFestival() === $this) {
                $purchase->setFestival(null);
            }
        }

        return $this;
    }
}
