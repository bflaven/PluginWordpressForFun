# A CheckNews WordPress Plugin
Tackling the fact-checking issue and the truth's relative notion in media is skating on thin ice. It is a very dodgy but necessary questioning nowadays.

Just a quick WordPress Plugin based on the request that was made to me, how  to add a ClaimReview structured data element in an article.

As I was focusing on how to understand and explain to developers the "Fact Check" documentation.

- [Fact Check from Google](https://developers.google.com/search/docs/data-types/factcheck)
- [Testing tool for ClaimReview Structured Data](https://search.google.com/structured-data/testing-tool)

## Description

**I made an end-to-end exercise of crafting a WordPress plug-in from mock-up to field-name description, going through coding and even including a gherkin feature in order to offer the best user experience.**



```
/*
 * Plugin Name: CheckNews
 * Plugin URI: https://flaven.fr
 * Description: Including a ClaimReview structured data element on your WordPress post
 * Version: 1.0
 * Author: Bruno Flaven
 * Text Domain: claimreview-textdomain
 * Domain Path: /languages
*/

```

## Field names plugin description
|Number|Label|Name|Tooltip|Description|
|----------|:-------------:|------:|------:|------:|
|1|Fact Check Status|itemReviewed_status|If you check this box, this post will be considered "Fact Check", do not to forget to fill in the fields for the ClaimReview JSON-LD Header in the Fact Check Details Box.|This is a check-box|
|2|itemReviewed Author Name|itemReviewed_author_name|This is the name of the author of the itemReviewed e.g. ClaudioRelor FakeBook page|This is a free text input field in the seizure e.g. ClaudioRelor FakeBook page|
|3|itemReviewed Author SameAs|itemReviewed_author_sameAs|This is the URL of the itemReviewed|This is a text field|
|4|itemReviewed Date Published|itemReviewed_datePublished|This is the date of publication of the itemReviewed in YYYY-MM-DD e.g. 2017-12-30|This is a text field|
|5|itemReviewed claimReviewed|itemReviewed_claimReviewed|This is the comment text, max 1 paragraph e.g The most viral information ever or What You Don't Know About Conspiracy May Shock You|This is a textarea.|
|6|reviewRating ratingValue|reviewRating_ratingValue|To choose between 1 to 5. The correspondence is the following one: 1 = "False"; 2 = "Mostly false"; 3 = "Half true"; 4 = "Mostly true"; 5 = "True"|This is a drop-down menu between 1 to 5|
|7|reviewRating alternateName|reviewRating_alternateName|This is a text field to enter a short text e.g. Mostly True|This is a text field|

## Screenshots
You can check the post on flaven.fr


## Changelog

= 1.0 - 2018-12-16 =
* Fixed: release not bug fox cause no feedback
* Updated: No update as there is no feedback .


## Installation
Each plugin has its readme.md

- Upload the entire schema folder to the /wp-content/plugins/ directory
- Activate the plugin through the 'Plugins' menu in WordPress
- There is no configuration at all





## Frequently Asked Questions
Nothing for the moment. Please check the post on flaven.fr
