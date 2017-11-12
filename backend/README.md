### BruinSwitch Backend Documentation

##Introduction
The backend side of the BruinSwitch is implemented by python. User's information (including login info, selected classes and discussion sections etc.) will be stored in files. The sensitive information will be encrypted, but will be still stored in a file. 

To use the backend side features, you may call

```php
shell_exec("python switchhub.py [--arguments]");
```

in php.

Make sure your server is installed with python 2.7 and [mysql.connector](https://dev.mysql.com/downloads/connector/python/) module



### Features

#### Login

```php
echo shell_exec(python switchhub.py --user=someUsername --password=somePassword --action=loginuser)
```

the php page will print the user's id (as string) if the username and password is matched. -1 otherwise



  #### Sign Up

```php
echo shell_exec(python switchhub.py --user=someUsername --email=someEmail@email.com --password=somePassword --cellphone=123456 --action=createuser)
```

the php page will print the new user's id. It won't detect duplicate for now. To be done later. So the program will either return id or crash (or undefined behavior)



#### Add Class

```php
echo shell_exec(python switchhub.py --userid=2 --classstring="COM SCI - 33" --sectionfrom="1A" --sectionto="1B" --action=addclass)

```

the php page will print 0 if success. Trying to add classes for undefined userid will be accepted. It won't have warnings for now. To be fixed later.



#### Remove Class

```php
echo shell_exec(python switchhub.py --userid=2 --classstring="COM SCI - 33" --action="removeclass"
)
```

the php page will print 0 if success. Removing a non-existing class (i.e. didn't added by python) will crash. To be fixed later.

####Get User's Classes by JSON (getjson)

```php
echo shell_exec(python switchhub.py --userid=2 --action="getjson")
```

the php page will print a JSON string. Suppose the dis_case table looks like this:

+----+--------+---------------+----------+--------+---------+
| id 	| userid 	| classstr     | dis_from | dis_to | status  |
+----+--------+---------------+----------+--------+---------+
|  3 |      2 | COM SCI - 111 | 1C       | 1B     | pending |
|  4 |      4 | ENGR - 111      | 1C       | 1B     | pending |
|  5 |      2 | COM SCI - 33  	| 1A       | 1B     | pending |
|  6 |      2 | ENGR - 111    	| 2A       | 2B     | pending |
|  7 |      3 | MATH - 32B      | 3A       | 3C     | pending |



Then getjson for userid=2 will print

```json
{"cases":
 [
   {"status": "pending", "dis_from": "1C", "classstr": "COM SCI - 111", "dis_to": "1B"},
   {"status": "pending", "dis_from": "1A", "classstr": "COM SCI - 33", "dis_to": "1B"},
   {"status": "pending", "dis_from": "2A", "classstr": "ENGR - 111", "dis_to": "2B"}
 ]
}
```

