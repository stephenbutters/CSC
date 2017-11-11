import mysql.connector
from mysql.connector import errorcode
import sys

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

def add_class(classstr, classtitle, cnx):
    cursor = cnx.cursor()
    add_class = (    "INSERT INTO classtable"
                    "(classstr, classtitle)"
                    "VALUES(%s, %s)"
                )
    data_add_class = (classstr, classtitle)
    cursor.execute(add_class, data_add_class)
    cnx.commit()
    cursor.close()

def main():
    cnx = mysql_connect()
    lines = [line.rstrip('\n') for line in open('result3.txt')]
    totalLen = len(lines)

    dept = ""
    classNo = ""
    classstr = ""
    classtitle = ""
    counter = 0
    for l in lines :
        if l.find('@') >= 0 :
            dept = l[1:] #exclude "@"
        elif l.find('.') >= 0 :
            dot_place = l.find('.')
            classNo = l[:dot_place]
            classtitle = l[dot_place+1:]
            classstr = dept + " - " + classNo
            #start querying
            add_class(classstr,classtitle, cnx)
            # print ( str(dept) + "," + str(classNo) + "," + str(classTitle))

            counter = counter + 1
            if counter % 100 == 0:
                print(str((1.0*counter)/totalLen*100) + " %" + " finished")
    cnx.close()


if __name__ == "__main__":
    main()