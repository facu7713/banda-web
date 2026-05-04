<?php

namespace App\Entity;

use App\Repository\ComentarioRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ComentarioRepository::class)]
class Comentario
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "El nombre es obligatorio")]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: "El nombre debe tener al menos {{ limit }} caracteres",
        maxMessage: "El nombre no puede superar {{ limit }} caracteres"
    )]
    private ?string $nombre = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Assert\Range(
        min: 1,
        max: 5,
        notInRangeMessage: "La puntuación debe ser entre {{ min }} y {{ max }}"
    )]
    private ?int $puntuacion = null;

    #[ORM\Column]
    private \DateTimeImmutable $fechaPublicacion;

    #[ORM\Column(type: 'text')]
    #[Assert\NotBlank(message: "El comentario no puede estar vacío")]
    #[Assert\Length(
        min: 5,
        minMessage: "El comentario es muy corto"
    )]
    private ?string $mensaje = null;

    #[ORM\Column(options: ["default" => true])]
    private bool $visible = true;

    public function __construct()
    {
        $this->fechaPublicacion = new \DateTimeImmutable();
        $this->visible = true;
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

    public function getPuntuacion(): ?int
    {
        return $this->puntuacion;
    }

    public function setPuntuacion(int $puntuacion): static
    {
        $this->puntuacion = $puntuacion;

        return $this;
    }

    public function getFechaPublicacion(): ?\DateTimeImmutable
    {
        return $this->fechaPublicacion;
    }

    public function setFechaPublicacion(\DateTimeImmutable $fechaPublicacion): static
    {
        $this->fechaPublicacion = $fechaPublicacion;

        return $this;
    }

    public function getMensaje(): ?string
    {
        return $this->mensaje;
    }

    public function setMensaje(string $mensaje): static
    {
        $this->mensaje = $mensaje;

        return $this;
    }

    public function isVisible(): bool
    {
        return $this->visible;
    }

    public function setVisible(bool $visible): static
    {
        $this->visible = $visible;

        return $this;
    }
}
