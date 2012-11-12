<?php

/**
 * SPasswordValidator 
 * 
 * Validator for passwords.
 * Ensure password is strong (at least with default parameters)
 * 
 * @author Sébastien Monterisi <sebastienmonterisi@gmail.com>
 * @version 0.01
 */
class SPasswordValidator extends CValidator
{

    /**
     *
     * @var int minimal number of chars
     */
    public $min = 6;

//  /*
//   * $var int maximum allowed password length.
//   */
//  public $maxLen = 0;
//
//  /*
//   * $var int minimum upper case letters required.
//   */
//  public $minUpperCase = 0;
//
//  /*
//   * $var int minimum lower case letters required.
//   */
//  public $minLowerCase = 0;
//
//  /*
//   * $var int minimum digets required.
//   */
//  public $minDigits = 0;
//
//  /*
//   * $var int minimum symbols required (e.g: !"§$%&/()=?.....).
//   */
//  public $minSym = 0;
//
//  /*
//   * $var bool allow whitespaces.
//   */
//  public $allowWhiteSpace = false;
//
//  /*
//   * $var int maximum character repetition.
//   */
//  public $maxRepetition = 0;

    /**
     * Validation
     * 
     * Function checks whether :
     * <ul>
     *  <li>Attribute is a string</li>
     *  <li>Minimal length is respected ($this->min)</li>
     * </ul>
     * @param CModel $object
     * @param string $attribute
     */
    protected function validateAttribute($object, $attribute)
    {
        $value = $object->$attribute;

        // is a string
        if(!is_string($value))
        {
            $this->addError($object, $attribute, Yii::t(__CLASS__, 
                                ":attribute is a :type and is must be a string.",
                                array(':attribute' => $attribute, ':type' => gettype($value))
                                )
              );
            return; // other checks will throw errors or exception, so end validation here.
        }
        
        // minimum length
        $this->min = (int) $this->min;
        $length = strlen($value);
      if ( $length < $this->min)
      {
//        $message = $this->message !== null ? $this->message : Yii::t('CPasswordValidator',
//            '{attribute} is too short (min. {num} characters).',
//            array('{num}' => $this->minLen));
//
        $this->addError($object, $attribute, Yii::t(__CLASS__, 
                                ":attribute length is too short. It's :nbr chars and it must be at least :min.",
                                array(':attribute' => $attribute, ':nbr' => $length, ':min' => $this->min)
                                )
              );
      }
//
//    if ($this->maxLen > 0)
//    {
//      if (strlen($value) > $this->maxLen)
//      {
//        $message = $this->message !== null ? $this->message : Yii::t('CPasswordValidator',
//            '{attribute} is too long (max. {num} characters).',
//            array('{num}' => $this->maxLen));
//
//        $this->addError($object, $attribute, $message);
//      }
//    }
//
//    if ($this->minLowerCase > 0)
//    {
//      if (preg_match_all('/[a-z]/', $value, $matches) < $this->minLowerCase)
//      {
//        $message = $this->message !== null ? $this->message : Yii::t('CPasswordValidator',
//            '{attribute} must include at least {num} lower case letters.',
//            array('{num}' => $this->minLowerCase));
//
//        $this->addError($object, $attribute, $message);
//      }
//    }
//
//    if ($this->minUpperCase > 0)
//    {
//      if (preg_match_all('/[A-Z]/', $value, $matches) < $this->minUpperCase)
//      {
//        $message = $this->message !== null ? $this->message : Yii::t('CPasswordValidator',
//            '{attribute} must include at least {num} upper case letters.',
//            array('{num}' => $this->minUpperCase));
//
//        $this->addError($object, $attribute, $message);
//      }
//    }
//
//    if ($this->minDigits > 0)
//    {
//      if (preg_match_all('/[0-9]/', $value, $matches) < $this->minDigits)
//      {
//        $message = $this->message !== null ? $this->message : Yii::t('CPasswordValidator',
//            '{attribute} must include at least {num} digits.',
//            array('{num}' => $this->minDigits));
//        
//        $this->addError($object, $attribute, $message);
//      }
//    }
//
//    if ($this->minSym > 0)
//    {
//      if (preg_match_all('/\W/', $value, $matches) < $this->minSym)
//      {
//        $message = $this->message !== null ? $this->message : Yii::t('CPasswordValidator',
//            '{attribute} must include at least {num} symbols.',
//            array('{num}' => $this->minSym));
//
//        $this->addError($object, $attribute, $message);
//      }
//    }
//
//    if (!$this->allowWhiteSpace)
//    {
//      if (preg_match('/\s/', $value))
//      {
//        $message = $this->message !== null ? $this->message : Yii::t('CPasswordValidator',
//            '{attribute} must not contain whitespace.',
//            array('{num}' => $this->minSym));
//        
//        $this->addError($object, $attribute, $message);
//      }
//    }
//
//    if ($this->maxRepetition > 0)
//    {
//      if (preg_match('/(.){1}\\1{' . ($this->maxRepetition - 1) . ',}/', $value))
//      {
//        $message = $this->message !== null ? $this->message : Yii::t('CPasswordValidator',
//            '{attribute} must not contain more than {num} sequentially repeated characters.',
//            array('{num}' => $this->maxRepetition));
//
//        $this->addError($object, $attribute, $message);
//      }
//    }
    }

}
?>