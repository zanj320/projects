class Employee{
  int x;
  int y;
  PVector pos;
  PVector p1, p2;
  LinearPath lp;
  
  PVector location;
  PVector velocity;
  PVector acceleration;
  PVector target;
  
  int curr;
  float radius = 7.5;
  color state;
  boolean pathing; 
  int employeeStopTime = 1;
  int employeePom = 1;
  float gaze_angle;
  boolean move = false;
  
  Employee(int x, int y, PVector pos, color state, boolean pathing){
    this.x = x;
    this.y = y;
    this.curr = 0;
    
    this.location = pos.get();
    this.velocity = new PVector();
    this.acceleration = new PVector();
    
    this.state = state;
    this.pathing = pathing;
    
    this.lp = new LinearPath();
    p1 = new PVector();
    p2 = new PVector();
    target = new PVector();
    target = this.location;
    
    gaze_angle = new PVector(1, 0).heading();
    
    createMovePoints();
  }
  
  void update() {
    if((employeeStopTime % employeePom == 0)){ 
      employeePom = (int)random(30, 150);
      employeeStopTime = 1;
      move = !move;
    }
    employeeStopTime++;
    
    if(this.lp.pathSize() > 0 && move == true && c.lessonsTime){
      acceleration = PVector.sub(target, this.location);
      
      acceleration.setMag(1);
      velocity.add(acceleration);
      velocity.limit(0.5);
      location.add(velocity);
    }
    
    if(c.lessonsTime)
      followPath();
      
   if(move == false){
     if(y == c1_y && x == 12)
       gaze_angle = new PVector(1, 0).heading();
     else if(y == 0 && x == 10)
       gaze_angle = new PVector(-1, 0.2).heading();
     else if(y == c1_y && x == 6)
       gaze_angle = new PVector(0, 1).heading();
     else if(y == c1_y)
       gaze_angle = new PVector(-1, 0).heading();
     else if(y == c2_y)
       gaze_angle = new PVector(1, 0).heading();
   }
  }
  
  void createMovePoints(){
    p1 = new PVector(location.x, location.y + 50);
    p2 = new PVector(location.x, location.y - 50);
    
    lp.addTarget(p1);
    lp.addTarget(p2);
  }
  
  void setThePoints(PVector p1, PVector p2){
    this.lp.targets.clear();
    this.lp.targets.add(p1);
    this.lp.targets.add(p2);
  }
  
  void followPath() {
 
   if(this.lp.pathSize() != 0){
    if (roundEquals(this.target, this.location)) {
      if (curr == 0) {
        this.target = this.lp.targets.get(1);
        curr = 1;
      }else if(curr == 1){
        this.target = this.lp.targets.get(0);
        curr = 0;
      }
    }  
  }
  
  }
  
  void draw() {
    
    if(N_PEOPLE_INSIDE != 0){
      //circle(location.x, location.y, radius*2);
      noFill();
      stroke(state);
      //velocity = new PVector(-1, 0);
      if(move)
        gaze_angle = velocity.heading();
      
      if(x == -1){
        gaze_angle = new PVector(-1, 0).heading(); // pogleda levo
      }else if(x == -2){
        gaze_angle = new PVector(1, 0).heading(); // pogleda desno
      }else if(x == -3){
        gaze_angle = new PVector(0, -1).heading(); // pogleda gor
      }else if(x == -4){
        gaze_angle = new PVector(0, 1).heading(); // pogleda dol
      }
      
      arc(location.x, location.y, radius*2.5, radius*2.5, gaze_angle-(HALF_PI*0.4), gaze_angle+(HALF_PI*0.4));
      fill(state);
      circle(location.x, location.y, radius);
      PVector tmp = location.get().add(velocity);
      line(location.x, location.y, tmp.x, tmp.y);
      fill(255);
      if(pathing)
        update();
    }
  }
}
