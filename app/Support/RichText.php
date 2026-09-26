<?php

namespace App\Support;

use Symfony\Component\HtmlSanitizer\HtmlSanitizer;
use Symfony\Component\HtmlSanitizer\HtmlSanitizerConfig;

/**
 * Cleans admin-authored HTML (project bodies) down to a safe formatting subset,
 * so a pasted <script>, inline event handler or javascript: link can never run
 * on the public site.
 */
class RichText
{
    private const BLOCKS = ['p', 'div', 'br', 'h2', 'h3', 'h4', 'ul', 'ol', 'li', 'blockquote', 'pre', 'hr', 'figure', 'figcaption'];

    private const INLINE = ['strong', 'b', 'em', 'i', 'u', 's', 'del', 'code', 'span'];

    public static function sanitize(?string $html): ?string
    {
        if ($html === null || trim($html) === '') {
            return null;
        }

        $config = (new HtmlSanitizerConfig)
            ->allowLinkSchemes(['http', 'https', 'mailto', 'tel'])
            ->allowRelativeLinks()
            ->allowElement('a', ['href', 'title', 'target'])
            ->forceAttribute('a', 'rel', 'noopener noreferrer')
            ->allowMediaSchemes(['https', 'http'])
            ->allowRelativeMedias()
            ->allowElement('img', ['src', 'alt', 'width', 'height']);

        foreach ([...self::BLOCKS, ...self::INLINE] as $element) {
            $config = $config->allowElement($element);
        }

        // The editor's heading button emits <h1>, but the page title is already the <h1>.
        $html = preg_replace('#<(/?)h1(\s[^>]*)?>#i', '<$1h2>', $html);

        return (new HtmlSanitizer($config->withMaxInputLength(200_000)))->sanitize($html);
    }
}
