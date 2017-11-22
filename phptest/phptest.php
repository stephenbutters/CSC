<?php
use PHPUnit\Framework\TestCase;

class phptest extends TestCase
{
    /**
     * registerusers test
     */
     public function test_registerusers()
     {
        include '../php/registerusers.php';

        //Test with a new user
        $this->assertEquals(0, registerUser('testing@ucla.edu', 'testing', '123456', '1234567890'));
        //Register same user again
        $this->assertEquals(2, registerUser('testing@ucla.edu', 'testing', '123456', '1234567890'));
     }

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

    /**
     * changePwd test
     */
    public function test_changePwd()
    {
        include '../php/changePwd.php';

        //Test with a non-existing user
        $this->assertEquals(2, changePwd('qwesfs', '123', 'dfajn@Gmail.com', '1234567893'));
        $this->assertEquals(0, changePwd('hongkan', '123456', 'hongkanliu@gmail.com', '1234567890'));
    }

    /**
     * classSectionExchange test
     */
    public function test_classSectionExchange()
    {
        include '../php/classSectionSubmit.php';
        include '../php/removeClassSection.php';

        // add a class section exchange
        $this->assertEquals(0, classSectionSubmit('hongkan', 'ART - 1A', '1C', '1A'));
        //Test add a duplicate class
        $this->assertEquals(1, classSectionSubmit('hongkan', 'ART - 1A', '1C', '1A'));
        // test with A REVERSE SECTION
        $this->assertEquals(2, classSectionSubmit('hongkan', 'ART - 1A', '1A', '1C'));

        // remove a class section exchange
        $this->assertEquals(0, removeClassSection('hongkan', 'ART - 1A', '1C', '1A'));
        //Test with a non-existing user/class exchange
        $this->assertEquals(1, removeClassSection('hongkan', 'ART - 1A', '1C', '1A'));

    }
}
?>
