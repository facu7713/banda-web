<?php

namespace App\Entity;

use App\Repository\VideoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VideoRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Video
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(length: 255)]
    private ?string $url = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $fecha = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $info = null;

    #[ORM\ManyToOne(inversedBy: 'videos')]
    private ?Banda $banda = null;

    #[ORM\PrePersist]
    public function setFechaAutomatica(): void
    {
        $this->fecha = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): static
    {
        $this->fecha = $fecha;
    
        return $this;
    }

    public function getInfo(): ?string
    {
        return $this->info;
    }

    public function setInfo(string $info): static
    {
        $this->info = $info;

        return $this;
    }

    public function getBanda(): ?Banda
    {
        return $this->banda;
    }

    public function setBanda(?Banda $banda): static
    {
        $this->banda = $banda;

        return $this;
    }
}
