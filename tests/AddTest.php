<?php
declare(strict_types=1);
// include "../vendor/autoload.php";


use PHPUnit\Framework\TestCase;

class AddTest extends PHPUnit\Framework\TestCase
{
    public function testAdd()
    {
        $this->assertEquals(7, add(3, 4));
    }

    public function testAddNegative()
    {
        $this->assertEquals(-7, add(-3, -4));
    }
}

function add($a, $b)
{
    return $a + $b;
}
