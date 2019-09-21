<?php

namespace Ecolos\SyliusGlossaryPlugin\Menu;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class AdminMenuListener
{
    public function addAdminMenuItems(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();

        $root = $menu
            ->addChild('ecolos_glossary')
            ->setLabel('ecolos_sylius_glossary_plugin.glossary');

        $root
            ->addChild('glossaries', ['route' => 'ecolos_sylius_glossary_plugin_admin_glossary_index'])
            ->setLabel('ecolos_sylius_glossary_plugin.glossaries')
            ->setLabelAttribute('icon', 'calendar');

        $root
            ->addChild('entries', ['route' => 'ecolos_sylius_glossary_plugin_admin_glossary_entry_index'])
            ->setLabel('ecolos_sylius_glossary_plugin.entries')
            ->setLabelAttribute('icon', 'calendar plus');
    }


}
