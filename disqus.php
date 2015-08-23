<?php

use Herbie\DI;
use Herbie\Hook;

class DisqusPlugin
{
    /** @var  \Herbie\Config */
    public static $config;

    /**
     * Initialize plugin
     */
    public static function install()
    {
        self::$config = DI::get('Config');
        if ((bool)self::$config->get('plugins.config.disqus.twig', false)) {
            Hook::attach('twigInitialized', ['DisqusPlugin', 'twigInitialized']);
        }
        if ((bool)self::$config->get('plugins.config.disqus.shortcode', true)) {
            Hook::attach('shortcodeInitialized', ['DisqusPlugin', 'shortcodeInitialized']);
        }
    }

    /**
     * @param $twig
     */
    public static function twigInitialized($twig)
    {
        $simpleFunction = new Twig_SimpleFunction('disqus', ['DisqusPlugin', 'disqusTwig'], ['is_safe' => ['html']]);
        $twig->addFunction($simpleFunction);
    }

    /**
     * @param $shortcode
     */
    public static function shortcodeInitialized($shortcode)
    {
        $shortcode->add('disqus', ['DisqusPlugin', 'disqusShortcode']);
    }

    /**
     * @param string $shortname
     * @return string
     */
    public static function disqusTwig($shortname)
    {
        $template = self::$config->get(
            'plugins.config.disqus.template',
            '@plugin/disqus/templates/disqus.twig'
        );
        return DI::get('Twig')->render($template, [
            'shortname' => $shortname
        ]);
    }

    /**
     * @param array $options
     * @return string
     */
    public static function disqusShortcode($options)
    {
        $options = array_merge([
            'shortname' => empty($options[0]) ? '' : $options[0],
        ], $options);
        return call_user_func_array(['DisqusPlugin', 'disqusTwig'], $options);
    }

}

DisqusPlugin::install();
