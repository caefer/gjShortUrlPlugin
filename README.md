Installation

1. enable module "gjShortUrl" in your frontend application
2. add shorturl route/s to your frontend application

    shorturl:
      class: gjShortUrlRoute
      url:   /:shorturl
      param: { module: gjShortUrl, action: redirect }

(you can have several if you want..)

3. generate the mocel related classes

    $ php symfony doctrine:build --all

4. generate the admin module in your backend application

    $ php symfony doctrine:generate-adminn --module=gjShortUrlAdmin --singular=shorturl --plural=shorturls backend gjShortUrl



Now browse /shorturls in your backend application and create some redirects


Dynamic Routes

Sometimes you want to have redirects on multiple similar URLs with only a parameter changing.

i.e. /category/article-123.html
     /category/article-49.html

you can do this for example with the following route and a change to gjShortUrlTable.

shorties_with_dynamic_parameter:
  class: gjShortUrlRoute
  url: /:shorturl-:id.html
  param: { module: gjShortUrl, action: redirect }
  options:
    segment_separators: [ '.', '-' ]

note that the segment_separators do not include the default '/'.

class gjShortUrlTable extends PlugingjShortUrlTable
{
    protected function whereParametersFit(Doctrine_Query $q, $parameters)
    {
      if(array_key_exists('id', $parameters))
      {
        return $q->addWhere('? LIKE s.source', $parameters['shorturl'].'-'.$parameters['id']);
      }
      else
      {
        return parent::whereParametersFit($q, $parameters);
      }
    }
}

So by overriding the whereParametersFit() method you can react to the parameters you configured in the route.
In this case the above URLs will match for a shorturl source like "category/article-%"


Dynamic Routes with Query String

sometimes the URLs you want to match use the querystring to pass parameters. 

i.e. /category/article.html?id=123
     /category/article.html?id=49

shorties_with_dynamic_get_parameter:
  class: gjShortUrlRoute
  url: /:shorturl.html
  param: { module: gjShortUrl, action: redirect }
  options:
    segment_separators: [ '.', '-' ]
    join_query_string: true

with the above route the URLs will match the same source "category/article-%"


if you want to pass on any parameters from the source to the target then you need to overload gjShortUrlActions::executeRedirect()
All configured parameters (in the above examples "id") will be available on the request object ($request->getParameter('id').
