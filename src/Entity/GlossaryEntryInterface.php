<?php
declare(strict_types=1);

namespace Ecolos\SyliusGlossaryPlugin\Entity;

interface GlossaryEntryInterface
{
    public function setAlias(?int $alias): void;

    public function getAlias(): ?int;

    public function setGlossaries($glossaries): void;

    public function getGlossaries();

    public function getId(): ?int;

    public function setName(string $name): void;

    public function getName(): string;

    public function setDescription(?string $description): void;

    public function getDescription(): ?string;

    public function setEnabled(bool $enabled): void;

    public function getEnabled(): ?bool;

    public function isEnabled(): ?bool;

    public function setSlug(string $name): void;

    public function getSlug(): string;
}
