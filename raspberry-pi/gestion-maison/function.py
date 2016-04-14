#!/usr/bin/python3

import time
import os
import RPi.GPIO as GPIO

#-------------------Déclaration des GPIOs----------------------

GPIO.setmode(GPIO.BCM) # on appelle les GPIOs par leur nom et pas par leurs numéros

ChauffageP1 = 7
ChauffageP2 = 8
ChauffageP3 = 9
LumExt = 10

GPIO.setup(ChauffageP1,GPIO.OUT) #le chauffage de la pièce 1  est déclaré comme output
GPIO.setup(ChauffageP2,GPIO.OUT) #le chauffage de la pièce 2  est déclaré comme output
GPIO.setup(ChauffageP3,GPIO.OUT)#le chauffage de la pièce 3  est déclaré comme output
GPIO.setup(LumExt,GPIO.OUT)#la lumière extérieure est déclaré comme output

GPIO.setup(4,GPIO.IN)#déclaration des fenêtres et portes comme input
GPIO.setup(17,GPIO.IN)
GPIO.setup(27,GPIO.IN)
GPIO.setup(22,GPIO.IN)
GPIO.setup(23,GPIO.IN)
GPIO.setup(24,GPIO.IN)
GPIO.setup(25,GPIO.IN)

FenAvD = GPIO.gpio_function(4) #on assigne un nom  à la valeur du GPIO 
FenAvG = GPIO.gpio_function(17)
FenArD = GPIO.gpio_function(27)
FenArG = GPIO.gpio_function(22)
PorteEntre = GPIO.gpio_function(23)
PorteIntG = GPIO.gpio_function(24)
PorteIntD = GPIO.gpio_function(25)

#-------------------Déclaration des fonction----------------------

def NiveauHaut(gpio):
	GPIO.output(gpio,GPIO.HIGH)

def NiveauBas(gpio):
	GPIO.output(gpio,GPIO.LOW)	

def AllumerChauffage(piece):
	if piece == 1:
		if VerifFen(piece)== True:
			NiveauHaut(ChauffageP1)
		else:
			NiveauBas(ChauffageP1)
	elif piece == 2:
		if VerifFen(piece)== True:
                        NiveauHaut(ChauffageP2)
		else:
                        NiveauBas(ChauffageP2)
	elif piece == 3:
                if VerifFen(piece)== True:
                        NiveauHaut(ChauffageP3)
                else:
                        NiveauBas(ChauffageP3)
	else:
		print("error: entrez le bon numéro de pièce")

def VerifFen(piece):
	if piece == 1:
                if (FenAvD or FenAvG or PorteEntre) == True:
                        return False
                else:
                        return True
	elif piece == 2:
                if (FenArD) == True:
                        return False
                else:
                        return True
	elif piece == 3:
                if (FenArG) == True:
                        return False
                else:
                        return True
	else:
                print("error: entrez le bon numéro de pièce")

while (True):
	FenAvD = GPIO.gpio_function(4) #on assigne un nom  à la valeur du GPIO
	FenAvG = GPIO.gpio_function(17)
	FenArD = GPIO.gpio_function(27)
	FenArG = GPIO.gpio_function(22)
	PorteEntre = GPIO.gpio_function(23)
	PorteIntG = GPIO.gpio_function(24)
	PorteIntD = GPIO.gpio_function(25)
	
	os.system('clear')	

	AllumerChauffage(1)	
	print("état de la lampe: %d" %GPIO.gpio_function(7))	
	time.sleep(1)
