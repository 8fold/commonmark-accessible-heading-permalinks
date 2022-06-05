<?php

declare(strict_types=1);

namespace Eightfold\CommonMarkAccessibleHeadingPermalink\TableOfContents\Normalizer;

use League\CommonMark\Extension\CommonMark\Node\Block\ListItem;

interface NormalizerStrategyInterface
{
    public function addItem(int $level, ListItem $listItemToAdd): void;
}
