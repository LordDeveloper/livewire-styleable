<?php

namespace Jey\LivewireStyleable;

use DOMDocument;
use DOMXPath;
use Livewire\Component;
use Livewire\ComponentChecksumManager;
use Livewire\Response;
use ScssPhp\ScssPhp\Compiler;
use ScssPhp\ScssPhp\Exception\SassException;

class Styleable
{

    /**
     * @param Component $component
     * @param Response $response
     * @return void
     * @throws SassException
     */
    final public static function dehydration(Component $component, Response $response)
    {
        $response->memo['checksum'] = (new ComponentChecksumManager)->generate($response->fingerprint, $response->memo);

        if(! in_array(HasStyle::class, class_uses($component)) && ! config('styleable.is_global'))
            return;

        $html = $response->html();

        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', config('styleable.encoding')));
        libxml_use_internal_errors(false);
        $xpath = new DOMXPath($dom);

        if(count($styles = $xpath->query('//style[@scoped]')))
            foreach ($styles as $style) {
                $style->removeAttribute('lang');
                $style->removeAttribute('scoped');

                $style->nodeValue = (new Compiler())
                    ->compileString('[wire\\:id="'. $component->id .'"] {'. $style->nodeValue .'}')
                    ->getCss();
            }

        data_set($response, 'effects.html', static::removeDoctype($dom->saveHTML()));
    }

    /**
     * @param $html
     * @return mixed
     */
    private static function removeDoctype($html): mixed
    {
        return '<!----- USING LIVEWIRE STYLES ---->'. preg_replace(
                '/^<!DOCTYPE.+?>/',
                '',
                str_replace(['<html>', '</html>', '<body>', '</body>'], '', $html)
            );
    }
}
