import subprocess

for i in range (ord('m'), ord('z') + 1):
	subprocess.call(["python",  "1.py", chr(i) + chr(i) + ".txt", chr(i) + ".txt"])
