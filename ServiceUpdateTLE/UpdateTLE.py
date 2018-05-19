#!/usr/bin/python
# -*- coding: utf-8 -*-
import urllib
import pymongo
from pymongo import MongoClient
import os
import functools
import sys
import json
import math
import cmath
import re
import bson
import string
import simplejson
import time
import subprocess
import urllib.request
import ast
from subprocess import Popen, PIPE
from subprocess import STDOUT
from bson.json_util import dumps
from bson import json_util
import threading
from threading import Thread

platform = [
			['NOAA-15','NOAA 15'],
			['NOAA-18','NOAA 18'],
			['NOAA-20','NOAA 20'],
			['MSG-1','MSG-1'],
            ['KALPANA-1','KALPANA-1'],
            ['MSG-2','MSG-2'],
            ['HIMAWARI-7','HIMAWARI-7'],
	]
my_list = []

def updateTLE():
    #--------------------------------------------------------
    # connect DB and get collection
    #--------------------------------------------------------
    client = MongoClient('localhost', 27017)
    db = client['SatelliteDB']
    collection = db['TLE']

    
    # cursor = collection.find({})
    cursor = collection.find({},{'_id': False})
    
    for document in cursor:
        str1 = dumps(document)#NOAA-15
        check=0
        # print(str1)
        # print("-------------------------------------------------------")
        # print()
        for satellite in platform :
            if satellite[0] in str1:  
               check=1
            
        if check== 0 and str1 not in my_list: #check TLE create manual
            my_list.append(str1) #
        # print(my_list)
    

   

    #--------------------------------------------------------
    # remove Document in Databases
    #--------------------------------------------------------
    doc = collection.find({})
    # print(doc)
    for documentremove in doc :
        collection.remove(documentremove);
    #--------------------------------------------------------
   


    #--------------------------------------------------------
    # create file TLEupdate.json
    #--------------------------------------------------------
    file = open("TLEupdate.json","w") 

    for tle in my_list:
        # result = ast.literal_eval(tle)
        # assert type(result) is dict
        # print (result)
        # collection.insert(a)
        file.write(tle)
        file.write('\n')
    # print(my_list)


    #--------------------------------------------------------




    #--------------------------------------------------------
    # update TLE using Web https://www.celestrak.com/NORAD/elements/weather.txt
    #--------------------------------------------------------
    webpage = urllib.request.urlopen("https://www.celestrak.com/NORAD/elements/weather.txt").readlines()
    webpage = [x.strip() for x in webpage]
    i = 0
    lenWeb=len(webpage)
    # print (lenWeb)
    while(i<lenWeb):
        for satellite in platform :
            line=webpage[i].decode('utf8')
            if satellite[1] in line:

                file.write("{")
                file.write("\"name\":\"%s\"," % (satellite[0]))
                file.write("\"line1\":\"%s\","% (webpage[i+1].decode('utf8')) )
                file.write("\"line2\":\"%s\","% (webpage[i+2].decode('utf8')) )
                millis = int(round(time.time() * 1000))
                file.write("\"updated_at\": {\"$date\": %d},"%millis)
                file.write("\"created_at\": {\"$date\": %d}"%millis)
                file.write("}")
                file.write("\n")
        i+=3
    
    
    # proc = subprocess.Popen(["python"], shell=True)
    # proc.terminate() # <-- terminate the process

    # f = open('TLEupdate.json', 'r')
    # print(f.read())
    # jsonData =  simplejson.loads(f.read())
    # print(jsonData)
    
def importTomongoDB():
    cmd="mongoimport --db SatelliteDB --collection TLE --file TLEupdate.json"
    pro = subprocess.Popen(cmd, stdout=subprocess.PIPE, 
                        shell=True)
   
    #pro.kill()
    #p = subprocess.Popen(["start", "cmd", "/k", "mongoimport --db SatelliteDB --collection TLE --file TLEupdate.json"], stdout=PIPE, stderr=STDOUT,shell = True)
    #time.sleep(2.0)
    #p.kill()


if __name__ == '__main__':
    updateTLE()
   ## t = threading.Thread(target=updateTLE())
    #t.start()
    #while t.isAlive():
    #    pass
    #time.sleep(3)
    #t = threading.Thread(target=importTomongoDB())
    #t.start()
    #time.sleep(3)
    importTomongoDB()
# read_from_url("https://www.celestrak.com/NORAD/elements/weather.txt")
# LoadTLE()
# def bashfile()