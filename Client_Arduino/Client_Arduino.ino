#include <Ethernet.h>
#include <SPI.h>
#include "G5500.h"
//SOCKET s;
G5500 rotor = G5500();
byte mac[] = { 0xBE, 0xAD, 0xBE, 0xEF, 0xFE, 0xED };
byte ip[] = { 158,108,122,20};
byte server[] = { 158,108,122,17}; 
int tcp_port = 9090;
EthernetClient client;

void setup()
{
  Ethernet.begin(mac, ip);
  
  Serial.begin(9600);

  //delay(1000);

  Serial.println("Connecting...");

  if (client.connect(server, tcp_port)) { // Connection to server.js
    Serial.println("Connected to server.js");
    client.println();
  } else {
    Serial.println("connection failed");
  }
}

void loop()
{
  if (client.available()) {
    //if(Serial.available()){
      int Az = rotor.getAzDegrees();
      int El = rotor.getElDegrees();
      
      String AZ = String(Az);
      String EL = String(El);
      String AZEL = "AZ="+AZ+","+"EL="+EL;
      int i=0;
      //char buf[10] ;
      String c = client.readString();
      char s[AZEL.length()];
      Serial.println(c); // Print on serial monitor the data from server 
      int j=0;
      String az_str="";
      String el_str="";
      while(j<c.length()){
        char c1 = c[j];
        char c2 = c[j+1];
        char c3 = c[j+2];
        if(c1== 'A'){
          if(c2== 'Z'){
            if(c3== '='){
              int ii=j+2;
              while(true){
                if(c[ii+1]==','){
                  j=ii;
                  break;
                }
                ii=ii+1;
                az_str = az_str + c[ii];
              }
            }
          }
        }
        if(c1 == 'E'){
          if(c2 == 'L'){
            if(c3 == '='){
              int ii=j+2;
              while(true){
                if(ii==c.length()){
                  j=ii;
                  break;
                }
                ii=ii+1;
                el_str = el_str + c[ii];
              }             
            }
          }

        }
        j=j+1;
      }
      int az_nt = az_str.toInt();
      int el_nt = el_str.toInt();
      Serial.print(az_nt);
      Serial.print(" ");
      Serial.println(el_nt);
      for(i=0;i<AZEL.length()+2;i++){
        s[i] = AZEL[i]; 
 
      }
      
      rotor.setAzEl(az_nt,el_nt);
      client.write(s);

//      Serial.print(Az);
//      Serial.println(El); 
    //}
  }

  if (!client.connected()) {
    Serial.println();
    Serial.println("disconnecting.");
    client.stop();
    for(;;)
      ;
  }
}
