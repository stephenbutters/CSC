'''
<?php require_once('dbinfo.php'); ?>
<?php
	function raiseTeam($leader, $teamname, $class, $section, $remain, $desc) {
		$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, 'GJ_TEST_DB');
		if(mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			return;
		}
		$query = "SELECT * FROM `groupTeams` WHERE `class`='$class' AND `section`='$section' AND (`leader`='$leader' OR `username`='$leader') LIMIT 1";
		if($result = mysqli_query($link, $query)) {
			//ALREADY HAVE A TEAM OR BE IN A TEAM, RETURN '2'
			if(mysqli_num_rows($result) >= 1) {
				return "2";
			} 
			//IF NOT OWN A TEAM OR BE IN A TEAM, ADD THE TEAM INFO TO THE DB
			else {
				$query = "INSERT `groupTeams` VALUES ('$leader', '$leader', '$class', '$section', '$teamname', $remain, '$desc', curdate())";
				if(!mysqli_query($link, $query)) {
					return "-1"; //DB ERROR
				} else {
					return "0"; //SUCCESS
				}
			}
		} else {
			return "-1"; //DB ERROR
		}
	}
	mysqli_close($link);
?>
'''
import mysql.connector

class teammanager :
    cnx = None
    def __init__(self, cnx) :
        self.cnx = cnx
    def __del__(self) :
        self.cnx.close()
    def raise_team(self, leader, teamname, classstring, section, remain, desc) :
    	cursor = self.cnx.cursor(buffered=True)
    	raise_team = ("SELECT * FROM 'groupTeams' WHERE 'class'=%s AND 'section'=%s AND ('leader'=%s OR 'username'=%s) LIMIT 1")
    	data_raise_team = (classstring, section, leader, leader)
    	cursor.execute(raise_team, data_raise_team)
    	self.cnx.commit()
        if cursor.rowcount >= 1:
            #already have a team, return "2"
            return "2"
        else :
            #else, add the team info to db
            query = ("INSERT 'groupTeams' VALUES (%s, %s, %s, %s, %s, %s, %s, curdate())")
            data_query = (leader, leader, classstring, section, teamname, remain, desc)
            cursor.execute(query, data_query)
            self.cnx.commit()
            return "0"


    def join_teams(self, username, teamname, classstring, section) :
        cursor = self.cnx.cursor(buffered=True)
        query = ("SELECT * FROM 'groupTeams' WHERE ('leader'=%s OR 'username'=%s) AND 'class'=%s AND 'section'=%s LIMIT 1")
        data_query = (username, username, classstring, section)
        cursor.execute(query, data_query)
        self.cnx.commit()
        if cursor.rowcount >= 1 :
            return "2" # already have a team
        query = ("SELECT 'leader','remain','descs' FROM 'groupTeams' WHERE 'teamname'= %s AND 'class'=%s AND 'section'=%s LIMIT 1")
        data_query = (teamname, classstring, section)
        cursor.execute()
        self.cnx.commit()
        if cursor.rowcount > 0
        