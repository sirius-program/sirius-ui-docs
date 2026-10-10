<?php

declare(strict_types=1);

namespace App\Support;

use Illuminate\Support\HtmlString;
use League\CommonMark\Extension\CommonMark\Node\Block\FencedCode;
use League\CommonMark\Extension\CommonMark\Node\Block\IndentedCode;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;
use League\CommonMark\Extension\CommonMark\Node\Inline\Link;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\Util\RegexHelper;

final class DocumentationMarkdownRenderer implements NodeRendererInterface
{
    public function render(Node $node, ChildNodeRendererInterface $childRenderer): ?string
    {
        if ($node instanceof Link) {
            $content = new HtmlString($childRenderer->renderNodes($node->children()));
            $href = $node->getUrl();
            if (RegexHelper::isLinkPotentiallyUnsafe($href) || preg_match('/[\x00-\x1f\x7f]/', rawurldecode($href))
                || preg_match('/^\s*(?!https?:|mailto:|tel:)[a-z][a-z0-9+.-]*:/i', $href)) {
                return $content->toHtml();
            }

            return trim(view('components.docs-markdown-link', ['href' => $href, 'title' => $node->getTitle(), 'content' => $content])->render());
        }
        if ($node instanceof Code || $node instanceof FencedCode || $node instanceof IndentedCode) {
            return trim(view('components.docs-markdown-code', [
                'source'   => $node->getLiteral(),
                'block'    => !$node instanceof Code,
                'language' => $node instanceof FencedCode ? ($node->getInfoWords()[0] ?? null) : null,
            ])->render());
        }

        return null;
    }
}
