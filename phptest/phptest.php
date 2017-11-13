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
        //Test with a existing active user
        $this->assertEquals(0, userValidate('hongkan', '123456'));
        //Test with a existing non-active user
        $this->assertEquals(2, userValidate('nonactive', '1234567890'));
    }
}
?>
