<?php

namespace App\Entity;

use App\Repository\ArtistRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArtistRepository::class)]
class Artist
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $thumbnailUrl = null;

    /**
     * @var Collection<int, Release>
     */
    #[ORM\OneToMany(targetEntity: Release::class, mappedBy: 'artist', orphanRemoval: true)]
    private Collection $releases;

    /**
     * @var Collection<int, Track>
     */
    #[ORM\ManyToMany(targetEntity: Track::class, inversedBy: 'featuredArtists')]
    private Collection $featuredIn;

    #[ORM\ManyToOne(inversedBy: 'artists')]
    #[ORM\JoinColumn(nullable: false, options: ['default' => 2])]
    private ?User $owner = null;

    public function __construct()
    {
        $this->releases = new ArrayCollection();
        $this->featuredIn = new ArrayCollection();
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

    public function getThumbnailUrl(): ?string
    {
        return $this->thumbnailUrl;
    }

    public function setThumbnailUrl(string $thumbnailUrl): static
    {
        $this->thumbnailUrl = $thumbnailUrl;

        return $this;
    }

    /**
     * @return Collection<int, Release>
     */
    public function getReleases(): Collection
    {
        return $this->releases;
    }

    public function addRelease(Release $release): static
    {
        if (!$this->releases->contains($release)) {
            $this->releases->add($release);
            $release->setArtist($this);
        }

        return $this;
    }

    public function removeRelease(Release $release): static
    {
        if ($this->releases->removeElement($release)) {
            // set the owning side to null (unless already changed)
            if ($release->getArtist() === $this) {
                $release->setArtist(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Track>
     */
    public function getFeaturedIn(): Collection
    {
        return $this->featuredIn;
    }

    public function addFeaturedIn(Track $featuredIn): static
    {
        if (!$this->featuredIn->contains($featuredIn)) {
            $this->featuredIn->add($featuredIn);
        }

        return $this;
    }

    public function removeFeaturedIn(Track $featuredIn): static
    {
        $this->featuredIn->removeElement($featuredIn);

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): static
    {
        $this->owner = $owner;

        return $this;
    }
}
