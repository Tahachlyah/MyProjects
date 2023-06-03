<?php

namespace App\Entity;

use App\Repository\InternshipSupervisorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;

#[ORM\Entity(repositoryClass: InternshipSupervisorRepository::class)]
class InternshipSupervisor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'internshipSupervisor', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(length: 100)]
    private ?string $post = null;

    #[ORM\Column(length: 100)]
    private ?string $companyName = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 100)]
    private ?string $field = null;

    #[ORM\Column(length: 100)]
    private ?string $siretNumber = null;

    #[ORM\Column(length: 255)]
    private ?string $companyAdress = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $companyPicture = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $PictureDescription = null;

    #[ORM\ManyToMany(targetEntity: InternshipOffer::class, mappedBy: 'internship_supervisor')]
    #[ JoinTable(name: 'internship_offer_internship_supervisor')]
    private Collection $internshipOffers;

    public function __construct()
    {
        $this->internshipOffers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getPost(): ?string
    {
        return $this->post;
    }

    public function setPost(string $post): self
    {
        $this->post = $post;

        return $this;
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function setCompanyName(string $companyName): self
    {
        $this->companyName = $companyName;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getField(): ?string
    {
        return $this->field;
    }

    public function setField(string $field): self
    {
        $this->field = $field;

        return $this;
    }

    public function getSiretNumber(): ?string
    {
        return $this->siretNumber;
    }

    public function setSiretNumber(string $siretNumber): self
    {
        $this->siretNumber = $siretNumber;

        return $this;
    }

    public function getCompanyAdress(): ?string
    {
        return $this->companyAdress;
    }

    public function setCompanyAdress(string $companyAdress): self
    {
        $this->companyAdress = $companyAdress;

        return $this;
    }

    public function getCompanyPicture(): ?string
    {
        return $this->companyPicture;
    }

    public function setCompanyPicture(?string $companyPicture): self
    {
        $this->companyPicture = $companyPicture;

        return $this;
    }

    public function getPictureDescription(): ?string
    {
        return $this->PictureDescription;
    }

    public function setPictureDescription(?string $PictureDescription): self
    {
        $this->PictureDescription = $PictureDescription;

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
            $internshipOffer->addInternshipSupervisor($this);
        }

        return $this;
    }

    public function removeInternshipOffer(InternshipOffer $internshipOffer): self
    {
        if ($this->internshipOffers->removeElement($internshipOffer)) {
            $internshipOffer->removeInternshipSupervisor($this);
        }

        return $this;
    }
}
