<?php

declare(strict_types=1);

namespace Eightfold\CommonMarkAccessibleHeadingPermalink\Tests\Functional\Extension\TableOfContents;

use Eightfold\CommonMarkAccessibleHeadingPermalink\Tests\Functional\Extension\TableOfContents\AbstractLocalDataTest;

use League\CommonMark\ConverterInterface;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkExtension;
use League\CommonMark\Extension\TableOfContents\TableOfContentsExtension;
use League\CommonMark\MarkdownConverter;

final class TableOfContentsExtensionTest extends AbstractLocalDataTest
{
    /**
     * @param array<string, mixed> $config
     */
    protected function createConverter(array $config = []): ConverterInterface
    {
        $environment = new Environment($config);
        $environment->addExtension(new CommonMarkCoreExtension());
        $environment->addExtension(new HeadingPermalinkExtension());
        $environment->addExtension(new TableOfContentsExtension());

        return new MarkdownConverter($environment);
    }

    /**
     * {@inheritDoc}
     */
    public function dataProvider(): iterable
    {
        yield from $this->loadTests(__DIR__ . '/md');
    }
}
