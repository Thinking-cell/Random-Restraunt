<?php


    /****************************************************************************
    * I, Ranvir Singh, 000819787 certify that this material is my original work. 
    * No other person's work has been used without due acknowledgement
    ***************************************************************************/
    

require('vendor/autoload.php');


use Respect\Validation\Validator as v;

$field = $_POST['field'];
$valueToBeValidated = $_POST['value'];

$response = [
    'field' => $field,
    'value' => $valueToBeValidated,
    'error' => false,
];

switch($field) {
    case "employee_name":
        //  Checks whether there are any numbers in the string
        if(!v::alpha()->validate($valueToBeValidated))
            $response['error'] = "ERROR_NON_ALPHA";

        //  Check the name is proper length
        if(!v::stringType()->length(5, 20)->validate($valueToBeValidated))
            $response['error'] = "ERROR_LENGTH";
            
        break;

    case "employee_id":
        //  Checks the employee id is proper length
        if(!v::stringType()->length(9)->validate($valueToBeValidated))
            $response['error'] = "ERROR_LENGTH";

        //  Checks whether there are only numbers in the string
        if(!v::numericVal()->validate($valueToBeValidated))
            $response['error'] = "ERROR_NON_INT";

        break;

    case "department":
        if(strtolower($valueToBeValidated)==="advertisement"){
            $response['error'] = "ERROR_ELEMENT_NOTEXIST";
            break;
        }

        if(strtolower($valueToBeValidated)==="sales")
            $response['error'] = "BONUS_ENABLED";
        else
            $response['error'] = "BONUS_DISABLED";
        
        //  Checks the department
        

        
        break;  
    case "bonus":
        //  Checks whether there are only numbers in the string
        if(!v::numericVal()->validate($valueToBeValidated))
            $response['error'] = "ERROR_NON_INT";
        if(trim($valueToBeValidated,"")===""||$valueToBeValidated===NULL)
            $response['error'] = "ERROR_NULL_VALUE";
    
            
}


header('Content-Type: application/json');
echo json_encode($response);