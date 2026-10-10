<?php

declare(strict_types=1);

namespace App\Support;

use Illuminate\Support\HtmlString;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\CommonMark\Node\Block\FencedCode;
use League\CommonMark\Extension\CommonMark\Node\Block\IndentedCode;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;
use League\CommonMark\Extension\CommonMark\Node\Inline\Link;
use League\CommonMark\Extension\NormalizeHeadings\NormalizeHeadingsExtension;
use League\CommonMark\MarkdownConverter;

final class DocumentationMarkdown
{
    public function render(string $source): HtmlString
    {
        $environment = new Environment([
            'html_input'              => 'strip',
            'allow_unsafe_links'      => false,
            'max_nesting_level'       => 30,
            'max_delimiters_per_line' => 500,
            'normalize_headings'      => ['min_level' => 2, 'rebase_to_min_level' => true],
        ]);
        $environment->addExtension(new CommonMarkCoreExtension);
        $environment->addExtension(new NormalizeHeadingsExtension);
        $renderer = new DocumentationMarkdownRenderer;
        foreach ([Link::class, Code::class, FencedCode::class, IndentedCode::class] as $node) {
            $environment->addRenderer($node, $renderer, 10);
        }

        return new HtmlString((string) (new MarkdownConverter($environment))->convert($source));
    }
}
