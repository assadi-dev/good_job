<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UploadRepository;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=UploadRepository::class)
 */
class Upload
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"uploadSimple","simpleCandidatures"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Candidat::class, inversedBy="uploads")
     * @ORM\JoinColumn(nullable=false)
     *  @Groups({"uploadSimple"})
     */
    private $candidat;

    /**
     * @ORM\ManyToOne(targetEntity=Candidature::class, inversedBy="uploads")
     *  @Groups({"uploadSimple"})
     */
    private $candidature;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"uploadSimple"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"uploadSimple","simpleCandidatures"})
     */
    private $chemin;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"uploadSimple"})
     */
    private $type;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCandidature(): ?Candidature
    {
        return $this->candidature;
    }

    public function setCandidature(?Candidature $candidature): self
    {
        $this->candidature = $candidature;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getChemin(): ?string
    {
        return $this->chemin;
    }

    public function setChemin(?string $chemin): self
    {
        $this->chemin = $chemin;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }
}
