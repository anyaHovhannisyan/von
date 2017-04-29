import re
import sys

out_file = open(sys.argv[1], "w") #c1.txt

quer = ""
querterm = ""

with open(sys.argv[2]) as file: #cc.txt
	lines = file.readlines()
	for line in lines:
		print(line)
		pos = line.find("<A NAME=")
		if (pos != -1):
			continue
		rline = line
		pos = rline.find("<DT><B>")
		if (pos != -1):
			querterm = re.escape(querterm)
			quer += querterm
			quer += "');"
			out_file.write(quer+'\n')
			quer = "INSERT INTO `Terms` (`term`, `meaning`)VALUES ('"
			querterm = ""
			rline = rline[pos+12:]
			pos = rline.find("</B>")
			rline = rline[:pos]
			quer += re.escape(rline)
			quer += "','"
			pos = line.find("</B>")
			line = line[pos+9:]
		line = re.sub(r'<A.*href=".*#', r'<A HREF="entry.php?s=', line)
		querterm += line[:-1]
