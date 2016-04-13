import http.client
import json

def getContent(link):
	conn = http.client.HTTPConnection(link)#create a connection to the adress
	conn.request("GET", "/rpi.json")#This will send a request to the server using the HTTP request method method and the selector url
	r1 = conn.getresponse()
	print(r1.status, r1.reason)
	data1 = r1.read()  # This will return entire content.
	# The following example demonstrates reading data in chunks.
	conn.request("GET", "/rpi.json")
	r = conn.getresponse()
	
	while not r.closed:
		print(r.read(200)) # 200 bytes
#		jsondata = json.loads(data1)
#		print(jsondata)
	conn.close()

link="upload.webtito.be"
getContent(link)
