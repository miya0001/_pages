# _Pages

[![Build Status](https://travis-ci.org/miya0001/_pages.svg?branch=master)](https://travis-ci.org/miya0001/_pages)

## Usage

```
[pages]
```

### Attributes

* `id` - Optional. The Post ID. Default value is the ID of the current page.
* `size` - Optional. The size of the post thumbnail. Default is `post-thumbnail`.
* `col` - Optional. Width of the child page block. Default is `33%`.

## Filter Hooks

### _pages_defaults

Filters the default values of the shotcode attributes.

### _pages_query

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

### _pages_object

Filters the post object.

### _pages_output

Filters the HTML.

### _pages_container

Filters the container HTML.

```
<div class="child-pages">%content%</div>
```