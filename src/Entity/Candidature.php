<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CandidatureRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=CandidatureRepository::class)
 */
class Candidature
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"simpleCandidatures","uploadSimple"})
     * 
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"simpleCandidatures"})
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Offres::class, inversedBy="created_at")
     * @Groups({"simpleCandidatures"})
     */
    private $offre;

    /**
     * @ORM\ManyToOne(targetEntity=Candidat::class, inversedBy="candidatures")
     * @Groups({"simpleCandidatures"})
     */
    private $candidat;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"simpleCandidatures"})
     */
    private $documents;

    /**
     * @ORM\ManyToOne(targetEntity=Recruteur::class, inversedBy="candidatures")
     * @Groups({"simpleCandidatures"})
     */
    private $recruteur;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"simpleCandidatures"})
     */
    private $reponse;

    /**
     * @ORM\OneToMany(targetEntity=Upload::class, mappedBy="candidature")
     * @Groups({"simpleCandidatures"})
     */
    private $uploads;

    public function __construct()
    {
        $this->uploads = new ArrayCollection();
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

    public function getOffre(): ?Offres
    {
        return $this->offre;
    }

    public function setOffre(?Offres $offre): self
    {
        $this->offre = $offre;

        return $this;
    }

    public function getCandidat(): ?Candidat
    {
        return $this->candidat;
    }

    public function setCandidat(?Candidat $candidat): self
    {
        $this->candidat = $candidat;

        return $this;
    }

    public function getDocuments(): ?string
    {
        return $this->documents;
    }

    public function setDocuments(?string $documents): self
    {
        $this->documents = $documents;

        return $this;
    }

    public function getRecruteur(): ?Recruteur
    {
        return $this->recruteur;
    }

    public function setRecruteur(?Recruteur $recruteur): self
    {
        $this->recruteur = $recruteur;

        return $this;
    }

    public function getReponse(): ?string
    {
        return $this->reponse;
    }

    public function setReponse(?string $reponse): self
    {
        $this->reponse = $reponse;

        return $this;
    }

    /**
     * @return Collection|Upload[]
     */
    public function getUploads(): Collection
    {
        return $this->uploads;
    }

    public function addUpload(Upload $upload): self
    {
        if (!$this->uploads->contains($upload)) {
            $this->uploads[] = $upload;
            $upload->setCandidature($this);
        }

        return $this;
    }

    public function removeUpload(Upload $upload): self
    {
        if ($this->uploads->removeElement($upload)) {
            // set the owning side to null (unless already changed)
            if ($upload->getCandidature() === $this) {
                $upload->setCandidature(null);
            }
        }

        return $this;
    }
}
