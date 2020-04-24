<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PhoneRepository")
 */
class Phone
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"list", "show"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=128)
     * @Groups({"list", "show"})
     * @Assert\NotBlank(message="Le champ ne doit pas être vide")
     * @Assert\Length(min="2", minMessage="Ce champ doit contenir un minimum de {{ limit }} caractères", max="128", maxMessage="Ce champ doit contenir un maximum de {{ limit }} caractères")
     */
    private $brand;

    /**
     * @ORM\Column(type="string", length=128)
     * @Groups({"list", "show"})
     * @Assert\NotBlank(message="Le champ ne doit pas être vide")
     * @Assert\Length(min="2", minMessage="Ce champ doit contenir un minimum de {{ limit }} caractères", max="128", maxMessage="Ce champ doit contenir un maximum de {{ limit }} caractères")
     */
    private $model;

    /**
     * @ORM\Column(type="date")
     * @Groups({"show"})
     */
    private $year_of_marketing;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     * @Groups({"show"})
     * @Assert\NotBlank(message="Le champ ne doit pas être vide")
     */
    private $screen_size;

    /**
     * @ORM\Column(type="string", length=64)
     * @Groups({"show"})
     * @Assert\NotBlank(message="Le champ ne doit pas être vide")
     * @Assert\Length(min="2", minMessage="Ce champ doit contenir un minimum de {{ limit }} caractères", max="128", maxMessage="Ce champ doit contenir un maximum de {{ limit }} caractères")
     */
    private $screen_resolution;

    /**
     * @ORM\Column(type="string", length=64)
     * @Groups({"show"})
     * @Assert\NotBlank(message="Le champ ne doit pas être vide")
     * @Assert\Length(min="2", minMessage="Ce champ doit contenir un minimum de {{ limit }} caractères", max="64", maxMessage="Ce champ doit contenir un maximum de {{ limit }} caractères")
     */
    private $os_version;

    /**
     * @ORM\Column(type="string", length=32)
     * @Groups({"show"})
     * @Assert\NotBlank(message="Le champ ne doit pas être vide")
     * @Assert\Length(min="2", minMessage="Ce champ doit contenir un minimum de {{ limit }} caractères", max="32", maxMessage="Ce champ doit contenir un maximum de {{ limit }} caractères")
     */
    private $color;

    /**
     * @ORM\Column(type="decimal", precision=3, scale=2)
     * @Groups({"show"})
     */
    private $specific_absorption_rate;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"show"})
     * @Assert\NotBlank(message="Le champ ne doit pas être vide")
     */
    private $rom_memory;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"show"})
     * @Assert\NotBlank(message="Le champ ne doit pas être vide")
     * @Assert\Length(min="2", minMessage="Ce champ doit contenir un minimum de {{ limit }} caractères", max="255", maxMessage="Ce champ doit contenir un maximum de {{ limit }} caractères")
     */
    private $description;

    /**
     * @ORM\Column(type="decimal", precision=6, scale=2)
     * @Groups({"list", "show"})
     * @Assert\NotBlank(message="Le champ ne doit pas être vide")
     */
    private $price;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getBrand(): ?string
    {
        return $this->brand;
    }

    /**
     * @param string $brand
     * @return $this
     */
    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getModel(): ?string
    {
        return $this->model;
    }

    /**
     * @param string $model
     * @return $this
     */
    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getYearOfMarketing(): ?\DateTimeInterface
    {
        return $this->year_of_marketing;
    }

    /**
     * @param \DateTimeInterface $year_of_marketing
     * @return $this
     */
    public function setYearOfMarketing(\DateTimeInterface $year_of_marketing): self
    {
        $this->year_of_marketing = $year_of_marketing;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getScreenSize(): ?string
    {
        return $this->screen_size;
    }

    /**
     * @param string $screen_size
     * @return $this
     */
    public function setScreenSize(string $screen_size): self
    {
        $this->screen_size = $screen_size;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getScreenResolution(): ?string
    {
        return $this->screen_resolution;
    }

    /**
     * @param string $screen_resolution
     * @return $this
     */
    public function setScreenResolution(string $screen_resolution): self
    {
        $this->screen_resolution = $screen_resolution;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getOsVersion(): ?string
    {
        return $this->os_version;
    }

    /**
     * @param string $os_version
     * @return $this
     */
    public function setOsVersion(string $os_version): self
    {
        $this->os_version = $os_version;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getColor(): ?string
    {
        return $this->color;
    }

    /**
     * @param string $color
     * @return $this
     */
    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSpecificAbsorptionRate(): ?string
    {
        return $this->specific_absorption_rate;
    }

    /**
     * @param string $specific_absorption_rate
     * @return $this
     */
    public function setSpecificAbsorptionRate(string $specific_absorption_rate): self
    {
        $this->specific_absorption_rate = $specific_absorption_rate;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getRomMemory(): ?int
    {
        return $this->rom_memory;
    }

    /**
     * @param int $rom_memory
     * @return $this
     */
    public function setRomMemory(int $rom_memory): self
    {
        $this->rom_memory = $rom_memory;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPrice(): ?string
    {
        return $this->price;
    }

    /**
     * @param string $price
     * @return $this
     */
    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }
}
