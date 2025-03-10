<?php

namespace App\Enums;

enum RegexEnum: string
{
    case PHONE = '/(\+\d{1,2}\s?)?(\()?\d{0,4}\)?[\s.-]?\d{3}[\s.-]?\d{4}/';
    case PASSWORD = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/';
    case URL = '/^(http|https):\/\/[a-zA-Z0-9]+([\-\.]{1}[a-zA-Z0-9]+)*\.[a-zA-Z]{2,5}(([0-9]{1,5})?\/.*)?$/';
    case COUNTRY_CODE = '/^\+\d{1,3}$/';
    case PHONE_WITHOUT_CODE = '/(\()?\d{0,4}\)?[\s.-]?\d{3}[\s.-]?\d{4}/';
    case pricing = '/^\d+(\.\d{1,2})?$/';
}
