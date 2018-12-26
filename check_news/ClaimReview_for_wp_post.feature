Feature: WordPress ClaimReview Article
WordPress post should be easy to convert into ClaimReview post

  Background: 
  Scenario Outline:
    Given WordPress is installed at <site_url>
  
    Examples: 
  
      | site_url | http://superfaker.com/ | 
  
  Scenario: Saving blogname
  Scenario Outline:
    Given I go to menu item "Settings > General"
     When I fill in "blogname" with "<site_title>"
      And I press "submit"
      And I should see "Settings saved."
      And I am on the homepage
     Then I should see "<site_title>" in the "h1 a" element
  
    Examples: 
  
      | site_title | Yaya's Guide To Super Truth | 
  
  Scenario: Saving blogdescription
  Scenario Outline:
    Given I go to menu item "Settings > General"
     When I fill in "blogdescription" with "<site_description>"
      And I press "submit"
      And I should see "Settings saved."
      And I am on the homepage
     Then I should see "<site_description>" in the ".site-description" element
  
    Examples: 
  
      | site_description | What Everybody Else Does When It Comes To Truthiness And What You Should Do Different | 
  
  Scenario: Converting a post into ClaimReview post
  Scenario Outline:
    Given I am logged in as "admin"
      And I am on admin dashboard
     When I follow "Add New" within "#menu-posts"
     Then I should see "Add New Post"
     When I fill in "title" with "<title>"    
      And I fill in "content" with "<content>"
  # Fact Checked
     Then I should see "Fact Check"
     When I check the "Fact Checked Status" with "<status>"
     Then I should see "Fact Check Details"
      And I fill in "itemReviewed Author Name" with "<itemReviewed_author_name>"
      And I fill in "itemReviewed Author SameAs" with "<itemReviewed_author_sameAs>"
      And I fill in "itemReviewed Date Published" with "<itemReviewed_datePublished>"
      And I fill in "itemReviewed claimReviewed" with "<itemReviewed_claimReviewed>"
      And I fill in "reviewRating ratingValue" with "<reviewRating_ratingValue>"
      And I fill in "reviewRating alternateName" with "<reviewRating_alternateName>"
  # Fact Checked 
      And I press "publish"
     When I am on post "<url>"
     Then the output should contain:
  """
  {
  "@context": "http://schema.org",
  "@type": "ClaimReview",
  "datePublished": "<itemReviewed_datePublished>",
  "url": "<url>",
  "itemReviewed": {
  "@type": "CreativeWork",
  "author": {
  "@type": "Organization",
  "name": "<itemReviewed_author_name>",
  "sameAs": "<itemReviewed_author_sameAs>"
  },
  "datePublished": "<itemReviewed_datePublished>"
  },
  "claimReviewed": "<itemReviewed_claimReviewed>",
  "author": {
  "@type": "Organization",
  "name": "<site_title>, <site_description>",
  "url": "<site_url>"
  },
  "reviewRating": {
  "@type": "Rating",
  "ratingValue": "<reviewRating_ratingValue>",
  "bestRating": "5",
  "worstRating": "1",
  "alternateName": "<reviewRating_alternateName>"
  }
  }
  """
  
    Examples: 
  
      | title                      | What You Don't Know About Conspiracy May Shock You?                                                                                                                                                                             | 
      | content                    | What You Don't Know About Conspiracy May Shock You? Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam euismod interdum nunc, suscipit pellentesque leo lobortis sit amet. Etiam condimentum ut ipsum a lobortis. | 
      | status                     | true                                                                                                                                                                                                                            | 
      | itemReviewed_author_name   | Claudio Relor                                                                                                                                                                                                                   | 
      | itemReviewed_author_sameAs | https://www.facebook.com/ClaudioRelor/photos/a.3435443453/2119662481697641/                                                                                                                                                     | 
      | itemReviewed_datePublished | 2004-12-29                                                                                                                                                                                                                      | 
      | itemReviewed_claimReviewed | The most viral information ever.                                                                                                                                                                                                | 
      | reviewRating_ratingValue   | 3 = "Half true"                                                                                                                                                                                                                 | 
      | reviewRating_alternateName | Super Damm fake                                                                                                                                                                                                                 | 
      | url                        | http://superfaker.com/2018/12/23/fake-news-2/                                                                                                                                                                                   | 
  
  
