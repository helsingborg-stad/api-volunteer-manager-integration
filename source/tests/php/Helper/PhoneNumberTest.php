<?php

namespace APIVolunteerManagerIntegration\Tests\Helper;

use APIVolunteerManagerIntegration\Helper\PhoneNumber;
use PHPUnit\Framework\TestCase;

class PhoneNumberTest extends TestCase
{
    /** @dataProvider phoneNumbers */
    public function testDisplayAndUri(string $input, string $display, string $uri): void
    {
        $number = new PhoneNumber($input);

        $this->assertSame($display, $number->toHumanReadable());
        $this->assertSame($uri, $number->toUri());
    }

    public static function phoneNumbers(): array
    {
        return [
            'Swedish' => ['0701234567', '070-123 45 67', 'tel:+46-70-123-45-67'],
            'international' => ['+14155552671', '+1 415-555-2671', 'tel:+1-415-555-2671'],
            'empty' => ['', '', '#'],
            'unparseable' => ['not a number', 'not a number', '#'],
            'parseable but invalid' => ['123', '123', '#'],
        ];
    }
}
