#!/usr/bin/python3

from ABE_ADCPi import ADCPi
from ABE_helpers import ABEHelpers
import time
import os
import RPi.GPIO as GPIO
import http.client
import json
from pprint import pprint

#-------------------Déclaration des GPIOs----------------------
GPIO.setmode(GPIO.BCM) # on appelle les GPIOs par leur nom et pas par leurs numéros

ChauffageP1 = 7
ChauffageP2 = 8 # cuisine
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
def calcul(voltage):
	return ((voltage/0.01)+2)
	
def connectionOk()	:
	hostname = "www.google.com"
	response = os.system("ping -c 1 " + hostname)
	if response ==0:
		return True
	else:
		return False
def getLocalTemp():
	file=open('text.txt','r')
	list=file.readlines()
	return int(list[0])
def gestionMaison():
	if connectionOk():
		gestionPiece(1,"upload.webtito.be")
		gestionPiece(2,"upload.webtito.be")
		gestionPiece(3,"upload.webtito.be")
	else:
		gestionLocal()
		gestionLocal()
		gestionLocal()
def gestionLocal(piece):
	if piece == 1:
		if (getLocalTemp()>calcul(adc.read_voltage(1))):
			print("je chauffe la pièce 1")
			AllumerChauffage(1)
		else:
			EteindreChauffage(1)
	elif piece == 2:
		if (getLocalTemp()>calcul(adc.read_voltage(2))):
			AllumerChauffage(2)
		else:
			EteindreChauffage(2)
	elif piece == 3:
		if (getLocalTemp()>calcul(adc.read_voltage(3))):
			AllumerChauffage(3)
		else:
			EteindreChauffage(3)
	else:
		print("error: entrez le bon numéro de pièce")

def gestionPiece(piece,url):
	jsondata=getContent(url)
	if piece == 1:
		if (jsondata['1']>calcul(adc.read_voltage(1))):
			#print("je chauffe la pièce 1: la consigne vaut: %d \n " %jsondata['1'])
			#print("et la température vaut: %02f" %calcul(adc.read_voltage(1)))
			AllumerChauffage(1)
		else:
			#print("je coupe la pièce 1: la consigne vaut: %d \n " %jsondata['1'])
			#print("et la température vaut: %02f" %calcul(adc.read_voltage(1)))
			EteindreChauffage(1)
	elif piece == 2:
		if (jsondata['2']>calcul(adc.read_voltage(2))):
			#print("je chauffe la pièce 2")			
			AllumerChauffage(2)
		else:
			EteindreChauffage(2)		
	elif piece == 3:
		if (jsondata['3']>calcul(adc.read_voltage(3))):
			AllumerChauffage(3)
		else:
			EteindreChauffage(3)		
	else:
		print("error: entrez le bon numéro de pièce")

def getContent(link): #link="domocloud.webtito.be/rpi.json.php?client=1&temperatures=25-37-42"
	conn = http.client.HTTPConnection(link)#create a connection to the adress
	conn.request("GET", "/rpi.json")#This will send a request to the server using the HTTP request method method and the selector url
	r = conn.getresponse()
	
	while not r.closed:
		data=r.read().decode()# This will return and decode entire content.
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

def EteindreChauffage(piece):
	if piece == 1:
			NiveauBas(ChauffageP1)
			etatLampe1=False
	elif piece == 2:
			NiveauBas(ChauffageP2)
			etatLampe2=False
	elif piece == 3:
			NiveauBas(ChauffageP3)
			etatLampe3=False
	else:
		print("error: entrez le bon numéro de pièce")	

def AllumerChauffage(piece):
	if piece == 1:
		if VerifFen(piece)== False:#   les 3 fenetres sont fermees = false:
			NiveauHaut(ChauffageP1)
			etatLampe1=1
		else:
			NiveauBas(ChauffageP1)
			etatLampe1=0
	elif piece == 2:
		if VerifFen(piece)== False:       #   la  fenetre est fermee = false
			NiveauHaut(ChauffageP2)
			etatLampe2=1
		else:
			NiveauBas(ChauffageP2)
			etatLampe2=0
	elif piece == 3:
		if VerifFen(piece)== False:
			NiveauHaut(ChauffageP3)
			etatLampe3=1
		else:
			NiveauBas(ChauffageP3)
			etatLampe3=0
	else:
		print("error: entrez le bon numéro de pièce")

def VerifFen(piece):
	if piece == 1:
                if (FenAvD or FenAvG or PorteEntre) == True:#   les 3 fenetres sont fermees = false
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

#------------------programme----------------------------------
i2c_helper = ABEHelpers()
bus = i2c_helper.get_smbus()
adc = ADCPi(bus, 0x6c, 0x6d, 12)
adc.set_conversion_mode(1)
adc.set_pga(1)
				

while (True):
	FenAvD = GPIO.input(4) #on assigne un nom  à la valeur du GPIO
	FenAvG = GPIO.input(17)
	FenArD = GPIO.input(27)
	FenArG = GPIO.input(22)
	PorteEntre = GPIO.input(23)
	PorteIntG = GPIO.input(24)
	PorteIntD = GPIO.input(25)
	
	os.system('clear')	
	
	print ("Channel 1: %02f" %calcul( adc.read_voltage(1)))
	print ("Channel 1: %02f" %calcul( adc.read_voltage(2)))
	print ("Channel 1: %02f" %calcul( adc.read_voltage(3)))	
	print("etat de la lampe2 :%d" %etatLampe2)
	print("etat lampe1 :%d" %etatLampe1)
	print("etat lampe3 :%d" %etatLampe3)
	print("porte entree : %d" %PorteEntre)
	print("porte int gauche : %d" %PorteIntG)
	print("porte int droit : %d" %PorteIntD)
	print("Fenetre avant droit : %d" %FenAvD)
	print("Fenetre avant gauche : %d" %FenAvG)
	print("état de la lampe de la pièce 1 : %d" %etatLampe1)
	gestionMaison()
	#AllumerChauffage(1)
	time.sleep(1)
