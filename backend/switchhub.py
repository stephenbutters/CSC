"""
yeeee
"""

import sys
import getopt
import mysql.connector
import LoginManager
import DiscussionManager

from mysql.connector import errorcode

def main():
    # my code here
    options, remainder = getopt.gnu_getopt(sys.argv[1:], 'upcea', ['user=',
                                                             'password=',
                                                             'cellphone=',
                                                             'email=', 
                                                             'classstring=',
                                                             'sectionfrom=',
                                                             'sectionto=',
                                                             'userid=',                                                  
                                                             'action='                                       
                                                          ])

    user = "empty_user"
    password = "empty_password"
    cellphone = "empty_phone"
    action = "empty_action"
    email = "empty_email"
    classstring = "empty_class"
    sectionfrom = "empty_section"
    sectionto = "empty_section"
    userid = "empty_userid"

    for opt, arg in options:
        if opt in ('-u', '--user'):
            user = arg
        elif opt in ('-p', '--password'):
            password = arg
        elif opt in ('-c', '--cellphone'):
            cellphone = arg
        elif opt in ('-e', '--email'):
            email = arg
        elif opt in ('--userid'):
            userid = arg
        elif opt in ('--classstring'):
            classstring = arg
        elif opt in ('--sectionfrom'):
            sectionfrom = arg
        elif opt in ('--sectionto'):
            sectionto = arg
        elif opt in ('--action'):
            action = arg
        else:
            print "wrong args"
    cnx = mysql_connect()

    if action == "createuser" :
        login_manager = LoginManager.loginManager(cnx)
        # login_manager.create_user(user, password, email, cellphone, cnx)
        print(login_manager.create_user(user, password, email, cellphone))
    elif action == "loginuser" :
        login_manager = LoginManager.loginManager(cnx)
        print(login_manager.login_user(user, password))
    elif action == "addclass" :
        discussion_manager = DiscussionManager.discussionManager(cnx)
        print(discussion_manager.add_class(userid, classstring, sectionfrom, sectionto))
    elif action == "removeclass" :
        discussion_manager = DiscussionManager.discussionManager(cnx)
        print(discussion_manager.remove_class(userid, classstring))
    elif action == "getjson" :
        discussion_manager = DiscussionManager.discussionManager(cnx)
        discussion_manager.getJSON(userid)
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
        return cnx

    
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



