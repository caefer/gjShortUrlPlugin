# gjShortUrlPlugin

Easy and flexible management of redirect rules and keyword landing pages.

## About

You relaunch your website and need a flexible way to redirect users from the old URLs to the new URL structure?
You want to create SEO keyword landing pages or campaign pages with nice ans short URLs that expand to i.e. search result page for that keyword/campaign?

Then this plugin is for you!

## Installation

Install the plugin via PEAR

    $ php symfony plugin:install gjShortUrlPlugin

Or checkout via Subversion or Git

    $ svn co http://svn.symfony-project.org/plugins/gjShortUrlPlugin/tags/RELEASE_1_0_0 plugins/gjShortUrlPlugin
    $ git clone git://github.com/caefer/gjShortUrlPlugin.git plugins/gjShortUrlPlugin

For the latter you have to enaboe the project in your `config/ProjectConfiguration.class.php` manually.

Generate the model related classes.

    $ php symfony doctrine:build --all

## Frontend Configuration (where the redirects should happen)

1. Enable module `gjShortUrl` in your frontend applications `settings.yml`.
2. Add gjShortUrlRoute route/s to your frontend applications `routing.yml`.

i.e.

    shorturl:
      class: gjShortUrlRoute
      url:   /:shorturl
      param: { module: gjShortUrl, action: redirect }

You can add as many gjShortUrlRoute routes as you want in every possible position.

## Backend Configuration (where the redirects should be maintained)

Generate the admin module in your backend application

    $ php symfony doctrine:generate-admin --module=gjShortUrlAdmin --singular=shorturl --plural=shorturls backend gjShortUrl

Now you can browse `/shorturls` in your backend application and create some redirects.

## Best practice

You will see in the examples that you can define multiple routes to use this plugin. You might wonder where to place them in your `routing.yml`.

gjShortUrlRoute will always query the database for matching the current URL. The more shorturls you have or the more complicated queries you define the more expansive this gets.

It is therefor recommended to put shorturl routes that aim to redirect old URLs at the very bottom of your `routing.yml`.

Landing or campaign pages (i.e. http://your.domain.com/win-an-ipad) are easy matches and should go to the top to prevent them from being matches by previous routes.

## Redirect lifecycle

In your backend module you will have noticed the fields `begins_at` and `expires_at` which default to `NULL`. You can use these date fields to plan the lifecycle of a shorturl.
Shorturls will not match if `begins_at` is set to a date in the future and/or if `expires_at` is set to a date in the past.

## Examples

gjShortUrlPlugin is very flexible and totally relies on symfonys routing feature. You are able to use it to its full flexibility.

### Example 1a: Fixed redirects (simple)

I.e.: you want to redirect `http://your.domain.com/your-old-url` to `http://your.domain.com/category/new-url`.

Go to the backend gjShortUrl module and add a new item as follows:

<dl>
  <dt>Source</dt>
  <dd>your-old-url</dd>
  <dt>Target</dt>
  <dd>/category/new-url</dd>
</dl>

>Note the missing slash `/` at the beginning for the source and the preceding slash `/` of the target!

### Example 1b: Fixed redirects (with slashes)

Often you need to allow slashes `/` within your source URL you can allow them in your `routing.yml`.

I.e.: you want to redirect `http://your.domain.com/your/old/url` to `http://your.domain.com/category/new-url`.

Go to the backend gjShortUrl module and add a new item as follows:

<dl>
  <dt>Source</dt>
  <dd>your/old/url</dd>
  <dt>Target</dt>
  <dd>/category/new-url</dd>
</dl>

You can allow slashes in the URL with the following route definition (symfony standard feature):

    shorturl:
      class: gjShortUrlRoute
      url:   /:shorturl
      param: { module: gjShortUrl, action: redirect }
      options:
        segment_separators: [ '.' ]
 
### Example 2: Pattern matching redirects

Often your old URLs follow a pattern. Lets see a particularly ugly example:

You want to redirect from `http://your.domain.com/browse.php?category=sport&article=worldcup-2010` to `http://your.domain.com/sport/worldcup-2010`.
But also from `http://your.domain.com/index.php?category=movies&article=billboard-charts` to `http://your.domain.com/movies/billboard-charts`.

First you would need to define a new route that can match your old URLs and recognises the query string.

    shorturl:
      class: gjShortUrlRoute
      url:   /:shorturl
      param: { module: article, action: redirect }
      options:
        join_query_string: true

> Note that `join_query_string: true` is a feature of gjShortUrlRoute that makes parameters from the querystring available as normal sfWebRequest parameters.

Go to the backend gjShortUrl module and add a new item as follows:

<dl>
  <dt>Source</dt>
  <dd>browse.php</dd>
  <dt>Target</dt>
  <dd>@article</dd>
</dl>

Next you need another ordinary route for the target URL (which you will need anyway).

     article:
      url:   /:category/:slug
      param: { module: gjShortUrl, action: show }

So you only have to use the same route parameters in the target route again and they will automatically be filled in with the values from the source URL.

### Additional notes

The matching of source URLs is done in gjShortUrlTable where you can overload the method `whereParametersFit()` to allow more complex matchings using `LIKE` or `REGEXP` queries. This will help you do create very a specific matching behaviour for your applications requirements.


