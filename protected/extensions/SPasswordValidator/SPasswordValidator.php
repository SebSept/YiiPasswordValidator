<?php
/**
 * SPasswordValidator
 *
 * Validator for passwords.
 * Ensure password is strong (at least with default parameters)
 *
 * @author Sébastien Monterisi <sebastienmonterisi@yahoo.fr>
 * @version 1.2
 */
class SPasswordValidator extends CValidator
{
    /**
     *
     * @var int minimal number of characters
     */
    public $min = 8;

    /**
     * @var int minimal number of lower case characters
     */
    public $low = 2;

    /**
     * @var int minimal number of upper case characters
     */
    public $up = 2;

    /**
     *
     * @var int minimal number of special characters
     */
    public $spec = 2;

    /**
     *
     * @var int  minimal number of digit characters
     */
    public $digit = 2;

    /**
    * No limit if not set. Provided to avoid using length validator
    * @var int maximum number of chars
    */
    public $max;

    /**
    * If not null preset params will override other params
    * @var string preset - a set of parameters, @see $_preset
    */
    public $preset;

    /**
    * Do not set a max param in preset because it will override the one provided by validator param
    * @var preset allowed values
    */
    private $_presets = array(
	self::PRESET_RELAX => array(
		'min' => 6,
		'up' => 1,
		'low' => 1,
		'digit' => 1,
		'spec' => 0
	),
	self::PRESET_NORMAL => array(
                'min' => 6,
                'up' => 2,
		'low' => 2,
                'digit' => 1,
                'spec' => 1
        ),
	self::PRESET_STRONG => array(
                'min' => 8,
                'up' => 2,
		'low' => 2,
                'digit' => 2,
                'spec' => 2
        ),
);

    const PRESET_RELAX = 'relax';
    const PRESET_NORMAL = 'normal';
    const PRESET_STRONG = 'strong';



    /**
     * Validation
     *
     * Function checks whether fulfill this requirements  :
     * <ul>
     *  <li>is a string</li>
     *  <li>has the minimal number of lower case characters</li>
     *  <li>has the minimal number of upper case characters</li>
     *  <li>has the minimal number of digit characters </li>
     *  <li>has the minimal number of special characters </li>
     *  <li>has the minimal length is respected</li>
     * </ul>
     * @param CModel $object
     * @param string $attribute
     */
    protected function validateAttribute($object, $attribute)
    {
        $this->applyPreset();
        $this->checkParams();

        $value = $object->$attribute;

        // is a string
        if (!is_string($value))
        {
            $this->addError($object, 
                            $attribute, 
                            ":attribute is a :type and is must be a string.", 
                            array(':attribute' => $attribute, ':type' => gettype($value))
            );
            return; // other checks will throw errors or exception, so end validation here.
        }

        // number of lower case characters
        $found = preg_match_all('![a-z]!', $value, $whatever);
        if ($found < $this->low)
        {
            $this->addErrorInternal($object, 
                            $attribute, 
                           'lower case',
                            array('found' => $found, 'required' => $this->low)
            );            
        }

        // number of upper case characters
        $found = preg_match_all('![A-Z]!', $value, $whatever);
        if ($found < $this->up)
        {
            $this->addErrorInternal($object, 
                            $attribute, 
                            'upper case',
                            array('found' => $found, 'required' => $this->up)
            );
        }
        
        // special characters
        $found = preg_match_all('![\W]!', $value, $whatever);
        if ($found < $this->spec)
        {
            $this->addErrorInternal($object, 
                            $attribute, 
                            'special', 
                            array('found' => $found, 'required' => $this->spec)
            );
        }

        // digit characters
        $found = preg_match_all('![\d]!', $value, $whatever);
        if ($found < $this->digit)
        {
            $this->addErrorInternal($object, 
                            $attribute, 
                            'digit', 
                            array('found' => $found, 'required' => $this->digit)
            );
        }

        // minimum length
        $this->min = (int) $this->min;
        $found = strlen($value);
        if ($found < $this->min)
        {
            $this->addErrorInternal($object, 
                                    $attribute, 
                                    "", 
                                    array('found' => $found, 'required' => $this->min)
            );
        }

        // max length
        $found = strlen($value);
        if($this->max && ($found > $this->max) )
        {
		$this->addErrorInternal($object, 
                                    $attribute, 
                                    "max", 
                                    array('found' => $found, 'required' => $this->max)
            );

        }
    }

    /**
    * Apply Preset parameter if set
    * @return void
    */
    private function applyPreset()
    {
        if(!$this->preset)
            return;

        if(array_key_exists($this->preset, $this->_presets))
        {
             foreach($this->_presets[$this->preset] As $param => $value)
             {
                 $this->$param = $value;
             }
        }
	else
		throw new CException("invalid preset '$this->preset'.");
    }

    /**
    * Checks the provided parameters
    * Checks if sum of required params values is greater than max
    * @throw CException if more than max
    */
    private function checkParams()
    {
        $this->max = (int) $this->max;
        if($this->max && ($this->up + $this->digit + $this->low + $this->spec) > $this->max)
	    throw new CException('Total number of required characters is greater than max : Validation is impossible !');
    }

    /**
    * Adds an error about the specified attribute to the active record.
    * This is a helper method that call addError which performs message selection and internationalization.
    *
    * Construct the message and the params array to call addError().
    *
    * @param CModel $object the data object being validated
    * @param string $attribute the attribute being validated
    * @param string $tested_param the tested property (eg 'upper case') for generating the error message
    * @param array $values values for the placeholders :is and :should in the error message - array(['found'] => <int>, ['required'] => <int>)
    *
    * @todo change message for correct message with 'max' param
    */
    private function addErrorInternal($object, $attribute,$tested_param, array $values)
    {
        $message = ":attribute doesn't contain enough :tested_param characters. :found found whereas it must be at least :required."; 
        $params = array(':attribute' => $attribute, ':tested_param' => $tested_param, ':found' => $values['found'], ':required' => $values['required']);
        parent::addError($object, $attribute, $message, $params);
    }

}

