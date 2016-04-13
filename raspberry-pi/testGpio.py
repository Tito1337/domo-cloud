#!/usr/bin/python3

from ABE_ADCPi import ADCPi
from ABE_helpers import ABEHelpers
import time
import os
import RPi.GPIO as GPIO


def calcul(voltage):
	return ((voltage/0.01)+2)


#GPIO.setmode(GPIO.BCM) # on appelle les GPIOs par leur nom et pas par leurs numéros
#GPIO.setup(22,GPIO.OUT) #le GPIO 22 est déclaré comme output
#GPIO.setup(23,GPIO.IN) #le GPIO 23 est déclaré comme input
#input = GPIO.gpio_function(23) #on assigne input à la valeur du GPIO 23
#porte1 = 22 #la porte1 est connecté au GPIO 22
DefautConsigne = 25 #consigne par defaut
  
compteur = 0
i2c_helper = ABEHelpers()
bus = i2c_helper.get_smbus()
adc = ADCPi(bus, 0x6b, 0x6d, 12)
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
