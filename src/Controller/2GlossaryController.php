<?php

declare(strict_types=1);

namespace Ecolos\SyliusGlossaryPlugin\Controller;

use Ecolos\SyliusGlossaryPlugin\Entity\GlossaryEntryInterface;
use Ecolos\SyliusGlossaryPlugin\Entity\GlossaryInterface;
use Ecolos\SyliusGlossaryPlugin\Repository\GlossaryEntryRepository;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

final class GlossaryController
{
    /** @var EngineInterface */
    private $templatingEngine;

    /** @var EntityRepository */
    private $glossaryRepository;

    /** @var GlossaryEntryRepository */
    private $glossaryEntryRepository;

    public function __construct(EngineInterface $templatingEngine, EntityRepository $glossaryTranslationRepository, EntityRepository $glossaryEntryRepository)
    {
        $this->templatingEngine = $templatingEngine;
        $this->glossaryRepository = $glossaryTranslationRepository;
        $this->glossaryEntryRepository = $glossaryEntryRepository;
    }

    public function indexAction(): Response
    {
        return $this->templatingEngine->renderResponse('@EcolosSyliusGlossaryPlugin/Glossary/index.html.twig');
    }

    public function showAction(Request $request): Response
    {
        /** @var GlossaryInterface $glossary */
        $glossary = $this->glossaryRepository->findOneBy(["slug" => $request->attributes->get("slug")]);

        $entries = null === $glossary ? [] : array_filter(
            $this->glossaryEntryRepository->findBy(["enabled" => true]),
            function (GlossaryEntryInterface $glossaryEntry) use ($glossary) {
                return in_array(
                    $glossary->getTranslatable()->getId(),
                    $glossaryEntry->getGlossaries()->toArray());
            });

        usort($entries, function ($a, $b) {
            return strcmp($a->getTranslation()->getName(), $b->getTranslation()->getName());
        });

        return $this->templatingEngine->renderResponse(
            '@EcolosSyliusGlossaryPlugin/Glossary/show.html.twig',
            [
                "glossary" => $glossary,
                "entries" => $entries
            ]
        );
    }

    public function entryAction(Request $request): Response
    {
        /** @var GlossaryEntryInterface $entry */
        $entry = $this->glossaryEntryRepository->createQueryBuilder("s")
            ->addSelect('translation')
            ->leftJoin('s.translations', 'translation')
            ->andWhere('translation.slug LIKE :slug')
            ->setParameter("slug", $request->attributes->get("entry_slug"))
            ->getQuery()
            ->getOneOrNullResult();

        if (null !== $entry->getAlias()) {
            /** @var GlossaryEntryInterface $alias */
            $alias = $this->glossaryEntryRepository->findOneBy(["id" => $entry->getAlias()]);

            $entry->setDescription($alias->getDescription());
        }

        return $this->templatingEngine->renderResponse(
            '@EcolosSyliusGlossaryPlugin/Glossary/entry.html.twig',
            [
                "entry" => $entry
            ]
        );
    }
}
