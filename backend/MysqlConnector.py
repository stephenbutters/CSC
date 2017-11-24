import mysql.connector

class mysqlconnector:
    user = None
    password = None
    host = None
    database = None
    
    def __init__(self, user, password, host, database):
        self.user = user
        self.password = password
        self.host = host
        self.database = database
        
    
    '''
    todo:   declare user, passwd, host etc as instance variables
            make a constructor
            combine the following method into this class
    '''
            
    def mysql_connect(self):
        try:
            cnx = mysql.connector.connect(self.user, self.password, self.host,self.database)
        except mysql.connector.Error as err:
            if err.errno == errorcode.ER_ACCESS_DENIED_ERROR:
                print("Something is wrong with your user name or password")
            elif err.errno == errorcode.ER_BAD_DB_ERROR:
                print("Database does not exist")
            else:
                print(err)
        else:
            return cnx
    