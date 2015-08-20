<?php

/**
 * This file is part of Herbie.
 *
 * (c) Thomas Breuss <www.tebe.ch>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace herbie\plugin\disqus;

use Herbie;
use Twig_SimpleFunction;

class DisqusPlugin extends Herbie\Plugin
{
    /**
     * @return array
     */
    public function getSubscribedEvents()
    {
        $events = [];
        if ((bool)$this->config('plugins.config.disqus.twig', false)) {
            $events[] = 'onTwigInitialized';
        }
        if ((bool)$this->config('plugins.config.disqus.shortcode', true)) {
            $events[] = 'onShortcodeInitialized';
        }
        return $events;
    }

    /**
     * @param $twig
     */
    public function onTwigInitialized($twig)
    {
        $simpleFunction = new Twig_SimpleFunction('disqus', [$this, 'disqusTwig'], ['is_safe' => ['html']]);
        $twig->addFunction($simpleFunction);
    }

    /**
     * @param $shortcode
     */
    public function onShortcodeInitialized($shortcode)
    {
        $shortcode->add('disqus', [$this, 'disqusShortcode']);
    }

    /**
     * @param string $shortname
     * @return string
     */
    public function disqusTwig($shortname)
    {
        $template = $this->config->get(
            'plugins.config.disqus.template',
            '@plugin/disqus/templates/disqus.twig'
        );
        return $this->render($template, [
           'shortname' => $shortname
        ]);
    }

    /**
     * @param array $options
     * @return string
     */
    public function disqusShortcode($options)
    {
        $options = $this->initOptions([
            'shortname' => empty($options[0]) ? '' : $options[0],
        ], $options);
        return call_user_func_array([$this, 'disqusTwig'], $options);
    }

}
