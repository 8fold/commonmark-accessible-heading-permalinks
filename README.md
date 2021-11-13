> Note: Delete the labels in the new repo and use https://github.com/jvandemo/copy-github-labels-cli to copy the ones found here to the new repo

# 8fold Accessible Heading Permalinks for CommonMark

This library is an extension for the [CommonMark parser](https://github.com/thephpleague/commonmark) from the PHP League adding accessible heading permalinks inspired by [Amber Wilson](https://amberwilson.co.uk/blog/are-your-anchor-links-accessible/).

> Note: The HTML rendered on this page most likely doesn't use this approach.

> Warning: Do NOT use with the heading permalinks extension provided with CommonMark. I'm not sure what will happen; could be nothing, could be a singularity causing event, who knows?

## Installation

{how does one install the product}

## Usage

```php

use League\CommonMark\Environment\Environment;
use League\CommonMark\MarkdownConverter;

use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;

use Eightfold\CommonMarkAccessibleHeadingPermalink\HeadingPermalinkExtension;

$environment = new Environment();
$environment->addExtension(new CommonMarkCoreExtension());
$environment->addExtension(new HeadingPermalinkExtension());

$converter = new MarkdownConverter($environment);
```

Then write the markdown as you normally would.

```markdown

# Hello

This should be an improvement.
```

Which will output the following (whitespace added for improved readability).

```html
<div is="heading-wrapper">
  <h1 id="hello">Hello</h1>
  <a hreg="#hello">
    <span aria-hidden="true">¶</span>
	<span>Section title Hello</span>
  </a>
</div>
```

## Details

The HTML is treated as a whole component. Styling the inner elements can be accomplished by referencing the containing element and using child and sibling selectors.

For example, the second `span` in the link should be primarily reserved for those using assistive technologies. Therefore, I want it to be off-screen and still read aloud when on the link has focus.

```css
div[is='heading-permalink'] > a > span:nth-of-type(2) {
  position: absolute;
  left: -999em;
  right: auto;
}
```
This example uses the solution provided by the [United States Web Design System](https://github.com/uswds/uswds/blob/1908d1391bc59410624ca1934cc70b7404e8f443/src/stylesheets/core/mixins/_screen-reader.scss) and is not the only method used or available to accomplish similar results.

## Other

{links or descriptions or license, versioning, and governance}
