<?php

/**
 * Base actions for the gjShortUrlPlugin gjShortUrl module.
 * 
 * @package     gjShortUrlPlugin
 * @subpackage  gjShortUrl
 * @author      Christian Schaefer <schaefer.christian@guj.de>
 * @version     SVN: $Id: BaseActions.class.php 12534 2008-11-01 13:38:27Z Kris.Wallsmith $
 */
abstract class BasegjShortUrlActions extends sfActions
{
  public function executeRedirect(sfWebRequest $request)
  {
    $shortUrl = $this->getRoute()->getObject();
    $target = ltrim($shortUrl->target, '@');
    if('/' != $shortUrl->target[0])
    {
      $params = array_merge($request->getParameterHolder()->getAll(), array('sf_route' => $target));
      $target = $this->getController()->genUrl($params);
    }

    $this->logMessage(sprintf('{gjShortUrlPlugin} Redirected from "%s" to "%s" (%d)',
      $shortUrl->source,
      $target,
      $shortUrl->code
    ));

    $this->redirect($target, $shortUrl->code);
  }
}
