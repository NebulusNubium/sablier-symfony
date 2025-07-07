<?php

namespace App\Entity;

use App\Repository\NotesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NotesRepository::class)]
class Notes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $note = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'picture')]
    private Collection $user;

    /**
     * @var Collection<int, Pictures>
     */
    #[ORM\ManyToMany(targetEntity: Pictures::class, inversedBy: 'notes')]
    private Collection $picture;

    public function __construct()
    {
        $this->user = new ArrayCollection();
        $this->picture = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(?int $note): static
    {
        $this->note = $note;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): static
    {
        if (!$this->user->contains($user)) {
            $this->user->add($user);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        $this->user->removeElement($user);

        return $this;
    }

    /**
     * @return Collection<int, Pictures>
     */
    public function getpicture(): Collection
    {
        return $this->picture;
    }

    public function addpicture(Pictures $picture): static
    {
        if (!$this->picture->contains($picture)) {
            $this->picture->add($picture);
        }

        return $this;
    }

    public function removePicture(Pictures $picture): static
    {
        $this->picture->removeElement($picture);

        return $this;
    }
}
