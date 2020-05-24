from google.appengine.ext import vendor
vendor.add('lib')

import os
import urllib
import json
import jinja2
import webapp2
import urllib2
import sendgrid

from google.appengine.api import users
from google.appengine.ext import ndb
from sendgrid.helpers.mail import *

# from SendGrid's Python Library
# https://github.com/sendgrid/sendgrid-python
#from sendgrid import SendGridAPIClient
#from sendgrid.helpers.mail import Mail

JINJA_ENVIRONMENT = jinja2.Environment(
    loader=jinja2.FileSystemLoader(os.path.dirname(__file__)),
    extensions=['jinja2.ext.autoescape'],
    autoescape=True
)

#Main class for the homepage
class Main(webapp2.RequestHandler):
    #Create entity key from :https://cloud.google.com/appengine/docs/standard/python/ndb/creating-entity-keys
    def get(self):
        greeting = 'Welcome to our Weather Forecasting Website'

        greeting_content = {
            'greeting': greeting,
        }

        #Get template from home page and write greeting message 
        template = JINJA_ENVIRONMENT.get_template('index.php')
        self.response.write(template.render(greeting_content))

#Weather class for the weather forecast page
class Weather(webapp2.RequestHandler):
    def get(self):

        template = JINJA_ENVIRONMENT.get_template('weather.php')
        self.response.write(template.render())

        
#Location class that reveals the results from the weather and geocode APIs
class Location(webapp2.RequestHandler):
    #Post the results based on user's search entry
    def post(self):
        #get address from user's search entry and store in location variable
        location = self.request.get('location')

        #parameters dictionary include API key and address from search entry
        geocoding_parameters = {
            'key': 'AIzaSyCrF4_wcTMhC3HjBEeQcqf7WFcNuiApu2E',
            'address': location
        }

        #Create new variable that encodes the JSON link with given parameters
        geocode_URL = 'https://maps.googleapis.com/maps/api/geocode/json?' + urllib.urlencode(geocoding_parameters)

        final_geocoding_URL = urllib2.urlopen(geocode_URL)

        geocode_result = final_geocoding_URL.read()

        geocode_data = json.loads(geocode_result)

        #Create dictionary to store values of weather data
        data = dict()
        data['lat'] = geocode_data['results'][0]['geometry']['location']['lat']
        data['lon'] = geocode_data['results'][0]['geometry']['location']['lng']
        data['address'] = geocode_data['results'][0]['formatted_address']

        #Dictionary to later encode the key-value pairs into forecast page
        url_dict = {
            'lon': data['lon'],
            'lat': data['lat'],
            'addr': data['address']
        }

        self.redirect('forecast.php?' + urllib.urlencode(url_dict))
        

#Forecast class that retrieves the results of the geocode and shows on forecast
class Forecast(webapp2.RequestHandler):
    #get value from url_dict
    def get(self):
        lon = self.request.get('lon')
        lat =  self.request.get('lat')
        address = self.request.get('addr')

        openweather_parameters = {
            'lon': lon,
            'lat': lat,
            'unit': 'metric',
            'apikey': 'e0876fce8dc2af3de88c21a2c3a654d3',
        }

        openweather_url = 'https://api.openweathermap.org/data/2.5/weather?' + urllib.urlencode(openweather_parameters)

        final_openweather_url = urllib2.urlopen(openweather_url)

        #Read the results provided from previous variable
        openweather_result = final_openweather_url.read()

        openweather_data = json.loads(openweather_result)

        #Increment from 0 to show data
        openweatherdata = dict()
        #x = 0
        
        openweatherdata['temp'] = openweather_data['main']['temp']
        openweatherdata['temp_min'] = openweather_data['main']['temp_min']
        openweatherdata['temp_max'] = openweather_data['main']['temp_max']
        openweatherdata['pressure'] = openweather_data['main']['pressure']
        openweatherdata['humidity'] = openweather_data['main']['humidity']
        openweatherdata['speed'] = openweather_data['wind']['speed']
        openweatherdata['visibility'] = openweather_data['visibility']
        openweatherdata['sunrise'] = openweather_data['sys']['sunrise']
        openweatherdata['sunset'] = openweather_data['sys']['sunset']


        #parameters for the Open Weather Map API
        #parameters received from: https://openweathermap.org/current

        #while x < 8:    
            #openweatherdata[x] = {
                #'main_weath': openweather_data[x]['weather'][0]['main']['value'],
                #'main_desc': openweather_data[x]['weather'][0]['description']['value'],
                #'icon': openweather_data[x]['weather'][0]['icon']['value'],
                #'temp': openweather_data[x]['main']['temp']['value'],
                #'humidity': openweather_data[x]['main']['humidity']['value'],
                #'temp_min': openweather_data[x]['main']['temp_min']['value'],
                #'temp_max': openweather_data[x]['main']['temp_max']['value'],
                #'speed': openweather_data[x]['wind']['speed']['value'],
                #'degree': openweather_data[x]['wind']['degree']['value'],
                #'sunrise': openweather_data[x]['sys']['sunrise']['value'],
                #'sunset': openweather_data[x]['sys']['sunset']['value']
            #}

            #x += 1

        params = {
                'address': address,
                'temp': openweatherdata['temp'],
                'temp_min': openweatherdata['temp_min'],
                'temp_max': openweatherdata['temp_max'],
                'pressure': openweatherdata['pressure'],
                'humidity': openweatherdata['humidity'],
                'speed': openweatherdata['speed'],
                'visibility': openweatherdata['visibility'],
                'sunrise': openweatherdata['sunrise'],
                'sunset': openweatherdata['sunset']

                #'main_weath1': openweather_data[1]['main_weath'],
                #'main_desc1': openweather_data[1]['main_desc'],
                #'icon1': openweather_data[1]['icon']
        }

        search_template = JINJA_ENVIRONMENT.get_template('forecast.php')
        self.response.write(search_template.render(params))

class Contact(webapp2.RequestHandler):
    def get(self):
        #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
        sg = sendgrid.SendGridAPIClient(api_key='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')
        from_email = Email("fisherlim20@gmail.com")
        to_email = To("jasontheodore9@gmail.com")
        subject = "Sending with SendGrid is Fun"
        content = Content("text/plain", "and easy to do anywhere, even with Python")
        mail = Mail(from_email, to_email, subject, content)
        response = sg.client.mail.send.post(request_body=mail.get())
        
        search_template = JINJA_ENVIRONMENT.get_template('contact.php')
        self.response.write(search_template.render())
    
    #message = Mail(
        #from_email='jasontheodore9@gmail.com',
        #to_emails='toemail',
        #subject='subject',
        #html_content='message')
    #try:
        #sg = SendGridAPIClient(os.environ.get('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'))
        #response = sg.send(message)
        #print(response.status_code)
        #print(response.body)
        #print(response.headers)
    #except Exception as e:
        #print(e.message)



app = webapp2.WSGIApplication([
    ('/', Main),
    ('/index.php', Main),
    ('/weather.php', Weather),
    ('/location', Location),
    ('/forecast.php', Forecast),
    ('/air.php', Air),
    ('/contact.php', Contact),
])
