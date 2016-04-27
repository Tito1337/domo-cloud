#!/usr/bin/python3

import time
import os
import RPi.GPIO as GPIO
import http.client
import json
from pprint import pprint

#-------------------Déclaration des GPIOs----------------------
GPIO.setmode(GPIO.BCM) # on appelle les GPIOs par leur nom et pas par leurs numéros

ChauffageP1 = 7
ChauffageP2 = 8
ChauffageP3 = 9
LumExt = 10

#-----------------déclaration de létat des lampe---------------
etatLampe1 = False
etatLampe2 = False
etatLampe3 = False

GPIO.setup(ChauffageP1,GPIO.OUT) #le chauffage de la pièce 1 est déclaré comme output 
GPIO.setup(ChauffageP2,GPIO.OUT) #le chauffage de la pièce 2 est déclaré comme output 
GPIO.setup(ChauffageP3,GPIO.OUT)#le chauffage de la pièce 3 est déclaré comme output 
GPIO.setup(LumExt,GPIO.OUT)#la lumière extérieure est déclaré comme output

GPIO.setup(4,GPIO.IN)#déclaration des fenêtres et portes comme input 
GPIO.setup(17,GPIO.IN) 
GPIO.setup(27,GPIO.IN) 
GPIO.setup(22,GPIO.IN) 
GPIO.setup(23,GPIO.IN) 
GPIO.setup(24,GPIO.IN) 
GPIO.setup(25,GPIO.IN)

FenAvD = GPIO.input(4) #on assigne un nom à la valeur du GPIO 
FenAvG = GPIO.input(17) 
FenArD = GPIO.input(27) 
FenArG = GPIO.input(22) 
PorteEntre = GPIO.input(23) 
PorteIntG = GPIO.input(24) 
PorteIntD = GPIO.input(25)

#-------------------Déclaration des fonction----------------------
def getContent(link): #link="upload.webtito.be"
	conn = http.client.HTTPConnection(link)#create a connection to the adress
	#conn.request("GET", "/rpi.json")#This will send a request to the server using the HTTP request method method and the selector url
	#r1 = conn.getresponse()
	#print(r1.status, r1.reason,type(r1))
	#data1 = r1.read()  # This will return entire content.
	# The following example demonstrates reading data in chunks.
	conn.request("GET", "/rpi.json")
	r = conn.getresponse()
	
	while not r.closed:
#		print(r.read(200)) # 200 bytes
		data=r.read().decode()
		if data == b'':
			break
		#print('Content', data)
		jsondata = json.loads(data)
		#pprint(jsondata)
		temp1=jsondata['1']
		temp2=jsondata['2']
		temp3=jsondata['3']
		#print("pièce1: %d \npièce2: %d \npièce3: %d \n type : %s"%(temp1, temp2, temp3,type(jsondata)))
		return jsondata
	conn.close()
def NiveauHaut(gpio):
	GPIO.output(gpio,GPIO.HIGH)

def NiveauBas(gpio):
	GPIO.output(gpio,GPIO.LOW)	

def AllumerChauffage(piece):
	if piece == 1:
		if VerifFen(piece)== False:
			NiveauHaut(ChauffageP1)
			etatLampe1=True
		else:
			NiveauBas(ChauffageP1)
			etatLampe1=False
	elif piece == 2:
		if VerifFen(piece)== False:
			NiveauHaut(ChauffageP2)
			etatLampe2=True
		else:
			NiveauBas(ChauffageP2)
			etatLampe2=False
	elif piece == 3:
		if VerifFen(piece)== False:
			NiveauHaut(ChauffageP3)
			etatLampe3=True
		else:
			NiveauBas(ChauffageP3)
			etatLampe3=False
	else:
		print("error: entrez le bon numéro de pièce")

def VerifFen(piece):
	if piece == 1:
                if (FenAvD or FenAvG or PorteEntre) == True:
                        return True
                else:
                        return False
	elif piece == 2:
                if (FenArD) == True:
                        return True
                else:
                        return False
	elif piece == 3:
                if (FenArG) == True:
                        return True
                else:
                        return False
	else:
                print("error: entrez le bon numéro de pièce")

while (True):
	FenAvD = GPIO.input(4) #on assigne un nom  à la valeur du GPIO
	FenAvG = GPIO.input(17)
	FenArD = GPIO.input(27)
	FenArG = GPIO.input(22)
	PorteEntre = GPIO.input(23)
	PorteIntG = GPIO.input(24)
	PorteIntD = GPIO.input(25)
	
	os.system('clear')	
	
	jsondata=getContent("upload.webtito.be")
		
	AllumerChauffage(4)
	AllumerChauffage(2)
	AllumerChauffage(3)
	AllumerChauffage(1)	
	print("etat de la lampe :%d" %etatLampe2)	
	print("porte entree : %d" %PorteEntre)
	print("porte int gauche : %d" %PorteIntG)
	print("porte int droit : %d" %PorteIntD)
	print("Fenetre avant droit : %d" %FenAvD)
	print("Fenetre avant gauche : %d" %FenAvG)
	print("état de la lampe de la pièce 1 : %d" %etatLampe1)
