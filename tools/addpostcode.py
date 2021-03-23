#!/usr/bin/env python
# — coding: utf-8 —

import mysql.connector
import csv

mydb = mysql.connector.connect(
  host="localhost",
  user="root",
  password="password",
  database="tami_hoodyshop_db",
  auth_plugin='mysql_native_password'
)

mycursor = mydb.cursor()

mycursor.execute("SELECT * FROM postcode_addr")

myresult = mycursor.fetchall()

print(len(myresult))
idcount = len(myresult)+1


with open('tools\datasource\zipcode.csv', 'r', encoding='utf8') as file:
    reader = csv.reader(file)
    for row in reader:
        sql = "INSERT INTO postcode_addr (p_adrr_ID, p_adrr_subdistrict, p_adrr_District, p_adrr_Province, p_adrr_Postcode) VALUES (%s, %s, %s, %s, %s)"
        #print(row[2])
        val = (idcount, row[2], row[1], row[0], row[3])
        mycursor.execute(sql, val)
        mydb.commit()
        idcount+=1
        #print(row)
        