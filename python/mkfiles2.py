import subprocess

for i in range (ord('m'), ord('z') + 1):
	subprocess.call(["python",  "dict2.py", chr(i) + "1.txt", chr(i) + chr(i) + ".txt"])
