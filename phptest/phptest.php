<?php
use PHPUnit\Framework\TestCase;

class phptest extends TestCase
{
    /**
     * userValidate test
     */
    public function test_userValidate()
    {
        include '../php/userValidate.php';

        //Test with a non-existing user
        $this->assertEquals(1, userValidate('www', '123'));
        $this->assertEquals(0, userValidate('hongkan', '123456'));
    }
}
?>
