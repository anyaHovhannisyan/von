import re
out_file = open("a1.txt", "w")

quer = ""
querterm = ""

with open("a.txt") as file:
	lines = file.readlines()
	for line in lines:
		pos = line.find("<A NAME=")
		if (pos != -1):
			continue
		rline = line
		pos = rline.find("<DT><STRONG>")
		if (pos != -1):
			querterm = re.escape(querterm)
			quer += querterm
			quer += "');"
			out_file.write(quer+'\n')
			quer = "INSERT INTO `Terms` (`term`, `meaning`)VALUES ('"
			querterm = ""
			rline = rline[pos+12:]
			pos = rline.find("</STRONG>")
			rline = rline[:pos]
			quer += re.escape(rline)
			quer += "','"
			pos = line.find("</STRONG>")
			line = line[pos+9:]
		line = re.sub(r'<A HREF=".*#', r'<A HREF="entry.php?s=', line)
		querterm += line[:-1]