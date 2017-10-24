# User's Documentation of Sniffer_dog.py



Sniffer_dog.py is a development tool written in Python. You can use this to get a complete course listing that is offered in UCLA. 

To get started, your server should have Python installed, and make sure that you have stable Internet connection.

Then, change the directory to this, and

``` shell
> python dog.py
```

The waiting time can be long. The Sniffer_dog is now downloading and parsing webpage contents from the UCLA registar websites.

Then, you can use everything from result.txt. Enjoy!

---

## How to use result.txt

A typical result.txt made by Sniffer_dog.py looks like

```
(... Other Departments and their classes in UCLA)
----------------------------------------------
Computer Science

1. Freshman Computer Science Seminar. (1)

31. Introduction to Computer Science I. (4)

32. Introduction to Computer Science II. (4)

33. Introduction to Computer Organization. (5)

35L. Software Construction Laboratory. (2)

M51A. Logic Design of Digital Systems. (4)

97. Variable Topics in Computer Science. (1 to 4)

111. Operating Systems Principles. (5)

112. Modeling Uncertainty in Information Systems. (4)

... (more classes offered by Computer Science Dept.)
```

The result.txt starts with several dashes (-), to be concise, 46.

then, it follows a new-line character (\n)

then there will be the Department name, follows two \n s

the next line is \[Class Index\]\[dot\]\[Space\]\[The name of class\]\[dot\]\[Space\]\(Units\)

for example,

174A. Introduction to Computer Graphics. (4)

