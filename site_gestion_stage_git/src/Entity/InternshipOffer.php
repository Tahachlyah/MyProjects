<?php

namespace App\Entity;

use App\Repository\InternshipOfferRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;

#[ORM\Entity(repositoryClass: InternshipOfferRepository::class)]
class InternshipOffer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

  

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $createAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $start_date = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $end_date = null;

    #[ORM\ManyToOne(inversedBy: 'internshipOffers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Duration $duration = null;

    #[ORM\ManyToMany(targetEntity: InternshipSupervisor::class, inversedBy: 'internshipOffers')]
    #[JoinTable(name: 'internship_offer_internship_supervisor')]
    private Collection $internship_supervisor;

    #[ORM\ManyToOne(inversedBy: 'internshipOffers')]
    private ?InternshipTheme $theme = null;

    #[ORM\OneToMany(mappedBy: 'internshipOffer', targetEntity: Application::class)]
    private Collection $applications;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $location = null;

    public function __construct()
    {
      
        $this->internship_supervisor = new ArrayCollection();
        $this->applications = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

  
   

    public function getCreateAt(): ?\DateTimeImmutable
    {
        return $this->createAt;
    }

    public function setCreateAt(?\DateTimeImmutable $createAt): self
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->start_date;
    }

    public function setStartDate(\DateTimeInterface $start_date): self
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->end_date;
    }

    public function setEndDate(\DateTimeInterface $end_date): self
    {
        $this->end_date = $end_date;

        return $this;
    }

    public function getDuration(): ?Duration
    {
        return $this->duration;
    }

    public function setDuration(?Duration $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * @return Collection<int, InternshipSupervisor>
     */
    public function getInternshipSupervisor(): Collection
    {
        return $this->internship_supervisor;
    }

    public function addInternshipSupervisor(InternshipSupervisor $internshipSupervisor): self
    {
        if (!$this->internship_supervisor->contains($internshipSupervisor)) {
            $this->internship_supervisor->add($internshipSupervisor);
        }

        return $this;
    }

    public function removeInternshipSupervisor(InternshipSupervisor $internshipSupervisor): self
    {
        $this->internship_supervisor->removeElement($internshipSupervisor);

        return $this;
    }

    public function getTheme(): ?InternshipTheme
    {
        return $this->theme;
    }

    public function setTheme(?InternshipTheme $theme): self
    {
        $this->theme = $theme;

        return $this;
    }

    /**
     * @return Collection<int, Application>
     */
    public function getApplications(): Collection
    {
        return $this->applications;
    }

    public function addApplication(Application $application): self
    {
        if (!$this->applications->contains($application)) {
            $this->applications->add($application);
            $application->setInternshipOffer($this);
        }

        return $this;
    }

    public function removeApplication(Application $application): self
    {
        if ($this->applications->removeElement($application)) {
            // set the owning side to null (unless already changed)
            if ($application->getInternshipOffer() === $this) {
                $application->setInternshipOffer(null);
            }
        }

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

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }
}
