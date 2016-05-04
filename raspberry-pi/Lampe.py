class Lampe: # Définition de notre classe Lampe
    """Classe définissant une lampe caractérisée par :
    - son état"""
	def __init__(self): # Notre méthode constructeur
        	"""Pour l'instant, on ne va définir qu'un seul attribut"""
        	self.etat = False

	def allumerLampe(self):
		self.etat = True
	
	def eteindreLampe(self):
		self.etat = False
