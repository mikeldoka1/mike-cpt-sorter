## Setup
Download the zip archive or:
```git clone https://github.com/mikeldoka1/mike-cpt-sorter.git```

## Requirements
Requires `PHP 8.1` and WordPress 6.4

## Demo
[demo page](https://mikewp.dev/sample-page/)

## Usage
Use the following shortcode:

```[custom-search]```

### Limit posts per page:

```[custom-search post-types="post" element-count="5"]```

### Get multiple post types:

```[custom-search post-types="post, news, etc" element-count="5"]```

no error will be thrown if post type is not found!

## Display Options
Visit the following endpoint to change default display options:
`/wp-admin/options-general.php?page=mike-cpt-sorter`

Posts per page: default settings, in case it's not provided in the shortcode
Display Type: list or grid