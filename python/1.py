import re
import sys
out_file = open(sys.argv[1], "w") #cc.txt

with open(sys.argv[2]) as file: #c.txt
	lines = file.readlines()
	for line in lines:
		pos = re.search(r'<A [^a-z,A-Z]',line)
		if (pos != None):
			out_file.write(line[:-2])
		else:
			pass
			out_file.write(line)
