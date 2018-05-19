/*G5500.cpp - Library for interfacing with the Yaesu G5500 roator
controller.  Note that no particular language support is implied,
as that is left to the user to implement.  David Patterson, 
22-Mar-2015*/

#include "G5500.h"
#include "Arduino.h"

G5500::G5500() //constructor; basically, just set up the pins, turn them off
{
  pinMode(_upPin, OUTPUT);
  pinMode(_downPin, OUTPUT);
  pinMode(_eastPin, OUTPUT);
  pinMode(_westPin, OUTPUT);
  
  digitalWrite(_upPin, HIGH);
  digitalWrite(_downPin, HIGH);
  digitalWrite(_eastPin, HIGH);
  digitalWrite(_westPin, HIGH);
}

void G5500::setAzEl (int azimuth, int elevation)
{
    G5500::setAz(azimuth); 
    G5500::setEl(elevation);    
  

}

//void G5500::Move2PosAz(int azimuth)
//{
//	int move2Az = (float(azimuth)/_azRes)+0.5+_zeroAzPoint;
//	int curAz = G5500::getAz();
//	while(move2Az != curAz) {
//		digitalWrite(_LEDPin, HIGH);
//		if(move2Az > curAz) {
//			digitalWrite(_downPin, HIGH);
//			digitalWrite(_upPin, LOW);
//			curAz = G5500::getAz();
//		} else if( move2Az < curAz ) {
//			digitalWrite(_upPin, HIGH);
//			digitalWrite(_downPin, LOW);
//			curAz = G5500::getAz();
//		} else {
//			move2Az = curAz;
//		}		
//	}
//	
//	digitalWrite(_upPin, LOW);
//	digitalWrite(_downPin, LOW);
//}

int G5500::getAzDummy(int azimuth) 
{
	return (float(azimuth)/_azRes)+0.5+_zeroAzPoint;
}

void G5500::setAz(int azimuth)
{
  int azADC = (float(azimuth)/_azRes)+0.5+_zeroAzPoint;
  if(azADC > _maxAzPoint) azADC = _maxAzPoint;
  if(azADC < _zeroAzPoint) azADC = _zeroAzPoint;
  int azInd = G5500::getAz();
  if(abs(azADC - azInd) <= _azDeadZone) return;
  while(azInd != azADC)
  {
    if(azInd < azADC) 
    {
      //digitalWrite(_upPin, LOW);
      digitalWrite(_eastPin, LOW);

    }
    else if(azInd > azADC) 
    {
      
      //digitalWrite(_downPin, LOW);
      digitalWrite(_westPin, LOW);

    }
    azInd = G5500::getAz();
  }
  //digitalWrite(_upPin, HIGH);
  //digitalWrite(_downPin, HIGH);
  digitalWrite(_eastPin, HIGH);
  digitalWrite(_westPin, HIGH);
}

void G5500::setEl(int elevation)
{
  int elADC = (float(elevation) / _elRes)+0.5+_zeroElPoint;
  if(elADC > _maxElPoint) elADC = _maxElPoint;
  if(elADC < _zeroElPoint) elADC = _zeroElPoint;
  int elInd = G5500::getEl();
  if(abs(elADC - elInd) <= _elDeadZone) return;
  while(elInd != elADC)
  {
    if(elInd < elADC)
    {   
      digitalWrite(_upPin, LOW);   
      //digitalWrite(_eastPin, LOW);


    }
    else if (elInd > elADC)
    { 
      digitalWrite(_downPin, LOW);
      //digitalWrite(_westPin, LOW);


    }
    elInd = G5500::getEl();
  }
  //digitalWrite(_eastPin, HIGH);
  //digitalWrite(_westPin, HIGH);
  digitalWrite(_upPin, HIGH);
  digitalWrite(_downPin, HIGH);
}

int G5500::getAz()
{
  return analogRead(_azSensePin);
}

int G5500::getEl()
{
  return analogRead(_elSensePin);
}

int G5500::getAzDegrees()
{
  int azInd = G5500::getAz();
  int azimuth = float(azInd - _zeroAzPoint) * _azRes;
  if (azimuth < 0) azimuth = 0;
  else if(azimuth > 450) azimuth = 450;
  return azimuth;
}

int G5500::getElDegrees()
{
  int elInd = G5500::getEl();
  int elevation = float(elInd - _zeroElPoint) * _elRes;
  if (elevation < 0) elevation = 0;
  else if(elevation > 180) elevation = 180;
  return elevation;
}
