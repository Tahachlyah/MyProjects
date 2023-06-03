<?php

namespace App\Entity;

use App\Repository\DurationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DurationRepository::class)]
class Duration
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'duration', targetEntity: InternshipOffer::class)]
    private Collection $internshipOffers;

    public function __construct()
    {
        $this->internshipOffers = new ArrayCollection();
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
     * @return Collection<int, InternshipOffer>
     */
    public function getInternshipOffers(): Collection
    {
        return $this->internshipOffers;
    }

    public function addInternshipOffer(InternshipOffer $internshipOffer): self
    {
        if (!$this->internshipOffers->contains($internshipOffer)) {
            $this->internshipOffers->add($internshipOffer);
            $internshipOffer->setDuration($this);
        }

        return $this;
    }

    public function removeInternshipOffer(InternshipOffer $internshipOffer): self
    {
        if ($this->internshipOffers->removeElement($internshipOffer)) {
            // set the owning side to null (unless already changed)
            if ($internshipOffer->getDuration() === $this) {
                $internshipOffer->setDuration(null);
            }
        }

        return $this;
    }
}
