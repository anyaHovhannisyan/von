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
	links = driver.find_elements_by_xpath("//div/h3/a");
	for link in links:
		driver.get(link.get_attribute("href"));
		mean = WebDriverWait(driver, 10).until(
                EC.presence_of_element_located(
                    (By.XPATH, "//div[@class='article-body']//p[1]"))
        )
		mean = driver.find_element_by_xpath("//div[@class='article-body']//p[1]");
		print(mean.text);

for i in range (ord('A'), ord('Z')+1):
	get_data("https://www.nasa.gov/audience/forstudents/k-4/dictionary/"+chr(i)+"/index.html");