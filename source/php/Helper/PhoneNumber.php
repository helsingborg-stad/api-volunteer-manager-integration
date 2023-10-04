<?php

namespace APIVolunteerManagerIntegration\Helper;

use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;

class PhoneNumber
{
    private string $numberInput;
    private ?\libphonenumber\PhoneNumber $phoneNumber;
    private int $humanReadableFormat = PhoneNumberFormat::NATIONAL;

    public function __construct(string $number)
    {
        try {
            $this->numberInput = $number;

            $this->phoneNumber = (PhoneNumberUtil::getInstance())->parse(
                $number,
                'SE'
            );

            $this->humanReadableFormat = (PhoneNumberUtil::getInstance())->getRegionCodeForNumber($this->phoneNumber) !== 'SE'
                ? PhoneNumberFormat::INTERNATIONAL
                : PhoneNumberFormat::NATIONAL;

        } catch (NumberParseException $e) {
            $this->phoneNumber = null;
        }
    }

    public function toHumanReadable(): string
    {
        if (empty($this->phoneNumber) || ! (PhoneNumberUtil::getInstance())->isValidNumber($this->phoneNumber)) {
            return $this->numberInput;
        }

        return (PhoneNumberUtil::getInstance())->format($this->phoneNumber,
            $this->humanReadableFormat);
    }

    public function toUri(): string
    {
        if (empty($this->phoneNumber) || ! (PhoneNumberUtil::getInstance())->isValidNumber($this->phoneNumber)) {
            return '#';
        }

        return (PhoneNumberUtil::getInstance())->format($this->phoneNumber,
            PhoneNumberFormat::RFC3966);
    }
}