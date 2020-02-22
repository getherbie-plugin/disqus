# Herbie Disqus Plugin

`Disqus` ist ein [Herbie](http://github.com/getherbie/herbie) Plugin, mit dem du den gleichnamigen Service 
[Disqus](http://www.disqus.com) in deine Website einbettest.


## Installation

Das Plugin installierst du via Composer.

	$ composer require getherbie/plugin-disqus

Danach aktivierst du das Plugin in der Konfigurationsdatei.

    plugins:
        enable:
            - disqus


## Konfiguration

Unter `plugins.config.disqus` stehen dir die folgenden Optionen zur Verfügung:

    # template path to twig template
    template: @plugin/disqus/templates/disqus.twig

    # enable shortcode
    shortcode: true

    # enable twig function    
    twig: false


## Anwendung

Nach der Installation und Konfiguration stehen dir eine Twig-Funktion und ein Shortcode `disqus` zur Verfügung.

Den Shortcode rufst du in deinen Inhaltsseiten wie folgt auf:

    [disqus getherbie]
    
    oder
    
    [disqus shortname="getherbie"]
    
    
Die Twig-Funktion rufst du in deinen Layoutdateien so auf:

    {{ disqus("getherbie") }}


## Parameter

Name        | Beschreibung                          | Typ       | Default
:---------- | :------------------------------------ | :-------- | :------
shortname   | Der Disqus Shortname                  | string    |  *empty*


## Demo

<https://herbie.tebe.ch/blog/2014/05/09-responsive-youtube-videos>
