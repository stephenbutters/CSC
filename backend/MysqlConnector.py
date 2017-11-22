import mysql.connector

class mysqlconnector:
    
    '''
    todo:   declare user, passwd, host etc as instance variables
            make a constructor
            combine the following method into this class

            
    def mysql_connect():
        try:
            cnx = mysql.connector.connect(user='hongkan', password='aa6418463',
                                        host='realone.c0hpz27iuq3x.us-west-1.rds.amazonaws.com',
                                        database='GJ_TEST_DB')
        except mysql.connector.Error as err:
            if err.errno == errorcode.ER_ACCESS_DENIED_ERROR:
                print("Something is wrong with your user name or password")
            elif err.errno == errorcode.ER_BAD_DB_ERROR:
                print("Database does not exist")
            else:
                print(err)
        else:
            return cnx
    '''