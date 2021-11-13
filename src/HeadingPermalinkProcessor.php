<?php

declare(strict_types=1);

namespace Eightfold\CommonMarkAccessibleHeadingPermalink;

use League\CommonMark\Environment\EnvironmentAwareInterface;

use League\Config\ConfigurationInterface;

use League\CommonMark\Environment\EnvironmentInterface;

use League\CommonMark\Normalizer\TextNormalizerInterface;

use League\CommonMark\Event\DocumentParsedEvent;

use League\CommonMark\Node\NodeIterator;
use League\CommonMark\Node\StringContainerHelper;
use League\CommonMark\Node\RawMarkupContainerInterface;

use League\CommonMark\Extension\CommonMark\Node\Block\Heading;

final class HeadingPermalinkProcessor implements EnvironmentAwareInterface
{
    private TextNormalizerInterface $slugNormalizer;

    private ConfigurationInterface $config;

    public function setEnvironment(EnvironmentInterface $environment): void
    {
        $this->config         = $environment->getConfiguration();
        $this->slugNormalizer = $environment->getSlugNormalizer();
    }

    public function __invoke(DocumentParsedEvent $e): void
    {
        $min = (int) $this->config
            ->get('accessible_heading_permalink/min_heading_level');
        $max = (int) $this->config
            ->get('accessible_heading_permalink/max_heading_level');

        $slugLength = (int) $this->config->get('slug_normalizer/max_length');

        foreach ($e->getDocument()->iterator(NodeIterator::FLAG_BLOCKS_ONLY) as $node) {
            if (
                $node instanceof Heading &&
                $node->getLevel() >= $min &&
                $node->getLevel() <= $max
            ) {
                $this->addHeadingLink($node, $slugLength);
            }
        }
    }

    private function addHeadingLink(Heading $heading, int $slugLength): void
    {
        $level = $heading->getLevel();

        $text  = StringContainerHelper::getChildText(
            $heading,
            [RawMarkupContainerInterface::class]
        );

        $slug  = $this->slugNormalizer->normalize($text, [
            'node'   => $heading,
            'length' => $slugLength,
        ]);

        $headingLinkAnchor = new HeadingPermalink($level, $text, $slug);

        $heading->replaceWith($headingLinkAnchor);
    }
}
