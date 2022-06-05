<?php

declare(strict_types=1);

namespace Eightfold\CommonMarkAccessibleHeadingPermalink\TableOfContents;

use League\CommonMark\Extension\TableOfContents\Node\TableOfContents;
use League\CommonMark\Node\Block\Document;

interface TableOfContentsGeneratorInterface
{
    public function generate(Document $document): ?TableOfContents;
}
