[PHPoole](http://github.com/Narno/PHPoole/) Gallery plugin.

Installation
------------

    php composer.phar require phpoole/plugin-gallery:@dev --prefer-dist

Usage
-----

### Front matter

Add a ```gallery``` entry to the front matter of a page:

```gallery = "local/path/to/images/dir"```

### Layout samples

#### Galleries list

    {% for gallery in site.pages('galleries') %}
    <ul>
    	<li><a href="{{ site.base_url }}/{{ gallery.path }}">{{ gallery.title }}</a></li>
    </ul>
    {% endfor %}

#### Gallery page

    {% for image in page.gallery %}
    <p><img src="{{ site.base_url }}/{{ page.path }}/{{ image.name }}" class="img-responsive" /></p>
    {% endfor %}
