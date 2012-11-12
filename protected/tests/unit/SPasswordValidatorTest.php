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
 * with Changed params
 * <ul>
 * <li>changed low param</li>
 * <li>changed up param</li>
 * <li>changed spec param</li>
 * <li>changed digit param</li>
 * <li>changed min param (@see ::testOnInsufficientNumberOfCharacters() )</li>
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
            
}

?>
