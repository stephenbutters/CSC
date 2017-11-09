"""
yeeee
"""

import sys
import getopt
import mysql.connector
from mysql.connector import errorcode



def main():
    # my code here
    options, remainder = getopt.gnu_getopt(sys.argv[1:], 'upa', ['user=', 
                                                             'password=',
                                                             'action=',
                                                          ])

    user = "empty_user"
    password = "empty_password"
    action = "empty_action"

    for opt, arg in options:
        if opt in ('-u', '--user'):
            user = arg
        elif opt in ('-p', '--password'):
            password = arg
        elif opt in ('-a' '--action'):
            action = arg
    cnx = mysql_connect()
    create_user("YijingJiang", "12345", "yjy@ucla.edu", cnx)
    create_user("PaulEggert", "123456", "eggert@cs.ucla.edu", cnx)

    cnx.close()

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
        print("connected!")
        return cnx

def create_user(fullname, passwd, email, cnx):
    cursor = cnx.cursor()
    add_user = (    "INSERT INTO users"
                    "(fullname, email, hashed_passwd)"
                    "VALUES(%s, %s, %s)"
                )
    data_add_user = (fullname, email, passwd)
    cursor.execute(add_user, data_add_user)
    cnx.commit()
    cursor.close()

if __name__ == "__main__":
    main()



#the return value will be use stdout (python print)
#user login

# api:
# switchhub login:
# add user:
# switchhub.py --action=newuser --user= usernameemail --password=passwd
# it will write to the user.txt file
# print 1 if success, -1 if the user is not an email format

# the format of user.txt will be 
# ---
# user_name,encryptedpassword\n
# ---

# login as user:
# switchhub.py --action=loginuser --user= --password=
# it will search the line starts with user in user.txt, and verify the encrypted password
# the return value will be "1" if the user is verified, "-1" otherwise

# section switch cases
# a section switch case will include following information and follow this format
# useremail,class_dept,class_no,discussion_no_string,intended_discussion_no_string,status\n
# apis:
# switchhub.py --action=showusercases --user=user
# will return (lines of) section switching information using the correct file format (upwards)



