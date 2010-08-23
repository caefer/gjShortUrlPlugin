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
    $this->logMessage(sprintf('{gjShortUrlPlugin} Redirected from "%s" to "%s" (%d)',
      $shortUrl->source,
      $shortUrl->target,
      $shortUrl->code
    ));

    $this->redirect($shortUrl->target, $shortUrl->code);
  }
}
