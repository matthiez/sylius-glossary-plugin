<?php
declare(strict_types=1);

namespace Ecolos\SyliusGlossaryPlugin\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

interface GlossaryEntryInterface
{
    public function setAlias(?int $alias): void;

    public function getAlias(): ?int;

    public function setGlossaries(ArrayCollection $glossar): void;

    public function getGlossaries(): Collection;

    public function getId(): ?int;

    public function setName(string $name): void;

    public function getName(): string;

    public function setDescription(?string $description): void;

    public function getDescription(): ?string;

    public function setEnabled(bool $enabled): void;

    public function getEnabled(): ?bool;
}
