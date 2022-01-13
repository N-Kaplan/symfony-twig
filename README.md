# symfony-twig
Introduction to Symfony's twig, as part of the BeCode Training.
Exercise instructions can be found [here](https://github.com/becodeorg/ANT-Lamarr-5.34/tree/main/3.The-Mountain/Symfony/3.Twig).

Date: ```13 January 2022```

## Resources:
[Twig's official documentation](https://twig.symfony.com/)

## Requirements:

Use the MVC Routing exercise you created previously. If yours was unstable, ask another student to use theirs.

- [x] Add a <footer>&copy; Becode</footer> in the base template file, this footer should appear on all pages!

### Menu
- [x] In the base.html.twig file add a menu block surrounded by an ``<aside>`` tag (make it appear to the left with css).
- [x] Inside the menu block add 2 links to the homepage and the about me page.

### About me
 - [x] Add some content to the new left menu that only appears on the about-me page.
Show the current date in 3 different formats in the left menu, but only pass a `DateTime` object once trough your controller.
Because your Controller is in a namespace don't forget to import the `DateTime` class!

 - Europe: DMY
 - America: MDY
 - China & Japan: YMD

To do this you will need to use the [format_date](https://twig.symfony.com/doc/3.x/filters/format_date.html) filter.
Filters are really flexible, small modifiers you can assign to variables to change their appearance.

You will need a custom pattern for this, one example of this would be `{{ date|format_date(pattern="J/M/d") }}`.

In order to make this work you might need to install the following extensions:

`sudo apt-get install php-http`
`sudo apt-get install php-intl`
`composer require twig/intl-extra`

Make sure the 2 links that are as a default in the menu block still appear above your dates, you will need to read about
[extending a block](https://twig.symfony.com/doc/3.x/tags/extends.html#child-template) in order to pull that off.
- Note: add ```{{ parent() }}``` to the child block to replicate the parent block content.

### Home page (show my name)
Now we add some extra functionality on the homepage, in the menu below the default navigation.

- [x] Display the name with each word capitalized, but all the rest in lower case, so "JOHN SMITH" becomes "John Smith".

You will need to a filter to do this, here is a selection that might be useful:

- [capitalize](https://twig.symfony.com/doc/3.x/filters/capitalize.html)
- [title](https://twig.symfony.com/doc/3.x/filters/title.html)
- [upper](https://twig.symfony.com/doc/3.x/filters/upper.html)
- [lower](https://twig.symfony.com/doc/3.x/filters/lower.html)

### Creating a custom twig helper
Sometimes you want to add a piece of custom code on several places in your website, and always passing the same code to your controller can become cumbersome.
This is why we can extend with our custom twig functions and filters!

 - [x] Create a "Random quote generator", you don't need to write the code for the quotes anymore, just copy the [quotes.php](quotes.php) script. Add a random quote on each page below the current content.

You need a custom [TwigFunction](https://symfony.com/doc/current/templating/twig_extension.html) to do this, follow the symfony documentation for more information.

 - [ ] Make sure to show the enters ```(<br>)``` being displayed in the quotes, don't show a quote on only 1 line.
You can do this with the [nl2br filter](https://twig.symfony.com/doc/3.x/filters/nl2br.html).