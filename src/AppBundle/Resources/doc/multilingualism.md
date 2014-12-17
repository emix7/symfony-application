# Multilingualism

## Routes

Multilingual routes are handled by the I18nRoutingBundle. Use the _locale
parameter to switch between languages and add route translations to the route
translation files like this.

``` yml
// src/AppBundle/Resources/translations/routes.<lang>.yml

news_article_index: /news/
news_article_show: '/news/{slug}'
search_search_index: /search/
```

## Entities

When you create a multilingual entity the general use case is that you have
properties and methods that are language independent on the one hand and
methods and properties that are language specific on the other hand. The two
are separated by creating a translatable entity and a translation entity using
the provided interfaces and traits.

``` php
<?php
// src/PageBundle/Entity/PageTranslatable.php

namespace PageBundle\Entity;

use BehaviorBundle\Model\TranslatableInterface;
use BehaviorBundle\Model\TranslatableTrait;

class PageTranslatable implements TranslatableInterface
{
	use TranslableTrait;

	// language independent properties and methods
}
```

``` php
<?php
// PageBundle/Entity/Page.php

namespace PageBundle\Entity;

use BehaviorBundle\Model\TranslationInterface;
use BehaviorBundle\Model\TranslationTrait;

class Page implements TranslationInterface
{
	use TranslationTrait;

	// language specific properties and methods
}
```

Using these entities you can now create your first translations like this.

``` php
<?php

$pageTranslatable = new PageTranslatable();

$page = new Page();
$page->setLocale("en");
$page->setTitle("About us");
$pageTranslatable->addTranslation($page);

$page = new Page();
$page->setLocale("nl");
$page->setTitle("Over ons");
$pageTranslatable->addTranslation($page);
```

As you can see the code is clean and simple and no magic is involved. Beside
the interfaces and traits the following features are provided to further
simplify working with translations.

### Doctrine filter

In most situations you only need to retrieve the entities corresponding to the
current locale. This can be achieved by adding a locale filter to each query
you write. However, Doctrine provides the possibility to add a default filter.

By default the TranslationFilter is enabled to ease retrieval of multilingual
entities. This means you don’t have to worry about adding this filter each time
you retrieve entities. Make sure you disable this filter in cases where you
need to retrieve entities for a locale different from the current locale.

### Admin extension

An admin extension is provided to add out-of-the-box multilingualism features
like adding new translations to a translatable and navigating through available
translations. This extension is enabled by default for entities that implement
the TranslationInterface.

``` yml
// app/config.yml

sonata_admin:
    extensions:
        behavior.translation.extension:
            implements:
                - BehaviorBundle\Model\TranslationInterface
```

### Language switcher

The language switcher is also pretty basic. By default the base template
contains a route switcher which can be overridden within an entity template to
enable switching between multilingual entities.

``` twig
// src/AppBundle/Resources/views/layout.html.twig

{% block language_selector %}
    {% for locale in locales %}
        <a href="{{ path('page_page_show', { slug: page.translatable.translation(locale).slug, _locale: locale }) }}"><img src="{{ asset('bundles/app/img/flag_' ~ locale ~ '.png') }}" width="35" height="20" /></a>
    {% endfor %}
{% endblock %}
```
