<?php
declare(strict_types=1);

namespace Ecolos\SyliusGlossaryPlugin\Controller;

use Ecolos\SyliusGlossaryPlugin\Entity\GlossaryEntryInterface;
use Ecolos\SyliusGlossaryPlugin\Entity\GlossaryInterface;
use FOS\RestBundle\View\View;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Component\Resource\ResourceActions;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GlossaryController extends ResourceController
{
    /** @var EngineInterface */
    private $templatingEngine;

    /** @var EntityRepository */
    private $glossaryRepository;

    /** @var EntityRepository */
    private $glossaryTranslationRepository;

    /** @var GlossaryEntryRepository */
    private $glossaryEntryRepository;

    public function __construct(EngineInterface $templatingEngine, EntityRepository $glossaryRepository, EntityRepository $glossaryTranslationRepository, EntityRepository $glossaryEntryRepository)
    {
        $this->templatingEngine = $templatingEngine;
        $this->glossaryRepository = $glossaryRepository;
        $this->glossaryTranslationRepository = $glossaryTranslationRepository;
        $this->glossaryEntryRepository = $glossaryEntryRepository;
    }

    private function sortAbc($a, $b) {
        return strcmp($a->getTranslation()->getName(), $b->getTranslation()->getName());
    }

    public function indexAction(Request $request): Response
    {

        $glossaries = $this->glossaryRepository->findBy(["enabled" => true]);

        usort($glossaries, [$this, "sortAbc"]);

        return $this->templatingEngine->renderResponse('@EcolosSyliusGlossaryPlugin/Glossary/index.html.twig', [
            "glossaries" => $glossaries
        ]);
    }

    public function sssshowAction(Request $request): Response
    {
        $configuration = $this->requestConfigurationFactory->create($this->metadata, $request);

        $this->isGrantedOr403($configuration, ResourceActions::SHOW);
        $product = $this->findOr404($configuration);

        $recommendationService = $this->get('app.provider.product');

        $recommendedProducts = $recommendationService->getRecommendedProducts($product);

        $this->eventDispatcher->dispatch(ResourceActions::SHOW, $configuration, $product);

        $view = View::create($product);

        if ($configuration->isHtmlRequest()) {
            $view
                ->setTemplate($configuration->getTemplate(ResourceActions::SHOW . '.html'))
                ->setTemplateVar($this->metadata->getName())
                ->setData([
                    'configuration' => $configuration,
                    'metadata' => $this->metadata,
                    'resource' => $product,
                    'recommendedProducts' => $recommendedProducts,
                    $this->metadata->getName() => $product,
                ])
            ;
        }

        return $this->viewHandler->handle($configuration, $view);
    }

    public function showAction(Request $request): Response
    {
        /** @var GlossaryInterface $glossary */
        $glossary = $this->glossaryTranslationRepository->findOneBy(["slug" => $request->attributes->get("slug")]);

        $entries = null === $glossary ? [] : array_filter(
            $this->glossaryEntryRepository->findBy(["enabled" => true]),
            function (GlossaryEntryInterface $glossaryEntry) use ($glossary) {
                return in_array(
                    $glossary->getTranslatable()->getId(),
                    $glossaryEntry->getGlossaries()->toArray());
            });

        usort($entries, [$this, "sortAbc"]);

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
