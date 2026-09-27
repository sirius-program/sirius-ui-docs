<?php

declare(strict_types=1);

namespace App\Support;

use Closure;
use Symfony\Component\HtmlSanitizer\HtmlSanitizer;
use Symfony\Component\HtmlSanitizer\HtmlSanitizerConfig;

final class RichtextSample
{
    /** @return array{body: string, signature: string} */
    public static function values(): array
    {
        return ['body' => '<h2>Design review</h2><p>The homepage draft is ready for <strong>Friday</strong>.</p>', 'signature' => '<p>Alex — Design team</p>'];
    }

    public static function sanitize(string $html): string
    {
        $config = (new HtmlSanitizerConfig)->allowLinkSchemes(['https', 'http', 'mailto', 'tel'])->allowElement('a', ['href'])->forceAttribute('a', 'rel', 'noopener noreferrer');
        $config = $config->allowMediaSchemes(['http', 'https'])->allowElement('img', ['src', 'alt', 'title']);
        foreach (['p', 'br', 'strong', 'em', 'u', 's', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'ul', 'ol', 'li', 'blockquote', 'pre', 'code', 'hr'] as $tag) {
            $config = $config->allowElement($tag);
        }

        return (new HtmlSanitizer($config))->sanitize($html);
    }

    /** @return array<string, array<int, string|Closure>> */
    public static function rules(): array
    {
        return [
            'body' => ['bail', 'required', 'string', 'max:10000', function (string $attribute, mixed $value, Closure $fail): void {
                $safe = self::sanitize($value);
                $text = html_entity_decode(strip_tags($safe), ENT_QUOTES | ENT_HTML5, 'UTF-8');
                if (preg_replace('/[\s\x{00A0}\x{200B}]+/u', '', $text) === '' && !preg_match('/<img\b[^>]*\bsrc=/i', $safe)) {
                    $fail('Write an announcement.');
                }
            }],
            'signature' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
