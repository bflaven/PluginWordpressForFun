# Handling YT Video on WP,a quick way to make a WP plugin...

## 1. WP PLUGIN IN ONE SENTENCE
I wanted to install video post-type on my Blog using WP.
It takes almost 2 hours to create the plugin and 2 more hours to make few adjustments in the Zaatar WP theme that I am using then the real work started because of the web design or the UX experience that I wanted to provide.
It was ugly then it turns acceptable. Maximum with a massive cut and paste 2 days. It was easier to create a plugin than to make a JSON YOUTUBE API retrieve to import all the stuff.

``` bash
.
├── bf_videos_manager_all # the directory
│   ├── bf_videos_icons_for_promotion # Icons See 4.4 ICONS FOR ZAATAR
│   ├── bf_videos_manager # The plugin  See 3. WHAT TO CHANGE IN THE WP PLUGIN
│── └── bf_videos_placeholder_for_video_icon_play_button # The PNGs See 4. EXTRAS STUFF
└──  README.md #This file
```


## 2. HOW-TO LOOK IN THE WP PLUGIN
I had previous plugin generic code named `bf_quotes_manager` so I decided to go for a WP plugin making a massive replacement with Sublime Text across the directory. I swaped `_bf_quotes_` by `_bf_videos_` and turn bf_quotes_manager to bf_videos_manager, be sure also to rename the filenames.

The naming covention is the following
- My initials: `bf`. It is not egomaniac, it is just what came to my mind. I am using my initials so I am sure there is no conflicts.
- The content I am dealing with: `videos`
- The purpose of the plugin: `manager`. 

**Feel free to change all this elements to match your proper needs to make a plugin with a post-type and taxonomies so you can handle in WP whatever you want.**

## 3. WHAT TO CHANGE IN THE WP PLUGIN

So you have the following elements:

**3.1 main elements: Post Type & Custom Taxonomy**
*The core element for the plugin.*

- bf_videos_manager (Post Type)
- bf_videos_manager_tag (Custom Taxonomy)
- bf_videos_manager_cat (Custom Taxonomy)

**3.2 main elements: Post Type & Custom Taxonomy**
*Custom variables attached to the Post Type `bf_videos_manager`. I always choose self-explanatory names so I do not have to remember the definition.*

- bf_videos_manager_video_link
- bf_videos_manager_video_id
- bf_videos_manager_video_link_to_content
- bf_videos_manager_video_link_to_amazon
- bf_videos_manager_video_link_to_github
- bf_videos_manager_video_link_to_youtube_channel



**(i) Declare the Post Type**
```php
const CUSTOM_POST_TYPE_ID = 'bf_videos_manager';
// const myplugin_text_domain = 'bf_videos_manager_text_domain';
const myplugin_text_domain = 'bf_videos_manager';
```

**(ii) The icon for the main navigation**
```php
'menu_icon' => 'dashicons-media-video'
```

**(iii) The slug for the Post Type and the 2 Custom Taxonomies**
```php
'rewrite' => array(
                                    // 'slug' => 'books',
                                    /* Pour les nice-urls  livre-achat-occasion-ressources-formation */
                                    // 'slug' => 'les-citations',
                                    'slug' => 'videos',
                                    'with_front' => false,
                                  ),

'rewrite' => array(
                            // 'slug' => 'auteurs-citations',
                            'slug' => 'videos-tags',
                            'with_front' => false
                        ),

'rewrite' => array(
                            // 'slug' => 'saveurs-citations',
                            'slug' => 'videos-categories',
                            'with_front' => false
                        ),


```

**(iv) You can modify the WP after and add some files**

``` bash
.
├── zaatar # my wp theme
│   ├── archive-bf_videos_manager.php # Template Hierarchy with Post Types
│   ├── taxonomy-bf_videos_manager_tag.php # Template Hierarchy with Custom Taxonomies
│   ├── taxonomy-bf_videos_manager_cat.php # Template Hierarchy with Custom Taxonomies
│   │    ├── /template-parts/
│   │    │    ├── /content/
│   │    │    │    └── content-bf_videos_manager.php # Template Hierarchy with Partial and Miscellaneous Template Files
```


## 4. EXTRAS STUFF


### 4.1 MAIN COLOR
Some explanations on color for the Zaatar WP theme main color is "#4F1993;"
Source: https://www.color-hex.com/color/4f1993


### 4.2 GENERATE A PALETTE
A good source of inspiration to determine colors
Check out https://mycolor.space/?hex=%234F1993&sub=1


### 4.3 PLACEHOLDER IMAGE FOR VIDEO
It is always to tedious to create play buttons so here is the set I am using.

``` bash
#NEW_PURPLE (#5e3863)
new_purple_render_play_585x330.png
new_purple_render_play_again_sam_585x330.png
new_purple_render_play_youtube_like_585x330.png
new_purple_render_play_triangle_like_585x330.png

#BLUE (#3e9af7)
blue_render_play_585x330.png
blue_render_play_again_sam_585x330.png
blue_render_play_youtube_like_585x330.png
blue_render_play_triangle_like_585x330.png



#GREEN (#61983d)
green_render_play_585x330.png
green_render_play_again_sam_585x330.png
green_render_play_triangle_like_585x330.png
green_render_play_youtube_like_585x330.png



#ORANGE (#cd5e26)
orange_render_play_585x330.png
orange_render_play_again_sam_585x330.png
orange_render_play_triangle_like_585x330.png
orange_render_play_youtube_like_585x330.png


#PALE_GREEN (#cfd169)
pale_green_render_play_585x330.png
pale_green_render_play_again_sam_585x330.png
pale_green_render_play_youtube_like_585x330.png
pale_green_render_play_triangle_like_585x330.png


#ADOBE (#880000)
adobe_render_play_585x330.png
adobe_render_play_again_sam_585x330.png
adobe_render_play_youtube_like_585x330.png
adobe_render_play_triangle_like_585x330.png

#ROSY (#efacff)
rosy_render_play_585x330.png
rosy_render_play_again_sam_585x330.png
rosy_render_play_youtube_like_585x330.png
rosy_render_play_triangle_like_585x330.png

#PURPLE (#351c75)
purple_render_play_585x330.png
purple_render_play_again_sam_585x330.png
purple_render_play_youtube_like_585x330.png
purple_render_play_triangle_like_585x330.png
```

### 4.4 ICONS FOR ZAATAR
I need some icons for brand such as Amazon, GitHub, YouTube to make promotion but has somehow compliant with the Zaatar WP design.

```bash
# Amazon
icons_for_promotion_amazon_585x330.png
icons_for_promotion_amazon_painted_in_white_585x330.png
icons_for_promotion_amazon_white_round_585x330.png
icons_for_promotion_amazon_white_square_585x330.png

# GitHub
icons_for_promotion_github_585x330.png
icons_for_promotion_github_painted_in_white_585x330.png
icons_for_promotion_github_white_round_585x330.png
icons_for_promotion_github_white_square_585x330.png

# YouTube
icons_for_promotion_youtube_585x330.png
icons_for_promotion_youtube_painted_in_white_585x330.png
icons_for_promotion_youtube_white_round_585x330.png
icons_for_promotion_youtube_white_square_585x330.png
```

### 4.5 ZA'ATAR OR ZAATAR DEFINITION
Thanks for Alaa to have given the WP name [https://en.wikipedia.org/wiki/Za%27atar].










