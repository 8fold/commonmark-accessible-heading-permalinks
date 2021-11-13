<?php

declare(strict_types=1);

namespace Eightfold\CommonMarkAccessibleHeadingPermalink;

use League\CommonMark\Node\Inline\AbstractInline;

final class HeadingPermalink extends AbstractInline
{
    private int $level;

    private string $text;

    private string $slug;

    public function __construct(int $level, string $text, string $slug)
    {
        parent::__construct();

        $this->level = $level;
        $this->text  = $text;
        $this->slug  = $slug;
    }

    public function getLevel(): int
    {
        return $this->level;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }
}
