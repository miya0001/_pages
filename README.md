# _Pages

[![Build Status](https://travis-ci.org/miya0001/_pages.svg?branch=master)](https://travis-ci.org/miya0001/_pages)

![](https://www.evernote.com/l/ABVaRJy67QBIdqONizPXuHD2lHH1QcyBO_sB/image.png)

## Usage

```
[pages]
```

### Attributes

* `id` - Optional. The Post ID. Default value is the ID of the current page.
* `size` - Optional. The size of the post thumbnail. Default is `post-thumbnail`.
* `col` - Optional. Width of the child page block. Default is `3`.


### Display posts with the specific query in the theme.

```
<?php

// Query args for WP_Query.
$query = array(
    'post_status' => 'publish',
    'post_type' => 'page',
    'post_parent' => 0,
    'orderby' => 'menu_order',
    'order' => 'ASC',
    'nopaging' => true,
);

// Optional, the number of columns. The default value is `3`.
$col = 3;

// Optional, the size of the image. The default value is `post-thumbnail`.
$thumbnil_size = 'post-thumbnail';

echo _Pages::get_instance()->display( $query, $col, $thumbnil_size );
```
