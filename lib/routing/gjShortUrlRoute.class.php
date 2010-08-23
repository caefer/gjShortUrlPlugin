<?php
class gjShortUrlRoute extends sfRequestRoute
{
  private $shortUrl = false;

  public function matchesUrl($url, $context = array())
  {
    if(false === $parameters = parent::matchesUrl($url, $context))
    {
      return false;
    }

    if(array_key_exists('join_query_string', $this->options) && false !== $this->options['join_query_string'])
    {
      $getParameters = array();
      parse_str(parse_url($context['request_uri'], PHP_URL_QUERY), $getParameters);
      $parameters = array_merge($parameters, $getParameters);
    }

    if(false === $this->shortUrl = Doctrine_Core::getTable('gjShortUrl')->getForParameters($parameters))
    {
      return false;
    }

    return $parameters;
  }

  public function getObject()
  {
    return $this->shortUrl;
  }
}
