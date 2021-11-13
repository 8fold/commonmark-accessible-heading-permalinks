<?php

declare(strict_types=1);

use Eightfold\CommonMarkAccessibleHeadingPermalink\HeadingPermalinkExtension;

use League\CommonMark\Environment\Environment;
use League\CommonMark\MarkdownConverter;

use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;

test('can change symbol used', function() {
    $environment = new Environment([
            'accessible_heading_permalink' => [
                'min_heading_level' => 2,
                'symbol' => '#'
            ]
        ]);
        $environment->addExtension(new CommonMarkCoreExtension());
        $environment->addExtension(new HeadingPermalinkExtension());

        $converter = new MarkdownConverter($environment);

        expect(
            (string) $converter->convertToHtml(<<<md
                # A word of caution

                Something

                ## Another word of caution
                md
            )
        )->toBe(<<<html
            <h1>A word of caution</h1>
            <p>Something</p><div is="heading-wrapper"><h2 id="another-word-of-caution">Another word of caution</h2><a href="#another-word-of-caution"><span aria-hidden="true">#</span><span>Section titled Another word of caution</span></a></div>

            html
        );
});

it('respects ignoring levels', function() {
    $environment = new Environment([
        'accessible_heading_permalink' => [
            'min_heading_level' => 2
        ]
    ]);
    $environment->addExtension(new CommonMarkCoreExtension());
    $environment->addExtension(new HeadingPermalinkExtension());

    $converter = new MarkdownConverter($environment);

    expect(
        (string) $converter->convertToHtml(<<<md
            # A word of caution

            Something

            ## Another word of caution
            md
        )
    )->toBe(<<<html
        <h1>A word of caution</h1>
        <p>Something</p><div is="heading-wrapper"><h2 id="another-word-of-caution">Another word of caution</h2><a href="#another-word-of-caution"><span aria-hidden="true">¶</span><span>Section titled Another word of caution</span></a></div>

        html
    );
});

it('matches Amber Wilson implementation, not example iteration', function() {
    $environment = new Environment();
    $environment->addExtension(new CommonMarkCoreExtension());
    $environment->addExtension(new HeadingPermalinkExtension());

    $converter = new MarkdownConverter($environment);

    expect(
        (string) $converter->convertToHtml(<<<md
            # A word of caution
            md
        )
    )->toBe(<<<html
        <div is="heading-wrapper"><h1 id="a-word-of-caution">A word of caution</h1><a href="#a-word-of-caution"><span aria-hidden="true">¶</span><span>Section titled A word of caution</span></a></div>

        html
    );

    expect(
        (string) $converter->convertToHtml(<<<md
            # A word of caution

            Something

            ## Another word of caution
            md
        )
    )->toBe(<<<html
        <div is="heading-wrapper"><h1 id="a-word-of-caution">A word of caution</h1><a href="#a-word-of-caution"><span aria-hidden="true">¶</span><span>Section titled A word of caution</span></a></div>
        <p>Something</p><div is="heading-wrapper"><h2 id="another-word-of-caution">Another word of caution</h2><a href="#another-word-of-caution"><span aria-hidden="true">¶</span><span>Section titled Another word of caution</span></a></div>

        html
    );
});
