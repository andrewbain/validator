<?php 
use Carbon\Carbon;
/**
*  Corresponding Class to test YourClass class
*
*  For each class in your library, there should be a corresponding Unit-Test for it
*  Unit-Tests should be as much as possible independent from other test going on.
*
*  @author yourname
*/

class ValidatorTest extends PHPUnit_Framework_TestCase{
	
 public function setUp()
  {
      parent::setUp();
      $this->validator = new Andrewbain\Validator\Validator;
      $this->now = Carbon::now();   
  }
  /**
  * Just check if the Validator has no syntax errors 
  *
  */

  public function testIsThereAnySyntaxError()
  {
  	$this->assertTrue(is_object($this->validator));
  	unset($this->validator);
  }
  
  public function testIsEmpty()
  {
    $validate = $this->validator->is_empty('', 'email');
  	$this->assertTrue($validate['message'] == 'The email field cannot be empty');
    $this->assertTrue($validate['field'] == 'email');
  	unset($this->validator);
  }

  public function testIsNotEmail()
  {
    $valid = $this->validator->is_not_email('andrew.d.bain@gmail.com', 'email');
    $invalid = $this->validator->is_not_email('andrew.d.bain.com', 'email');
    $this->assertNull($valid);
    $this->assertTrue($invalid['message'] == 'Please provide a valid email');
    unset($this->validator);
  }
  public function testIsNotDate()
  {
   //to do
  }
  public function testIsDateInThePast()
  {
    $validate = $this->validator->is_date_in_the_past('2006-06-20', 'date');
    $this->assertTrue($validate['message'] == 'The date cannot be in the past');
    $validate = $this->validator->is_date_in_the_past($this->now->toDateString(), 'date');
     $this->assertNull($validate);
   
    unset($this->validator);
  }
  public function testIsDateTimeInThePast()
  {
    $validate = $this->validator->is_date_time_in_the_past('2006-06-20 07:50:00', 'time');
    $this->assertTrue($validate['message'] == 'The time cannot be in the past');
    $validate = $this->validator->is_date_time_in_the_past($this->now->addMinute(), 'date');
    $this->assertNull($validate);
   
    unset($this->validator);
  }

  //need to comment out header setting in Validate method to run this test
  // public function testValidate()
  // {
   

  //   $validate = $this->validator->validate('2012-06-20', ['not_past_date'], 'date');
  //   $this->assertJson($validate);
  //   $validate = $this->validator->validate('2020-06-20', ['not_past_date'], 'date');
  //   $this->assertNull($validate);
  // }
  


  
}