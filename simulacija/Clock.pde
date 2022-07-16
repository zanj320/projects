class Clock{
  PVector location;
  float fps;
  float radius;
  float mins = 45;
  float hours = 6;
  String s = "";
  int tps = 5;
  boolean calledReleaseFunc = false;
  boolean calledMoveToExitFunc = false;
  boolean lessonsTime = false;
  boolean schoolTime = true;
  String danVTednu="Sre";

  Clock(PVector loc, float r, float fps){
    this.radius = r;
    this.location = loc;
    this.fps = fps;
  }
  
  void draw(){
     //Main circle
     stroke(color(0));
     fill(color(255));
     //noFill();
     circle(location.x, location.y, radius);
     noFill();
     
     strokeWeight(3);
     //Center circle
     point(location.x, location.y);
   
    float spRadius = radius * 0.47;
    //lines
    beginShape(POINTS);
    for (int a = 0; a < 360; a+=30) {
      float angle = radians(a);
      float x = location.x + cos(angle) * spRadius;
      float y = location.y + sin(angle) * spRadius;
      vertex(x, y);
    }
    endShape();
    
    if(frameCount % tps == 0){
      mins++;
      calledReleaseFunc = false; // treba na novo nastavlat na false, druagače kliče releaseAllStudents prevečkrat  
      calledMoveToExitFunc = false;
    }
    
    float sRadius = radius * 0.4;
    
    float m = map(mins, 0, 60, 0, TWO_PI) - HALF_PI;
    
    if(mins == 60) {
      hours++;
    }
    if(hours == 24){
      hours = 0;
      day++;
      if(day == 32)
        day = 1;
      cal.spremeniDatum(day);
      
      switch(day%7){
        case 0:danVTednu="Tor"; break;
        case 1:danVTednu="Sre"; break;
        case 2:danVTednu="Čet"; break;
        case 3:danVTednu="Pet"; break;
        case 4:danVTednu="Sob"; break;
        case 5:danVTednu="Ned"; break;
        case 6:danVTednu="Pon"; break;
      }
    }
    
    line(location.x, location.y, location.x + cos(m) * sRadius, location.y + sin(m) * sRadius);
    
    //RISANJE URINEGA KAZALCA
    float lx, ly;
    if (mins != 60) {
      lx = location.x + cos(hours*(PI/6) - HALF_PI+(mins/120)) * spRadius * 0.7;
      ly = location.y + sin(hours*(PI/6) - HALF_PI+(mins/120)) * spRadius * 0.7;
    } else {
      lx = location.x + cos(hours*(PI/6) - HALF_PI) * spRadius * 0.7;
      ly = location.y + sin(hours*(PI/6) - HALF_PI) * spRadius * 0.7;
    }
    
    strokeWeight(5);
    line(location.x, location.y, lx, ly);
    strokeWeight(3);
    
    s = danVTednu + ", " + nf(hours, 2, 0) + ":" + nf(mins, 2, 0);
    
    textSize(24);
    fill(0);
    textAlign(CENTER);
    text(s, location.x, location.y + radius/2+30); 
      
    if(mins == 60){ 
        mins = 0; 
    }
    
    if(hours % 2 == 1 && mins == 15){
      tps = 5;
    } 
    if(N_PEOPLE_INSIDE == 0 && hours != 6)
      tps = 1;
    
    if(hours % 2 == 0 && mins == 45 && calledReleaseFunc == false){
      if(schoolTime){
        if(hours >= 6 && hours <= 18)
          openAllClassroomDoors();
        lessonsTime = false;
        releaseAllStudentsFromClass();
        calledReleaseFunc = true;
        tps = 50;
      }
    }
    
    if(hours % 2 == 1 && mins == 15 && calledReleaseFunc == false){
      if(hours >= 6 && hours <= 19)
        closeAllClassroomDoors();
      lessonsTime = true;
    }
    
    if(hours == 18 && mins == 45 && calledMoveToExitFunc == false){
      moveAllStudentsToExit();
      studentsAreReturning = true;
      calledMoveToExitFunc = true;
      schoolTime = false;
      N_TOTAL_PEOPLE_RESPAWNED = 0;
    }
    
    if(hours >= 6 && hours < 16 && (!danVTednu.equals("Ned") && !danVTednu.equals("Sob"))){
      schoolTime = true;
      if(studentsAreReturning == false)
        spawnStudent();
      else
        respawnStudent();
    }
   }
   
}
