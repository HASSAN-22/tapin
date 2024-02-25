<?php

namespace Tapin\Exceptions;

class ProductStructureException extends \Exception
{
    private $fieldName;

    public function __construct($fieldName = "")
    {
        parent::__construct("Products array structure not allowed", 500, null);
        $this->fieldName = $fieldName;
    }

    public function getFieldName()
    {
        return $this->fieldName;
    }
}