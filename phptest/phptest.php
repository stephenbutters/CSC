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

    /**
     * updateClassSection test
     */
    public function test_updateClassSection()
    {
        include '../php/updateClassSection.php';

        //non-existing user
        $this->assertEquals('[]', updateClassSection('userunknown'));
        //existing user
        $this->assertEquals('', updateClassSection('hongkan'));
    }

    /**
     * TeamUp test
     */
    public function test_TeamUp()
    {
        include '../php/raiseTeam.php';
        include '../php/removeGroupSection.php';

        //Try to create a team
        $this->assertEquals(0, raiseTeam('hongkan', 'TestTeam', 'AERO ST - A', '1A', '3', 'testing'));
        //create same team again
        $this->assertEquals(2, raiseTeam('hongkan', 'TestTeam', 'AERO ST - A', '1A', '3', 'testing'));

        //Remove the team
        $this->assertEquals(0, removeGroupSection('hongkan', 'TestTeam', 'AERO ST - A', '1A', '3', 'testing'));
    }

    /**
     * updateGroup test
     */
    public function test_updateGroup()
    {
        include '../php/updateGroup.php';

        $this->assertEquals('', updateGroup('AERO ST - A', 'hongkan'));
        $this->assertEquals('', updateGroup('AERO ST - A', 'userunknown'));
    }

    /**
     * updateGroupMain test
     */
    public function test_upadteGroupMain()
    {
        include '../php/updateGroupMain.php';

        $this->assertEquals('', updateGroupMain('hongkan'));
        $this->assertEquals('', updateGroupMain('userunknown'));
    }

    /**
     * joinTeams test
     * @depends test_TeamUp
     */
    public function test_joinTeams()
    {
        include '../php/raiseTeam';
        include '../php/removeGroupSection.php';
        include '../php/joinTeams.php';

        //Create a team first
        $this->assertEquals(0, raiseTeam('hongkan', 'TestTeam', 'AERO ST - A', '1A', '3', 'testing'));

        //Join a team
        $this->assertEquals(0, joinTeams('stephenbutters', 'TestTeam', 'AERO ST - A', '1A'));
        //Join again
        $this->assertEquals(2, joinTeams('stephenbutters', 'TestTeam', 'AERO ST - A', '1A'));

        //Remove
        $this->assertEquals(0, removeGroupSection('hongkan', 'TestTeam', 'AERO ST - A', '1A', '3', 'testing'));
    }

    /**
     * getMesg test
     */
    public function test_getMesg()
    {
        include '../php/getMesg.php';

        //Get the message
        $this->assertEquals('', getMesg('hongkan'));
    }

    /**
     * parkingPermit test
     */
    public function test_parkingPermit()
    {
        include '../php/submitParking.php';
        include '../php/removeParkingSection.php';

        //add a parking section
        $this->assertEquals(0, submitParking('hongkan', 'PARKING 1', 'PARKING 3', 'PARKING 4'));
        //duplicate
        $this->assertEquals(1, submitParking('hongkan', 'PARKING 1', 'PARKING 3', 'PARKING 4'));
        //add another parking section
        $this->assertEquals(0, submitParking('stephenbutters', 'PARKING 3', 'PARKING 1', 'PARKING 4'));

        //remove section
        $this->assertEquals(0, submitParking('hongkan', 'PARKING 1', 'PARKING 3', 'PARKING 4'));
        $this->assertEquals(0, removeParkingSection('hongkan'));
        //remove a non-existing section
        $this->assertEquals(1, removeParkingSection('hongkan'));
    }

    /*
     * updateParking test
     * @depends test_parkingPermit
     */
    public function test_updateParking()
    {
        include '../php/updateParking.php';

        //add a parking section first
        $this->assertEquals(0, submitParking('hongkan', 'PARKING 1', 'PARKING 3', 'PARKING 4'));
        $this->assertEquals('', updateParking('hongkan'));

        //remove it afterwards
        $this->assertEquals(0, removeParkingSection('hongkan'));
    }
}
?>
