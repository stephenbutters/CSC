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

    public function test_changePwd()
    {
        include '../php/changePwd.php';

        //Test with a non-existing user
        $this->assertEquals(2, changePwd('qwesfs', '123', 'dfajn@Gmail.com', '1234567893'));
        $this->assertEquals(0, changePwd('hongkan', '123456', 'hongkanliu@gmail.com', '1234567890'));
    }

    public function test_classSectionExchange()
    {
        include '../php/classSectionSubmit.php';
        include '../php/removeClassSection.php';

        // add a class section exchange
        $this->assertEquals(0, classSectionSubmit('hongkan', 'ART - 1A', '1C', '1A');       
        //Test add a duplicate class
        $this->assertEquals(1, classSectionSubmit('hongkan', 'ART - 1A', '1C', '1A');
        // test with A REVERSE SECTION
        $this->assertEquals(1, classSectionSubmit('hongkan', 'ART - 1A', '1A', '1C');

        // remove a class section exchange
        $this->assertEquals(0, removeClassSection('hongkan', 'ART - 1A', '1C', '1A'));

        //Test with a non-existing user

        // TEST ALREADY HAVE A REVERSE SECTION CHANGE ENTRY, RETURN '2'
        $this->assertEquals(2, classSectionSubmit('hongkan', '$className, "1A", "1C"));
        $this->assertEquals(0, classSectionSubmit('hongkan', '123456', 'hongkanliu@gmail.com', '1234567890'));
    }
}
?>
