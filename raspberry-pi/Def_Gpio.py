#!/usr/bin/python3

from ABE_ADCPi import ADCPi
from ABE_helpers import ABEHelpers
import time
import os
import RPi.GPIO as GPIO


def calcul(voltage):
	return ((voltage/0.01)+2)

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


DefautConsigne = 25 #consigne par defaut

#-------------------Test de l'ADC------------------------------

compteur = 0
i2c_helper = ABEHelpers()
bus = i2c_helper.get_smbus()
adc = ADCPi(bus, 0x6c, 0x6d, 12)
adc.set_conversion_mode(1)
adc.set_pga(1)
while (True):
	os.system('clear')
	# read from adc channels and print to screen
	print ("Channel 1: %02f" % adc.read_voltage(1))
	#print ("Channel 2: %02f" % adc.read_voltage(2))
	#print ("Channel 3: %02f" % adc.read_voltage(3))
	#print ("Channel 4: %02f" % adc.read_voltage(4))
	
	if DefautConsigne < calcul(adc.read_voltage(1)):
		print("il fait trop chaud il fait : %f" % calcul(adc.read_voltage(1)))
	else:
		print("il faut chauffer il fait : %f" % calcul(adc.read_voltage(1)))
	#wait 0.5 seconds before reading the pins
	
	#for x in range(0, 10):
		#compteur += adc.read_voltage(1)
		#print((float(compteur)/11)
	#print ("%d" %compteur)
	#compteur=0
	
	time.sleep(0.5)
	
GPIO.cleanup()
