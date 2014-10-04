<?php
namespace Craft;

/**
 * Unique Value by Josh Angell
 *
 * @package   Unique Value
 * @author    Josh Angell
 * @copyright Copyright (c) 2014, Josh Angell
 * @link      http://www.joshangell.co.uk
 */

class UniqueValueFieldType extends BaseFieldType
{

  public function getName()
  {
    return Craft::t('Unique Value');
  }

  public function getInputHtml($name, $value)
  {
    return craft()->templates->render('uniquevalue/input', array(
      'name'  => $name,
      'value' => $value
    ));
  }

  public function validate($value)
  {
    // get any current errors
    $errors = parent::validate($value);

    if (!is_array($errors))
    {
      $errors = array();
    }

    // get settings - we don't have any yet but this is just here to remind me
    // what I need when we do have them...
    $settings = $this->getSettings();

    // make and populate our model
    $model = new UniqueValueModel;
    $model->uniqueValue = array(
      'value'       => $value,
      'fieldHandle' => $this->model->handle,
      'elementId'   => $this->element->id
    );

    // validate the model
    if ( !$model->validate() ) {
      $errors = array_merge($errors, $model->getErrors('uniqueValue'));
    }

    // return errors or true
    if ($errors)
    {
      return $errors;
    }
    else
    {
      return true;
    }
  }

}