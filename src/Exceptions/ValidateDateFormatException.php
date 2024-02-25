<?php

namespace Tapin\Exceptions;

class ValidateDateFormatException extends \Exception
{
    private $fieldName;

    public function __construct($fieldName = "")
    {
        parent::__construct("The date format is not valid. Date format should be 'YYYY-MM-DD'.", 500, null);
        $this->fieldName = $fieldName;
    }

    public function getFieldName()
    {
        return $this->fieldName;
    }
}