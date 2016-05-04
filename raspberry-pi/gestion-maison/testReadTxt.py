#!/usr/bin/python3
import time
import os
import RPi.GPIO as GPIO
import http.client
import json
from pprint import pprint

def connectionOk():
	hostname = "google.com"
	response = os.system("ping -c 1 " + hostname)
	if response == 0:
		return True
	else:
		return False
def getLocalTemp(piece):
	file=open('text.txt','r')
	list=file.readlines()
	if piece == 1:
		print("etat de la lampe :%d" %int(list[0]))
		return list[0]
	elif piece == 2:
		print("etat de la lampe :%d" %int(list[1]))
		return list[1]
	elif piece == 3:
		print("etat de la lampe :%d" %int(list[2]))
		return list[2]

while (True):
	os.system('clear')
	if connectionOk():
		print("connected to the server")
	else:
		print("failed to connect to the server")
	getLocalTemp(1)
	time.sleep(1)
