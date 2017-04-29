import re
out_file = open("lll.txt", "w")

with open("l.txt") as file:
	lines = file.readlines()
	for line in lines:
		line=re.sub(r'<DT><STRONG>(.*)</STRONG>', r'\n<DT><STRONG>\1</STRONG>\n', line)
		out_file.write(line)