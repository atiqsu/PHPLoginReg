<?php
/**
 * Class for form validation
 * 
 * @author Alexander Aasebø <alexander@aasebo.net>
 * @version 0.1
 */
class validator {
    protected $errorHandler;
    
    protected $rules = ['required', 'minlength', 'maxlength', 'email', 'alnum'];

    public $messages = [
        'required' => 'The :field field is required',
        'minlength' => 'The :field field must be a minimum length of :satisfier',
        'maxlength' => 'The :field field must be a maximum length of :satisfier',
        'email' => 'The email is not a valid email adress',
        'alnum' => 'The :field field must be alphanumeric',
    ];


    public function __construct(errorhandler $errorHandler) {
        $this->errorHandler = $errorHandler;
    }
    
    public function check($items, $rules) {
        foreach ($items as $item => $value){
            if (in_array($item, array_keys($rules))){
                $this->validate([
                    'field' => $item,
                    'value' => $value,
                    'rules' => $rules[$item],
                ]);
            }
        }
        
        return $this;
    }
    
    public function fails() {
        return $this->errorHandler->hasErrors();
    }


    public function errors() {
        return $this->errorHandler;
    }
    
    private function validate($item) {
        $field = $item['field'];
        
        foreach ($item['rules'] as $rule => $satisfier) {
            if(in_array($rule, $this->rules)){
                if (!call_user_func_array([$this, $rule], [$field, $item['value'], $satisfier])){
                    $this->errorHandler->addError(
                        str_replace([':field', ':satisfier'],[$field, $satisfier], $this->messages[$rule]),
                        $field
                    );
                }
            }
        }
    }
    
    protected function required($field, $value, $satisfier) {
        return !empty(trim($value));
    }
    
    protected function minlength($field, $value, $satisfier) {
        return mb_strlen($value) >= $satisfier;
    }
    
    protected function maxlength($field, $value, $satisfier) {
        return mb_strlen($value) <= $satisfier;
    }
    
    protected function email($field, $value, $satisfier) {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }
    
    protected function alnum($field, $value, $satisfier) {
        return ctype_alnum($value);
    }
    
}

