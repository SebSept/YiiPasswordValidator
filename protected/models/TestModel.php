<?php
/**
 * TestModel
 * 
 * The model for the tests
 * 
 * @property string $password A password
 * 
 * @author Sébastien Monterisi <sebastienmonterisi@gmail.com>
 * @version 1
 */
class TestModel extends CModel
{
    /**
     * Attribute to test against rules()
     * @var string Password 
     */
    public $password;
    
    /**
     * Default rule for password attribute, no option
     * @var type 
     */
    private $_initialRule = array('password','ext.SPasswordValidator.SPasswordValidator');
    
    public $ruleOptions = array();


    public function rules()
    {
        if(!empty($this->ruleOptions))
           return array( $this->ruleOptions );
        else
            return array( $this->_initialRule);
    }
    
    public function attributeNames()
    {
        return array(
            'password' => 'password'
        );
    }
}
