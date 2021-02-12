<?php

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
}


header('Content-Type: application/json');
echo json_encode($response);