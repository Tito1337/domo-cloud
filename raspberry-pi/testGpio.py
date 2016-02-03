import RPi.GPIO as GPIO
import time
GPIO.setmode(GPIO.BCM)
GPIO.setup(22,GPIO.OUT)
GPIO.setup(23,GPIO.IN)
input = GPIO.gpio_function(23)
porte1 = 22

if input == 0:
	GPIO.output(porte1,GPIO.HIGH)
	print("on chauffe")
else:
	GPIO.output(porte1,GPIO.LOW)
	print("on ne chauffe pas")
GPIO.cleanup()
