class LoginManager:
    def login_user(email, passwd, cnx):
        cursor = cnx.cursor(buffered=True)
        query = (
            "SELECT id FROM users WHERE email = %s AND hashed_passwd = %s"
        )
        cursor.execute(query, (email, passwd))
        cnx.commit()
        for (id) in cursor:
            print("{}".format(id))
        cursor.close()

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