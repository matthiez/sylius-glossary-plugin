<?php

namespace Ecolos\SyliusGlossaryPlugin\Form\Type;

use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Sylius\Bundle\ResourceBundle\Form\Type\ResourceTranslationsType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;

class GlossaryEntryType extends AbstractResourceType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('alias', GlossaryEntryChoiceType::class, [
                'required' => false,
            ])
            ->add('glossaries', GlossaryChoiceType::class, [
                'required' => true,
                "multiple" => true
            ])
            ->add('enabled', CheckboxType::class, [
                'required' => false,
            ])
            ->add('translations', ResourceTranslationsType::class, [
                'entry_type' => GlossaryEntryTranslationType::class,
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'ecolos_sylius_glossary_plugin_glossary_entry';
    }
}
