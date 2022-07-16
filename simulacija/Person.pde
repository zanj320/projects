class Person {
  PVector location;
  PVector velocity;
  PVector acceleration;
  
  color state;
  float radius = 7;
  
  PVector target;
  int currPathIndex;
  
  LinearPath lp;
  int x,y;
  int class_x, class_y;
  boolean in_class;
  boolean path_from_class;
  int idUcilnice;
  int sitDown;
  
  boolean vaccinated;
  boolean inFaculty;
  int canSpread;
  float infectionChance;                      
  ArrayList<Person> personCurrentlyInteract;
  
  int stStikov = 0;
  
  Person(PVector loc) {
    location = loc.get();
    velocity = new PVector();
    acceleration = new PVector();
    target = this.location;
    in_class = false;
    class_x = -1;
    class_y = -1;
    path_from_class = false;
    inFaculty = true;
    personCurrentlyInteract = new ArrayList<Person>();
    this.lp = new LinearPath();
    vaccinated=false;
    canSpread=0;
  }
  
  void setTargets(LinearPath lp_o){
    ArrayList<PVector> targets = new ArrayList<PVector>();
      
    for(int i=0; i<lp_o.pathSize(); i++){
      targets.add(lp_o.targets.get(i));
    }
    
    lp.addTargets(targets);
    //target = lp.getFirst();
  }
  
  void setX_Y(int x, int y){
    this.x = x;
    this.y = y;
  }
  
  void setClassX_Y(int x, int y){
    this.class_x = x;
    this.class_y = y;
  }
  
  int getClassY(){
    return class_y;
  }
  
  void setLocation(PVector loc) {   location = loc.get(); }
  void setVelocity(PVector v) {     velocity = v.get();     }
  void setAcceleration(PVector a) { acceleration = a.get();   }
  void setState(color c) { state = c; }
  
  void applyForce(PVector force) {
    acceleration = force;
  }
  
  void checkCollision() {
    PVector tmp_loc = location.get();
    PVector tmp_vel = velocity.get();
    tmp_vel.add(acceleration);
    tmp_loc.add(tmp_vel);
    
    color pixel_value = get(int(tmp_loc.x), int(tmp_loc.y));
    if (pixel_value == COLOR_ALLOWED_SPACE) {
      return;
    }
    else {
      velocity.mult(0);
      acceleration.mult(0);
    }
  }
  
  void interactsWith(Person p) {
    PVector p_loc = p.location.get();
    float distance = p_loc.dist(location);
    if (distance <= 1.5*radius) {
      if(!p.personCurrentlyInteract.contains(this)) {
        p.personCurrentlyInteract.add(this);
        stStikov++;
        this.getInfectionChance();
        if(p.state == COLOR_POSITIVE && random(0,1) < infectionChance)   // ce je this okuzen, ima infectionChance = 0
              this.okuziSe();
      }
    }
    else if(p.personCurrentlyInteract.contains(this)) p.personCurrentlyInteract.remove(this);
  }
  
  void okuziSe() {
    state = COLOR_NPOSITIVE;
    vaccinated=false;
    canSpread=1;
  }
  
  
  void infectionInClassroom(ArrayList<Person> students) {    // ko se vsede, preveri s kom je v razredu ter ce je kdo v njegovi blizini pozitiven 
    if(sitDown == 1) {
      for(int i = 0; i < students.size(); i++) {
        Person otherStudent = students.get(i);
        if(otherStudent.in_class && otherStudent.idUcilnice == this.idUcilnice) {  // sta v isti ucilnici (this in otherStudent)
          PVector otherStudent_loc = otherStudent.location.get();
          float distance = otherStudent_loc.dist(location);
          
          if(distance <= 3*radius)
            infectionInClassroomCheck(otherStudent);
          
          else if(distance <= 6*radius)
            infectionInClassroomCheck(otherStudent);
          
          else if(distance <= 9*radius)
            infectionInClassroomCheck(otherStudent);
        }
      }
    }
  }
  
  
  void infectionInClassroomCheck(Person otherStudent) {  
    if(otherStudent.inFaculty == true){
      this.stStikov++;
      otherStudent.stStikov++;
      if(this.state == COLOR_POSITIVE && (otherStudent.state != COLOR_POSITIVE && otherStudent.state != COLOR_NPOSITIVE)) {
        otherStudent.getInfectionChance();
        if (!okna[idUcilnice].stanjeOkna && clasrooms.get(idUcilnice).slabZrak)
          otherStudent.infectionChance += 0.05;
        if(random(0,1) < otherStudent.infectionChance)
          otherStudent.okuziSe();
      }
      
      else if(otherStudent.state == COLOR_POSITIVE  && (this.state != COLOR_POSITIVE && this.state != COLOR_NPOSITIVE)) {
        this.getInfectionChance();
        if (!okna[idUcilnice].stanjeOkna && clasrooms.get(idUcilnice).slabZrak)
          this.infectionChance += 0.05;
        if(random(0,1) < this.infectionChance)
            this.okuziSe();
      } 
    }
  }
  
  void getInfectionChance() {        
      if(state == COLOR_NEGATIVE)
        infectionChance = INFECTION_CHANCE_MASK;
      else if(state == COLOR_VACCINATED)
        infectionChance = INFECTION_CHANCE_MASK*0.2;
      if(b4.onOff){
        infectionChance = INFECTION_CHANCE_MASK*0.5;
      }
      else if(state == COLOR_POSITIVE || state == COLOR_NPOSITIVE)
        infectionChance = 0;
  }
  
  void update() {
    if(this.inFaculty){
      if(this.lp.pathSize() > 0){
        acceleration = PVector.sub(target, this.location);
        
        acceleration.setMag(1);
        velocity.add(acceleration);
        velocity.limit(2);
        location.add(velocity);
      }
      
      if(this.canSpread>0){
        this.canSpread++;
        }
        if(canSpread>3000){
          this.canSpread=-10;
          state = COLOR_POSITIVE;
          if(this.in_class) {                                  
            sitDown = 0;
            clasrooms.get(idUcilnice).stOkuzenih++;
            clasrooms.get(idUcilnice).preveriStanjeOkuzenostiVRazredu();
          }
       }
    }
  }
  
  void followPath() {
   if(this.lp.pathSize() != 0){
     if (roundEquals(this.target, this.location)) {
       this.lp.removeFirstTarget();
       if (this.lp.pathSize() != 0) {
         this.target = this.lp.getFirst();
       }
     }
    
    } else {
      if(this.inFaculty == true){
        if(!in_class && lp.pathSize() <= 0 && path_from_class == false){
          for(int i=0; i<clasrooms.size(); i++){
            Classroom tmp = clasrooms.get(i);
            if(tmp.x == x && tmp.y == y){
              if(tmp.door_opened){
                tmp.addPerson(this);
                in_class = true;
                idUcilnice = tmp.getIdUcilnice();    
                path_from_class = false;
              }else{
                break;
              }
            }
          }
        }else if(in_class) {    
            sitDown++;
        }
  
        if(!in_class){
          if(x == 8 && y == 0){ //<>//
            this.inFaculty = false;
            N_PEOPLE_INSIDE--;
            //this.lp.targets.clear();
            //N_TOTAL_PEOPLE_SPAWNED--;
            //students.remove(this);
            //println(N_PEOPLE_INSIDE + " - " + N_TOTAL_PEOPLE_SPAWNED);
            return;
          }
          makeAPath(this, x, y);
          this.path_from_class = false;
        
        }
      }
    }
  }
  
  void draw() {
    if(inFaculty){
      //circle(location.x, location.y, radius*2);
      noFill();
      stroke(state);
      float gaze_angle = velocity.heading();
      arc(location.x, location.y, radius*2.5, radius*2.5, gaze_angle-(HALF_PI*0.4), gaze_angle+(HALF_PI*0.4));
      fill(state);
      circle(location.x, location.y, radius);
      PVector tmp = location.get().add(velocity);
      line(location.x, location.y, tmp.x, tmp.y);
      fill(255);
    }
  }
}
