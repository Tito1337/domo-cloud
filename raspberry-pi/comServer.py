import http.client
import json
from pprint import pprint

def getContent(link): #link="domocloud.webtito.be/rpi.json.php?client=1&temperatures=25-37-42"
	conn = http.client.HTTPConnection(link)#create a connection to the adress
	conn.request("GET", "/rpi.json.php?client=1")#This will send a request to the server using the HTTP request method method and the selector url
	r1 = conn.getresponse()
	#print(r1.status, r1.reason,type(r1))
	data1 = r1.read()  # This will return entire content.
	# The following example demonstrates reading data in chunks.
	conn.request("GET", "/rpi.json.php?client=1")
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
		print("pièce1: %d \npièce2: %d \npièce3: %d \n type : %s"%(temp1, temp2, temp3,type(jsondata)))
		return jsondata
	conn.close()
#link="upload.webtito.be"	
link="domocloud.webtito.be"
getContent(link)
