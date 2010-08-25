<?php

/**
 * gjShortUrl form base class.
 *
 * @method gjShortUrl getObject() Returns the current form's model object
 *
 * @package    gjShortUrlPluginFixtureProject
 * @subpackage form
 * @author     Christian Schaefer <caefer@ical.ly>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasegjShortUrlForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'source'     => new sfWidgetFormInputText(),
      'target'     => new sfWidgetFormInputText(),
      'code'       => new sfWidgetFormInputText(),
      'begins_at'  => new sfWidgetFormDate(),
      'expires_at' => new sfWidgetFormDate(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'source'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'target'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'code'       => new sfValidatorInteger(array('required' => false)),
      'begins_at'  => new sfValidatorDate(array('required' => false)),
      'expires_at' => new sfValidatorDate(array('required' => false)),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'gjShortUrl', 'column' => array('source')))
    );

    $this->widgetSchema->setNameFormat('gj_short_url[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'gjShortUrl';
  }

}
