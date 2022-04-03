<?php
 
namespace src\core;
     
class Validator {
        
        /**
         * @var array $patterns
         */
        public $patterns = array(
          'mobile' => '^[0-9]{10,11}$',
            'alpha'=> '^[a-zA-Z]+$',
           'alphanumeric'=> '^[a-zA-Z0-9]+$'
    );
        
        /**
         * @var array $errors
         */
        public $errors = array();
        public $sanitizeInput = array();
        
        
        /**
         * Nome del campo
         * 
         * @param string $name
         * @return this
         */
        public function name($name){
            
            $this->name = $name;
            return $this;
        
        }
        
        /**
         * Valore del campo
         * 
         * @param mixed $value
         * @return this
         */
        public function value($value){
            
          
            $this->value = $value;
            return $this;
        
        }
      // check age 
      public function checkDate($date){
          $current_date =date_create("now");
          $interval = date_diff($current_date, date_create($date))->format('%y');
          if($interval <= 4){
              $this->errors[] = "Minimum age required to register is 5 years";
          }
              
         
      }
        
        /*
         * Validation error message check 
         */
        public function pattern($name){
              
               
                foreach($name as $validator){
               
                    if(in_array($validator['name'] ,array_keys($this->patterns))){
                    $regex = '/^('.$this->patterns[$validator['name']].')$/u';
                if($this->value != '' && !preg_match($regex, $this->value)){
                    $this->errors[] = isset($validator['msg'])?$validator['msg']
                            : 'Format of '.$this->name.' not valid';
                }
                    }else{
                              $this->callValidation($validator);
                    }
                }
            return $this;
            
        }
        
        public function  callValidation($validator){
              switch($validator['name']):
                              case('required'):
                                  $this->required($validator['value']);
                                  break;
                              case('min'):
                                  $this->min($validator);
                                   break;
                              case('max'):
                                  $this->max($validator);
                                   break;
                               case('email'):
                                  $this->is_email($validator);
                                   break; 
                              default :
                                  //
                          endswitch;
                                  
        }
      
        
        /**
         * check for required field
         * 
         * @return this
         */
        public function required($value){
            
            if( ($this->value == '' || $this->value == null)){
                $this->errors[] = "Field ".$this->name." ".$value;
            }            
            return $this;
            
        }
        
        /**
         * Check for minimum length
         * 
         * @param int $length
         * @return this
         */
        public function min($validator){
            
            if(is_string($this->value)){
                
                if(strlen($this->value) < $validator['value']){
                    
                    //$this->errors[] = 'Please enter minimum '.$length." for ".$this->name;
                 //   $this->errors[] = $validator['msg'];
                    $this->errors[] = isset($validator['msg'])?$validator['msg']
                            :"Minimum ".$validator['value']." chars is allowed for ".$this->name;
                }
           
            }else{
                
                if($this->value < $validator['value']){
                  //  $this->errors[] = 'Please enter minimum '.$length." for ".$this->name;
                    $this->errors[] = isset($validator['msg'])?$validator['msg']
                            :"Minimum ".$validator['value']." digits is allowed for ".$this->name;
                }
                
            }
            return $this;
            
        }
            
        /**
         * Lunghezza massima
         * del valore del campo
         * 
         * @param int $max
         * @return this
         */
        public function max($validator){
            
            if(is_string($this->value)){
                
                if(strlen($this->value) > $validator['value']){
                    
                    $this->errors[] = isset($validator['msg'])?$validator['msg']
                            :"Maximum ".$validator['value']." chars is allowed for ".$this->name;
                        
                 //  $this->errors[] = 'Please enter maximum '.$length." for ".$this->name;
                }
           
            }else{
                
                if($this->value > $validator['value']){
                    $this->errors[] = isset($validator['msg'])?$validator['msg']
                            :"Maximum ".$validator['value']." digits is allowed for ".$this->name;
                }
                
            }
            return $this;
            
        }
        
    
        
        /**
         * Purifica per prevenire attacchi XSS
         *
         * @param string $string
         * @return $string
         */
        public function purify($string){
            return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
        }
        
        /**
         * Campi validati
         * 
         * @return boolean
         */
        public function isSuccess(){
            if(empty($this->errors)) return true;
        }
        
        /**
         * Errori della validazione
         * 
         * @return array $this->errors
         */
        public function getErrors(){
            if(!$this->isSuccess()) return $this->errors;
        }
        
        /**
         * Visualizza errori in formato Html
         * 
         * @return string $html
         */
        public function displayErrors(){
            
            $html = '<ul>';
                foreach($this->getErrors() as $error){
                    $html .= '<li>'.$error.'</li>';
                }
            $html .= '</ul>';
            
            return $html;
            
        }
        
        /**
         * Visualizza risultato della validazione
         *
         * @return booelan|string
         */
        public function result(){
            
            if(!$this->isSuccess()){
               
                foreach($this->getErrors() as $error){
                    echo "$error\n";
                }
                exit;
                
            }else{
                return true;
            }
        
        }
        
        /**
         * Verifica se il valore è
         * un numero intero
         *
         * @param mixed $value
         * @return boolean
         */
        public static function is_int($value){
            if(filter_var($value, FILTER_VALIDATE_INT)) return true;
        }
        
        /**
         * Verifica se il valore è
         * un numero float
         *
         * @param mixed $value
         * @return boolean
         */
        public static function is_float($value){
            if(filter_var($value, FILTER_VALIDATE_FLOAT)) return true;
        }
        
        /**
         * Verifica se il valore è
         * una lettera dell'alfabeto
         *
         * @param mixed $value
         * @return boolean
         */
        public static function is_alpha($value){
            if(filter_var($value, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => "/^[a-zA-Z]+$/")))) return true;
        }
        
        /**
         * Verifica se il valore è
         * una lettera o un numero
         *
         * @param mixed $value
         * @return boolean
         */
        public static function is_alphanum($value){
            if(filter_var($value, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => "/^[a-zA-Z0-9]+$/")))) return true;
        }
        
      
        /**
         * Verifica se il valore è
         * un'e-mail
         *
         * @param mixed $value
         * @return boolean
         */
        public function is_email($validator){
            if(!filter_var($this->value, FILTER_VALIDATE_EMAIL)) {
                   $this->errors[] =isset($validator['msg'])?$validator['msg']:
                       "Please enter valid email.";
            }      
                    
        }
 
        
    }
