# WP Plugin add-meta-refresh-page.php

**This WP plugin enables to target a specific page ID and add a metatag "meta-refresh" in the header of the selected page. You can define in the setting menu both the timer in seconds and the url of the metatag "meta-refresh" added to the selected page.**


*The "quick and dirty" plugin was made with the help of ChatGPT to code the logical skeleton and then extended by myself. Below you can fond the prompt.*



## Plugin Structure

``` bash
.
├── add-meta-refresh-page.php # the plugin files
└── README.md # this readme file
```


## WP Plugin add-meta-refresh-page.php
The prompt sent to ChatGPT that has create the plugin without flaws.


``` bash
Can you write a plugin called "Meta-Refresh-Page" in the a file named add-meta-refresh-page.php that has an entry in the menu "Settings" as "Meta-Refresh-Page". On the settings page of "Meta-Refresh-Page", the user can update 2 parameters. The first label value is "Refresh Timer" with field named "add_meta_refresh_timer". The second label value is "Refresh Url" with field named "add_meta_refresh_url". The values typed oth 2 parameters: $add_meta_refresh_timer, $add_meta_refresh_url by the user are populated in a function named "add_meta_refresh_page_wpse161271".
```


