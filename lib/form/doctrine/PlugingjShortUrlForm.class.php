<?php

/**
 * PlugingjShortUrl form.
 *
 * @package    gjShortUrlPlugin
 * @subpackage form
 * @author     Christian Schaefer <schaefer.christian@guj.de>
 * @version    SVN: $Id: sfDoctrineFormPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PlugingjShortUrlForm extends BasegjShortUrlForm
{
  public function setup()
  {
    parent::setup();

    unset($this['created_at'], $this['updated_at']);
  }
}
