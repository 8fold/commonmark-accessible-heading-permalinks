<?php

declare(strict_types=1);

namespace Eightfold\CommonMarkAccessibleHeadingPermalink;

use League\Config\ConfigurationAwareInterface;

use Stringable;

use League\Config\ConfigurationInterface;

use League\CommonMark\Node\Node;

use League\CommonMark\Util\HtmlElement;

use League\CommonMark\Xml\XmlNodeRendererInterface;

use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\Renderer\ChildNodeRendererInterface;

use Eightfold\CommonMarkAccessibleHeadingPermalink\HeadingPermalink;

final class HeadingPermalinkRenderer implements
    NodeRendererInterface,
    XmlNodeRendererInterface,
    ConfigurationAwareInterface
{
    public const DEFAULT_SYMBOL = '¶';

    private ConfigurationInterface $config;

    public function setConfiguration(ConfigurationInterface $configuration): void
    {
        $this->config = $configuration;
    }

    /**
     * @param HeadingPermalink $node
     */
    public function render(
        Node $node,
        ChildNodeRendererInterface $childRenderer
    ): Stringable {
        HeadingPermalink::assertInstanceOf($node);

        $level = $node->getLevel();
        $text  = $node->getText();
        $slug  = $node->getSlug();

        $attrs = $node->data->getData('attributes');
        $attrs->set('href', '#' . $slug);

        $symbol = $this->config->get('accessible_heading_permalink/symbol');

        assert(is_string($symbol));

        $symbolSpan = new HtmlElement(
            'span',
            [
                'aria-hidden' => "true"
            ],
            htmlspecialchars($symbol),
            false
        );

        $voiceoverSpan = new HtmlElement(
            'span',
            [],
            'Section titled ' . htmlspecialchars($text),
            false
        );

        $link = new HtmlElement(
            'a',
            $attrs->export(),
            [$symbolSpan, $voiceoverSpan],
            false
        );

        $header = new HtmlElement(
            'h' . $level,
            ['id' => $slug],
            $text,
            false
        );

        return new HtmlElement(
            'div',
            ['is' => 'heading-wrapper'],
            [$header, $link],
            false
        );
    }

    public function getXmlTagName(Node $node): string
    {
        return 'accessible_heading_permalink';
    }

    /**
     * @param HeadingPermalink $node
     *
     * @return array<string, scalar>
     *
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public function getXmlAttributes(Node $node): array
    {
        HeadingPermalink::assertInstanceOf($node);

        return [
            'slug' => $node->getSlug(),
        ];
    }
}
