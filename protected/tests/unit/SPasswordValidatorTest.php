<?php
/**
 * Tests for SPasswordValidator
 * 
 * With Default params
 * <ul>
 *  <li>password NULL</li>
 *  <li>empty (string '')</li>
 *  <li>non string (array)</li>
 *  <li>insufficient lower case characters</li>
 *  <li>insufficient upper case characters</li>
 *  <li>insufficient digit characters</li>
 *  <li>insufficient special characters</li>
 *  <li>insufficient total number of characters (also check changing min param)</li>
 * </ul>
 *
 * With Changed params
 * <ul>
 * <li>changed low param</li>
 * <li>changed up param</li>
 * <li>changed spec param</li>
 * <li>changed digit param</li>
 * <li>changed min param (@see ::testOnInsufficientNumberOfCharacters() )</li>
 * </ul>
 *
 * With Presets
 * <ul>
 * <li>uniexistant preset</li>
 * <li>presets 'relax', 'normal', 'strong' exist</li>
 * <li>tests the presets</li>
 * </ul>
 * 
 * @author Sebastien Monterisi <sebastienmonterisi@yahoo.fr>
 */
class SPasswordValidatorTest extends CTestCase
{

    /**
     * Instance of TestModel
     * @var TestModel
     */
    private $model;

    /**
     * Prepare test variables
     */
    public function setUp()
    {
        $this->model = new TestModel();
    }

    /**
     * Assert that the string in param is present in the error messages.
     *
     * Checks in $this->model->errors array.
     *
     * @param string $string Error message to find
     * @return void
     */
    private function assertErrorStringHas($search)
    {
        $found = false;
        foreach ($this->model->errors as $err)
        {
            foreach ($err as $err_str)
            {
                if(strpos($err_str, $search) !== false)
                {
                    $found = true;
                    break 2;
                }
            }
        }
        $this->assertTrue($found, "'$search' not found in errors messages");
    }

    /**
     * password null
     */
    public function testOnNull()
    {
        $this->assertFalse($this->model->validate());
        $this->assertErrorStringHas('must be a string');
    }

    public function testOnNonString()
    {
        $this->model->password = array();
        $this->assertFalse($this->model->validate());
    }
    /**
     * password empty ('')
     */
    public function testOnEmpty()
    {
        $this->model->password = '';
        $this->assertFalse($this->model->validate());
//        $this->assertErrorStringHas('too short');
    }

    /**
     * password with just one lower case character
     */
    public function testOnInsufficientLower()
    {
        $this->model->password = 'aGTYP!§%57';
        $this->assertFalse($this->model->validate());
        $this->assertErrorStringHas('lower case');
    }

     /**
     * password with no upper case character
     */
    public function testOnInsufficientUpper()
    {
        $this->model->password = 'zgtyp!§%57';
        $this->assertFalse($this->model->validate());
        $this->assertErrorStringHas('upper case');
    }

     /**
     * password with no special character
     */
    public function testOnInsufficientSpecial()
    {
        $this->model->password = 'zgtypTKV57';
        $this->assertFalse($this->model->validate());
        $this->assertErrorStringHas('special');
    }

     /**
     * password with no special character
     */
    public function testOnInsufficientDigit()
    {
        $this->model->password = 'zgtypTKV^é-';
        $this->assertFalse($this->model->validate());
        $this->assertErrorStringHas('digit');
    }

    /**
     * - password without enough characters /  min = 10
     * - test SPasswordValidor 'min' param
     */
    public function testOnInsufficientNumberOfCharacters()
    {
        $this->model->ruleOptions = array('password','ext.SPasswordValidator.SPasswordValidator', 'min' => 10);
        $this->model->password = 'zgTK^é84';
        $this->assertFalse($this->model->validate());
    }

    /**
     * - Validation ok, all conditions satisfied
     */
    public function testValidationOk()
    {
        $this->model->password = 'zgTK^é84';
        $this->assertTrue($this->model->validate());
    }


