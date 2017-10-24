import sys
import getopt

# total = len(sys.argv)
# cmdargs = str(sys.argv)
# print ("The total numbers of args passed to the script: %d " % total)
# print ("Args list: %s " % cmdargs)
# print ("Script name: %s" % str(sys.argv[0]))

# f = open("test.txt", "w")
# f.write("yoooo")
# f.close()


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
    
    # user = "potplus"
    # password = "1234"

    
    if action == "newuser":
        if user.find("@") > 0:
            print newuser(user, password)
        else:
            print -1 #not a email
    elif action == "loginuser":
        print loginuser(user, password)
    else:
        print "not implemented"
    
def newuser(user, password):
    ifile = open("user.txt", "a")
    ifile.write(user + "," + password + "\n")
    return "1"

def loginuser(user, password):
    with open("user.txt", "r") as f:
        userlists = f.readlines()

    print userlists
    print "\n"
    print user + "," + password + "\n"
    print 
    for l in userlists:
        if l.rstrip() == user + "," + password:
            return "1"
    return -1 #login failed


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



