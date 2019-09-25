# INSTALLATION:

1. Add Github repository to composer.json:
    ```Add repository from Github
                {
                    "repositories": [
                        {
                            "type": "vcs",
                            "url":  "git@bitbucket.org:ecolos/sylius-glossary-plugin.git"
                        }
                    ]
                }
    ```

2. Install package via composer from Bitbucket 
    ```console
    composer require ecolos/sylius-glossary-plugin
    ```

3. Add to config/bundles.php
    ```php
            [
                Ecolos\SyliusGlossaryPlugin\EcolosSyliusGlossaryPlugin::class => ['all' => true],
            ]
    ```

4. Clear the symfony cache
    ```shell script
    php bin/console cache:clear
    ```

5.  Determine doctrine schema changes and migrate
    ```shell script
    php bin/console doctrine:migrations:diff
    php bin/console doctrine:migrations:execute --up XXXXXXXXXXXXX
    ```

6. Add to config/services.yaml
    ```yaml
    imports:
     - { resource: "@EcolosSyliusGlossaryPlugin/Resources/config/config.yaml" }
    ```

7. Add to config/routes.yaml
    ```yaml
    ecolos_sylius_glossary_plugin:
      resource: "@EcolosSyliusGlossaryPlugin/Resources/config/routing.yaml"

# USAGE:
Check out the Glossar menu entry in the admin panel.
Visit /glossaries on the frontend to view existing glossaries.

# TODO:
- Add tests
