<?php

namespace App\Entity;

use App\Repository\BandaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BandaRepository::class)]
class Banda
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    /**
     * @var Collection<int, Show>
     */
    #[ORM\OneToMany(targetEntity: Show::class, mappedBy: 'banda')]
    private Collection $shows;

    /**
     * @var Collection<int, Cancion>
     */
    #[ORM\OneToMany(targetEntity: Cancion::class, mappedBy: 'banda')]
    private Collection $cancions;

    /**
     * @var Collection<int, Video>
     */
    #[ORM\OneToMany(targetEntity: Video::class, mappedBy: 'banda')]
    private Collection $videos;

    /**
     * @var Collection<int, Foto>
     */
    #[ORM\OneToMany(targetEntity: Foto::class, mappedBy: 'banda')]
    private Collection $fotos;

    public function __construct()
    {
        $this->shows = new ArrayCollection();
        $this->cancions = new ArrayCollection();
        $this->videos = new ArrayCollection();
        $this->fotos = new ArrayCollection();
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

    /**
     * @return Collection<int, Show>
     */
    public function getShows(): Collection
    {
        return $this->shows;
    }

    public function addShow(Show $show): static
    {
        if (!$this->shows->contains($show)) {
            $this->shows->add($show);
            $show->setBanda($this);
        }

        return $this;
    }

    public function removeShow(Show $show): static
    {
        if ($this->shows->removeElement($show)) {
            // set the owning side to null (unless already changed)
            if ($show->getBanda() === $this) {
                $show->setBanda(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Cancion>
     */
    public function getCancions(): Collection
    {
        return $this->cancions;
    }

    public function addCancion(Cancion $cancion): static
    {
        if (!$this->cancions->contains($cancion)) {
            $this->cancions->add($cancion);
            $cancion->setBanda($this);
        }

        return $this;
    }

    public function removeCancion(Cancion $cancion): static
    {
        if ($this->cancions->removeElement($cancion)) {
            // set the owning side to null (unless already changed)
            if ($cancion->getBanda() === $this) {
                $cancion->setBanda(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Video>
     */
    public function getVideos(): Collection
    {
        return $this->videos;
    }

    public function addVideo(Video $video): static
    {
        if (!$this->videos->contains($video)) {
            $this->videos->add($video);
            $video->setBanda($this);
        }

        return $this;
    }

    public function removeVideo(Video $video): static
    {
        if ($this->videos->removeElement($video)) {
            // set the owning side to null (unless already changed)
            if ($video->getBanda() === $this) {
                $video->setBanda(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Foto>
     */
    public function getFotos(): Collection
    {
        return $this->fotos;
    }

    public function addFoto(Foto $foto): static
    {
        if (!$this->fotos->contains($foto)) {
            $this->fotos->add($foto);
            $foto->setBanda($this);
        }

        return $this;
    }

    public function removeFoto(Foto $foto): static
    {
        if ($this->fotos->removeElement($foto)) {
            // set the owning side to null (unless already changed)
            if ($foto->getBanda() === $this) {
                $foto->setBanda(null);
            }
        }

        return $this;
    }
}
