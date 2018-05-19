/*G5500.h - Library for interfacing with the Yaesu G5500 roator
  controller.  Note that no particular language support is implied,
  as that is left to the user to implement.*/
#ifndef G5500_h
#define G5500_h

#include "Arduino.h"

class G5500
{
  public:
    G5500();
    void setAzEl (int azimuth, int elevation);
    void setAz (int azimuth);
    void setEl (int elevation);
    int getAz ();
    int getEl ();
    int getAzDegrees ();
    int getElDegrees ();
    int getAzDummy (int azimuth);
    void Move2PosAz (int azimuth);

  private:
    int _upPin = 7;
    int _downPin = 6;
    int _eastPin = 4;
    int _westPin = 5;
    int _azSensePin = A1;
    int _elSensePin = A0;
    //All of the following are determined experimentally
    const int _zeroAzPoint  = 7;
    const int _maxAzPoint   = 1023;
    const int _zeroElPoint = 0;
    const int _maxElPoint = 1020;
    const float _elRes    = 0.17665;
    const float _azRes    = 0.4228;
    //Set for ~2 deg dead zones to avoid chattering the motors
    const int _azDeadZone = 2;
    const int _elDeadZone = 10;
};

#endif
