from selenium import webdriver
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.common.exceptions import TimeoutException
import time
import os

chromium_path = "/usr/lib/chromium-browser/chromedriver"
driver = webdriver.Chrome(chromium_path)

def get_data(url):
	driver.get(url);
	links = driver.find_elements_by_xpath("//dl/dd");
	for link in links:
		print(link.text);

for i in range (ord('a'), ord('z')+1):
	get_data("https://er.jsc.nasa.gov/seh/a.html");
	break;