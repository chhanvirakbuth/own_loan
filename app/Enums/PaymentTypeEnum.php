<?php namespace App\Enums;

abstract class PaymentTypeEnum
{
    const
    LOAN_INTEREST = '1',
    DEPOSIT='2',
    REDEEM = '3',
    PAY_OFF = '4',
    WITHDRAW ='5'
    ;
}