    /**
     * - test SPasswordValidor 'low' param 
     */
    public function testChangedLow()
    {
        $this->model->password = 'aGTYP!§%57';
        $this->model->ruleOptions = array('password','ext.SPasswordValidator.SPasswordValidator', 'low' => 1);
        $this->assertTrue($this->model->validate());
    }

     /**
     * - test SPasswordValidor 'up' param
     */
    public function testChangedUp()
    {
        $this->model->password = 'abg4!§%57';
        $this->model->ruleOptions = array('password','ext.SPasswordValidator.SPasswordValidator', 'up' => 0);
        $this->assertTrue($this->model->validate());
    }

    /**
    * - test SPasswordValidor 'digit' param
    */
    public function testChangedDigit()
    {
        $this->model->password = 'aGTYP!§%5x';
        $this->model->ruleOptions = array('password','ext.SPasswordValidator.SPasswordValidator', 'digit' => 1);
        $this->assertTrue($this->model->validate());
    }

    /**
    * - test SPasswordValidor 'spec' param
    */
    public function testChangedSpec()
    {
        $this->model->password = 'aGTYPdze57m';
        $this->model->ruleOptions = array('password','ext.SPasswordValidator.SPasswordValidator', 'spec' => 0);
        $this->assertTrue($this->model->validate());
    }

    /**
    * Undefined preset throw exception
    * @expectedException CException
    */
    public function testPresetUndefined()
    {
        $this->model->ruleOptions = array('password','ext.SPasswordValidator.SPasswordValidator', 'preset' => 'doesntexists');
        $this->model->validate();
    }

    /**
    * Preset 'relax' exists
    * no exception so that preset exists
    */
    public function testPresetExistsRelax()
    {
        $this->model->ruleOptions = array('password','ext.SPasswordValidator.SPasswordValidator', 'preset' => 'relax');
        $this->model->validate();
    }

    /**
    * Preset 'normal' exists
    */
    public function testPresetExistsNormal()
    {
        $this->model->ruleOptions = array('password','ext.SPasswordValidator.SPasswordValidator', 'preset' => 'normal');
        $this->model->validate();
    }

    /**
    * Preset 'strong' exists
    */
    public function testPresetExistsStrong()
    {
        $this->model->ruleOptions = array('password','ext.SPasswordValidator.SPasswordValidator', 'preset' => 'strong');
        $this->model->validate();
    }

    /**
    * Preset 'relax' validation
    */
    public function testPresetValidateRelax()
    {
	$this->model->password = 'Sebv7x';
        $this->model->ruleOptions = array('password','ext.SPasswordValidator.SPasswordValidator', 'preset' => 'relax');
        $this->assertTrue($this->model->validate());
    }

    /**
    * Preset 'normal' validation
    */
    public function testPresetValidateNormal()
    {
	$this->model->password = 'SEb7x/';
        $this->model->ruleOptions = array('password','ext.SPasswordValidator.SPasswordValidator', 'preset' => 'normal');
        $this->assertTrue($this->model->validate());
    }

    /**
    * Preset 'strong' validation
    */
    public function testPresetValidateStrong()
    {
	$this->model->password = '/SeBv77/';
        $this->model->ruleOptions = array('password','ext.SPasswordValidator.SPasswordValidator', 'preset' => 'strong');
        $this->assertTrue($this->model->validate());
    }

    /**
    * Params set by preset param overrides single params
    * @todo doc
    */
    public function testPresetOverridesSingle()
    {
        $this->markTestIncomplete();
    }

    /**
    * Param 'max'
    */
    public function testParamMax()
    {
        $this->model->password = '/SeBv77soit"soverTen/';
        $this->model->ruleOptions = array('password','ext.SPasswordValidator.SPasswordValidator', 'max' => 10);
        $this->assertFalse($this->model->validate());
        //$this->markTestIncomplete();
    }

    /**
    * Param 'max' is too low for the attribute to validate
    * eg 2 digits + 3 uppers and 'max'=4 : validation is impossible
    * @exceptedException CException 
    */
    public function testMaxTooLow()
    {
        $this->markTestIncomplete();
    }

}

?>
