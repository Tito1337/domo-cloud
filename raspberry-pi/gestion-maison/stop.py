#!/usr/bin/python3
from ABE_ADCPi import ADCPi
from ABE_helpers import ABEHelpers
import time
import os
import RPi.GPIO as GPIO
import http.client
import json
from pprint import pprint
GPIO.setmode(GPIO.BCM) # on appelle les GPIOs par leur nom et pas par leurs numéros

ChauffageP1 = 7
ChauffageP2 = 8 # cuisine
ChauffageP3 = 9
LumExt = 11

#-----------------déclaration de létat des lampe---------------

GPIO.setwarnings(False)
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
def NiveauBas(gpio):
	GPIO.output(gpio,GPIO.LOW)	

def EteindreChauffage():
	NiveauBas(ChauffageP1)
	NiveauBas(ChauffageP2)
	NiveauBas(LumExt)
	NiveauBas(ChauffageP3)
#------------------programme---------------------------------

EteindreChauffage() 	
print ("toutes les lampes sont éteintes")
