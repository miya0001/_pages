# Child Pages Shortcode 2

[![Build Status](https://travis-ci.org/miya0001/miya-child-pages-shortcode.svg?branch=master)](https://travis-ci.org/miya0001/miya-child-pages-shortcode)

## Usage

```
[child_pages]
```

### Arguments

* `id` - Optional. The Post ID. Default value is the ID of the current page.
* `size` - Optional. The size of the post thumbnail. Default is `post-thumbnail`.
* `width` - Optional. Width of the child page block. Default is `33%`.

## Filter Hooks

### child_pages_shortcode_defaults

Filters the default values of the shotcode attributes.

### child_pages_shortcode_query

Filters the parameters for `get_posts()`.

```
array(
	'post_status' => 'publish',
	'post_type' => 'page',
	'post_parent' => <The Post ID>,
	'orderby' => 'menu_order',
	'order' => 'ASC',
	'nopaging' => true,
);
```

### child_pages_shortcode_post

Filters the post object.

### child_pages_shortcode_output

Filters the HTML.

### child_pages_shortcode_template

Filters the HTML of the template.

```
<section id="child-page-%post_id%" class="child-page" style="width: %width%;">
	<div class="child-page-container">
		<div class="post-thumbnail"><a href="%post_url%">%post_thumbnail%</a></div>
		<h2 class="post-title"><a href="%post_url%">%post_title%</a></h2>
		<p class="post-excerpt">%post_excerpt%</p>
	</div>
</section>
```

## CSS Example

This plugin doesn't have any styles. So you have to add styles for this plugin in your theme or so.
Following is an CSS example which uses CSS3 Flexbox.

```
.child-pages
{
	display: flex;
	flex-wrap: wrap;
	margin-left: -8px;
	margin-top: 1em;
	margin-bottom: 1em;
	justify-content: space-between;
}

.child-pages .child-page
{
	flex-grow: 1;
	display: flex;
	align-items: center;
}

.child-pages .child-page .child-page-container
{
	border: 1px solid #eeeeee;
	border-radius: 3px;
	margin-left: 8px;
	margin-bottom: 8px;
	padding: 8px;
	width: 100%;
	box-sizing: border-box;
}
```
