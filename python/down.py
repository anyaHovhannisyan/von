import urllib2


for i in range (ord('b'), ord('z') + 1):
	url = "view-source:https://er.jsc.nasa.gov/seh/"+ chr(i) +".html"
	r = urllib2.urlopen(url)
	text = r.read()
	file = open(chr(i)+".txt", "w")
	file.write(text)
	file.close()