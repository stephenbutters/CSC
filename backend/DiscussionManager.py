import mysql.connector
import json

class discussionManager :
    cnx = None
    def __init__(self, cnx):
        self.cnx = cnx
    def __del__(self):
        self.cnx.close()

    def add_class(self, userid, classstring, disfrom, disto):
        cursor = self.cnx.cursor()
        add_class = (    "INSERT INTO dis_cases"
                        "(userid, classstr, dis_from, dis_to, status)"
                        "VALUES(%s, %s, %s, %s, %s)"
                    )
        data_add_class = (userid, classstring, disfrom, disto, "pending")
        cursor.execute(add_class, data_add_class)
        self.cnx.commit()
        cursor.close()
        return "0"
    def remove_class(self, userid, classstring):
        cursor = self.cnx.cursor()
        query = (    "DELETE FROM dis_cases WHERE classstr=%s AND userid=%s"
                )
        data_query = (classstring, userid)
        cursor.execute(query, data_query)
        self.cnx.commit()
        cursor.close()
        return "0"

    def getJSON(self, userid):
        cursor = self.cnx.cursor(dictionary=True, buffered=True)
        query = ("SELECT classstr, dis_from, dis_to, status FROM dis_cases WHERE userid=%s")
        data_query = (userid,)
        cursor.execute(query, data_query)
        self.cnx.commit()
        ret = "{\"cases\":["
        for row in cursor :
            ret += json.dumps(row)
            ret += ","
        ret = ret[:len(ret)-1]
        ret += "]}"
        print(ret)