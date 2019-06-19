<?php
declare(strict_types=1);

namespace Ecolos\SyliusGlossaryPlugin\Entity;

use Doctrine\Common\Collections\ArrayCollection;

interface GlossaryInterface
{
    public function getId(): ?int;

    public function setName(string $name): void;

    public function getName(): string;

    public function setDescription(?string $description): void;

    public function getDescription(): ?string;

    public function setEnabled(bool $enabled): void;

    public function getEnabled(): ?bool;

    public function setSlug(string $name): void;

    public function getSlug(): string;

    public function getEntries(): ArrayCollection;

    public function setEntries($entries): void;
}
