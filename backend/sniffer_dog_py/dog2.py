import mysql.connector
from mysql.connector import errorcode

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

def add_class(dept, classNo, classTitle, cnx):
    cursor = cnx.cursor()
    add_class = (    "INSERT INTO classes"
                    "(dept, classNo, classTitle)"
                    "VALUES(%s, %s, %s)"
                )
    data_add_class = (dept, classNo, classTitle)
    cursor.execute(add_class, data_add_class)
    cnx.commit()
    cursor.close()

def main():
    cnx = mysql_connect()
    lines = [line.rstrip('\n') for line in open('result3.txt')]

    dept = ""
    classNo = ""
    classTitle = ""
    for l in lines :
        if l.find('@') >= 0 :
            dept = l[1:] #exclude "@"
        elif l.find('.') >= 0 :
            dot_place = l.find('.')
            classNo = l[:dot_place]
            classTitle = l[dot_place+1:]
            #start querying
            add_class(dept, classNo, classTitle, cnx)
            # print ( str(dept) + "," + str(classNo) + "," + str(classTitle))
    cnx.close()


if __name__ == "__main__":
    main()