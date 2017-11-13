<?php
use PHPUnit\Framework\TestCase;

class PhpTest extends TestCase
{
    /**
     * userValidate test
     * @expectedException PHPUnit\Framework\Error\Notice
     * @expectedException PHPUnit\Framework\Error\Warning
     */
    public function test_userValidate()
    {
        include '../userValidate.php';
    }
}
?>
