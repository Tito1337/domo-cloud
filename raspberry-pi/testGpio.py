import RPi.GPIO as GPIO
import time

GPIO.setmode(GPIO.BCM) # on appelle les GPIOs par leur nom et pas par leurs numéros
GPIO.setup(22,GPIO.OUT) #le GPIO 22 est déclaré comme output
GPIO.setup(23,GPIO.IN) #le GPIO 23 est déclaré comme input
input = GPIO.gpio_function(23) #on assigne input à la valeur du GPIO 23
porte1 = 22 #la porte1 est connecté au GPIO 22

if input == 0:
	GPIO.output(porte1,GPIO.HIGH) # mise à 1 de l'output
	print("on chauffe")
else:
	GPIO.output(porte1,GPIO.LOW) # mise à 0 de l'output
	print("on ne chauffe pas")
GPIO.cleanup()
