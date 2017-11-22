import mysql.connector
import sys

class loginManager:
    print (sys.__doc__)
    cnx = None

    def __init__(self, cnx):
        self.cnx = cnx
    def __del__(self):
        self.cnx.close()

    def login_user(self, fullname, passwd):
        cursor = self.cnx.cursor(buffered=True)
        query = (
            "SELECT id FROM users WHERE fullname = %s AND hashed_passwd = %s"
        )
        cursor.execute(query, (fullname, passwd))
        self.cnx.commit()
        tmp = None
        if cursor.rowcount == 0 :
            return "-1"
        else:
            tmp = str(cursor.fetchone()[0])    
        cursor.close()
        return tmp
        


    def create_user(self, fullname, passwd, email, phone):
        cursor = self.cnx.cursor()
        add_user = (    "INSERT INTO users"
                        "(fullname, email, phone, hashed_passwd)"
                        "VALUES(%s, %s, %s, %s)"
                    )
        data_add_user = (fullname, email, phone, passwd)
        cursor.execute(add_user, data_add_user)
        self.cnx.commit()
        cursor.close()
        return self.login_user(fullname, passwd)