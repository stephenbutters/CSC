import urllib2
import re
print "."
urlist = []
for i in range(164, 926):
    pendingurl = "http://catalog.registrar.ucla.edu/ucla-catalog2017-" + str(i) + ".html"
    pendingpage = urllib2.urlopen(pendingurl).read()

    if pendingpage.find("hour") >= 0 and (pendingpage.find("Lower-Division Courses") >= 0 or pendingpage.find("Graduate Courses") >= 0) and pendingpage.lower().find("lecture") >= 0:
        urlist.append(pendingurl)

ofile=open("result.txt", "w")

for url in urlist:
    print "."
    response_buffer = urllib2.urlopen(url).read()
    dep_name = re.findall('<h1>(.*?)\sCourses', response_buffer, re.DOTALL)
    m = re.findall ( '<span class="coursetitle">(.*?)</span>', response_buffer, re.DOTALL)
    ofile.write("-"+dep_name[0])
    ofile.write("\n")
    for ln in m:
        if ln.find("<span class") > 0:
            continue
        ofile.write(ln)
        ofile.write("\n")