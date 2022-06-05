<?php

declare(strict_types=1);

namespace Eightfold\CommonMarkAccessibleHeadingPermalink\TableOfContents\Normalizer;

use League\CommonMark\Extension\CommonMark\Node\Block\ListItem;
use League\CommonMark\Extension\TableOfContents\Node\TableOfContents;

final class FlatNormalizerStrategy implements NormalizerStrategyInterface
{
    /** @psalm-readonly */
    private TableOfContents $toc;

    public function __construct(TableOfContents $toc)
    {
        $this->toc = $toc;
    }

    public function addItem(int $level, ListItem $listItemToAdd): void
    {
        $this->toc->appendChild($listItemToAdd);
    }
}
