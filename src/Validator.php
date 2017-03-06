<?php
namespace Andrewbain\Validator;

use Carbon\Carbon;
/**
 * Database create, insert, update, delete functions
 *
 * @link       ani-dev.com
 * @since      1.0.0
 *
 * @package    Validator
 * @subpackage Validator/Validator
 */

/**
* 
*/
/**
* 
*/
class Validator
{
  public $errors = ['type' => 'error' , 'errors' => []];
  
  public function validate($request, $types, $field)
  {
    $errors =[];

    if(in_array('required', $types)){

      if ($this->is_empty($request, $field)) array_push($errors, $this->is_empty($request, $field));

    }
    if(count($errors)==0){

      foreach ($types as $type) {
        if($type == 'time'){
          if($this->is_not_time($request, $field)) array_push($errors, $this->is_not_time($request, $field));
        }
        if($type == 'email'){
          if($this->is_not_email($request, $field)) array_push($errors, $this->is_not_email($request, $field));
        }
        if($type == 'numeric'){
          if($this->is_not_numeric($request, $field)) array_push($errors, $this->is_not_numeric($request, $field));
        }
        if($type == 'confirm'){
          if($this->is_not_equal($request, $field)) array_push($errors, $this->is_not_equal($request, $field));
        }
        if($type == 'checked'){
          if($this->is_not_checked($request, $field)) array_push($errors, $this->is_not_checked($request, $field));
        }
        if($type == 'not_past_date'){
          if($this->is_date_in_the_past($request, $field)) array_push($errors, $this->is_date_in_the_past($request, $field));
        }
      }
    } 
    foreach (array_filter($errors) as $key => $value) {
      array_push($this->errors['errors'], $value);
    }
    if(count($errors) > 0){
      http_response_code('422');
      header('Status: 422 Unprocessable Entity');
      return json_encode($this->errors);

    } 
  }

  public function is_empty($request, $field){

    if( $request == NULL ) {
      $error['message'] = 'The ' . $field . ' field cannot be empty';
      $error['field'] = str_replace(' ', '_', $field);
    
      return $error;

    }

  }

  public function is_not_email($request, $field){

    if(!filter_var($request, FILTER_VALIDATE_EMAIL)){
      
      $error['message'] = 'Please provide a valid email';
      $error['field'] = str_replace(' ', '_', $field);

      return $error;
    }
  }

  private function is_not_time($request, $field){

    if(!preg_match('/^([0-1][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/', $request)){
      
      $error['message'] = 'Please enter a correct time';
      $error['field'] = str_replace(' ', '_', $field);

      return $error;
    }
  }
  public function is_not_date($request, $field){
    //to do
    return;
  }
  public function is_date_time_in_the_past($request, $field)
  {
    if( Carbon::parse($request) < Carbon::now() ){
          $error['message'] = 'The ' . $field . ' cannot be in the past';
          $error['field'] = str_replace(' ', '_', $field);
          return $error;
      }   
  }
  

  public function is_date_in_the_past($request, $field){
    if( !$this->is_not_date($request, $field) ){
      if( $this->is_date_time_in_the_past($request, $field) ){
        if( !Carbon::parse($request)->isToday() ){
          $error['message'] = 'The ' . $field . ' cannot be in the past';
          $error['field'] = str_replace(' ', '_', $field);
          return $error;
        }
      }   
    }
  }
  private function is_not_numeric($request, $field){

    $request = str_replace('+', '', $request);

    if(!is_numeric($request)){
      
      $error['message'] = 'The ' . $field . ' field must be numbers only';
      $error['field'] = str_replace(' ', '_', $field);

      return $error;
    }
  }

  private function is_not_equal($request, $field){

    if($request[0] !== $request[1]){
      $error['message'] = 'The ' . $field . ' fields don\'t match';
      $error['field'] = str_replace(' ', '_', $field);

      return $error;
    }
      
  }

  private function is_not_checked($request, $field){
    if( !isset($request) ) {
    
      $error['message'] = 'The ' . $field . ' box must be checked';
      $error['field'] = str_replace(' ', '_', $field);
      return $error;

    }
  }
  
}