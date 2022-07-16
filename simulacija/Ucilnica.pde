class Classroom{
  PVector pos;
  int x, y, capacity, row, collumn,  students_inside;
  Person[] students;
  PVector startingPos;
  LinearPath hall;
  boolean[][] seats;
  boolean door_opened;
  
  int idUcilnice;
  int stOkuzenih;
  boolean slabZrak;
  boolean timerSlabZrak;
  boolean timerDoberZrak;
  
  Classroom(int x, int y, PVector pos, int capacity, int row, int collumn, PVector startingPos, int idUcilnice_){    
    this.x = x;
    this.y = y;
    this.pos = pos;
    
    this.capacity = capacity;
    this.row = row;
    this.collumn = collumn;
    
    this.door_opened = true;
    
    students = new Person[capacity];
    students_inside = 0;
    
    this.startingPos = startingPos;
    
    hall = new LinearPath();
    createClassHall();
    
    seats = new boolean[row][collumn];
    for(int i=0; i<row; i++){
      for(int k=0; k<collumn; k++){
        seats[i][k] = false;
      }
    }
    idUcilnice = idUcilnice_;
    stOkuzenih = 0;
    slabZrak = false;
  }
  
  int getIdUcilnice() {      
    return idUcilnice;
  }
  
  void closeTheDoor(){
    this.door_opened = false;
  }
  
  void openTheDoor(){
    this.door_opened = true;
  }
  
  void createClassHall(){
    float tmp_x = startingPos.x;
    if(y == c1_y || y == 0)
      tmp_x = tmp_x - 0;
    else if(y == c2_y)
      tmp_x = tmp_x + 0; // + 70 zato da je hall na desni (ker pri y=1 so vecinoma vrata na desni)
      
    float tmp_y = startingPos.y;
    
    //hall.addTarget(new PVector(tmp_x, tmp_y));
    if(y == c2_y)
      tmp_y = tmp_y + 25;
    else if(y == c1_y || y == 0)
      tmp_y = tmp_y - 25;// - (row * 12.5);
    
    if(y == 0 || (y==c1_y && x==6))
      tmp_y -= 18;
      
    hall.addTarget(new PVector(tmp_x, tmp_y));
      
    for(int i=0; i<row-1; i++){
      if(y == c2_y)
         tmp_y += 23;
      else if(y == c1_y || y == 0)
         tmp_y -= 23;
        
      hall.addTarget(new PVector(tmp_x, tmp_y));
    }
  }
  
  void addPerson(Person p){
    if(students_inside < capacity){
      students[students_inside] = p;
      students_inside++;
      p.in_class = true;
      if(p.state == COLOR_POSITIVE) {
        stOkuzenih++; 
        preveriStanjeOkuzenostiVRazredu();
      }
      if(students_inside == capacity)
        door_opened = false;
    }
    
    sitThePersonDown(p);
  }
  
  void preveriStanjeOkuzenostiVRazredu() {
     if(okna[idUcilnice].stanjeOkna == true) {
       slabZrak = false;
       timerSlabZrak = false;
       timerDoberZrak = false;
     }
     else if(stOkuzenih >= 1 && okna[idUcilnice].stanjeOkna == false && !slabZrak) {
         okna[idUcilnice].casPrispetjaOkuzenega = millis();
         timerSlabZrak = true;
         timerDoberZrak = false;
         slabZrak = true;
     }
     else if(stOkuzenih == 0 && slabZrak) {
        okna[idUcilnice].casOdspetjaOkuzenega = millis();
        timerDoberZrak = true;
        timerSlabZrak = false;
        slabZrak = false;
     }
  }
  
  boolean isFull(){
    return students_inside == capacity;
  }
  
  void findFreeSeat(int sit_row, int sit_col){
    for(int i=0; i<row; i++)
      for(int k=0; k<collumn; k++){
        if(seats[i][k] == false){
          sit_row = i;
          sit_col = k;
          return;
        }
      }
  }
  void sitThePersonDown(Person p){
    boolean has_sitten = false;
    int tries = 0; // če je probal več kot 5x random poiskt frej zic mu ga mi poiscemo
    while(!has_sitten){
      int sit_row = (int)random(0, row);
      int sit_col = (int)random(0, collumn);
      
      if(tries > 5){
        findFreeSeat(sit_row, sit_col);
      }
      
      if(seats[sit_row][sit_col] == false){
        seats[sit_row][sit_col] = true;
        
        LinearPath tmp = new LinearPath();
        int i;
        for(i=0; i<=sit_row; i++){
          tmp.targets.add(hall.targets.get(i));  // povemo v katero vrsto naj se postavi
        }
        
        if(y == c2_y || (y==c1_y && x==12) || (y==0 && x == 10))
          tmp.targets.add(new PVector(hall.targets.get(i-1).x + 7 + (sit_col * 18.5), hall.targets.get(i-1).y));
        else if(y == c1_y)
          tmp.targets.add(new PVector(hall.targets.get(i-1).x - 7 - (sit_col * 18.5), hall.targets.get(i-1).y));
        
        if(y == c1_y || (y==0 && x == 10)){
          if(x != 12){
            PVector pravilnoObrni1 = new PVector(tmp.targets.get(tmp.targets.size()-1).x-(3*p.radius+1), tmp.targets.get(tmp.targets.size()-1).y, 0);
            tmp.targets.add(pravilnoObrni1);
            PVector pravilnoObrni2 = new PVector(tmp.targets.get(tmp.targets.size()-1).x+(p.radius+1), tmp.targets.get(tmp.targets.size()-1).y, 0);
            tmp.targets.add(pravilnoObrni2);
          }
        }else if(y == c2_y || (y == c1_y && x == 12)){
          PVector pravilnoObrni1 = new PVector(tmp.targets.get(tmp.targets.size()-1).x+(3*p.radius+1), tmp.targets.get(tmp.targets.size()-1).y, 0);
          tmp.targets.add(pravilnoObrni1);
          PVector pravilnoObrni2 = new PVector(tmp.targets.get(tmp.targets.size()-1).x-(p.radius+1), tmp.targets.get(tmp.targets.size()-1).y, 0);
          tmp.targets.add(pravilnoObrni2);
          /*
          // za obračanje glave oz. v kero smer gledajo
          // sam spremeniš smer spremenljivke gaze_angle
          if(x == -1){
            gaze_angle = new PVector(-1, 0).heading(); // pogleda levo
          }else if(x == -2){
            gaze_angle = new PVector(1, 0).heading(); // pogleda desno
          }else if(x == -3){
            gaze_angle = new PVector(0, -1).heading(); // pogleda gor
          }else if(x == -4){
            gaze_angle = new PVector(0, 1).heading(); // pogleda dol
          }

          arc(location.x, location.y, radius*4, radius*4, gaze_angle-(HALF_PI*0.25), gaze_angle+(HALF_PI*0.25));
          */
        }
        
        p.setTargets(tmp);
        p.setClassX_Y(sit_col, sit_row);
        has_sitten = true;
      }
      
      tries++;
    }
  }

  void releaseStudents(){
    //ArrayList<PVector> reversedHall = hall.reversedList();
    //tmp.addTargets(reversedHall);
    if(students_inside > 0){
      for(int j=0; j<capacity; j++){
        LinearPath tmp = new LinearPath();
        Person s = students[j];
        if(s != null){
          int i = s.class_y;
          for(; i>=0; i--){
            tmp.targets.add(hall.targets.get(i));  // povemo v katero vrsto naj se postavi
          }
          tmp.targets.add(points[s.y][s.x]);
          s.setTargets(tmp);
          s.path_from_class = true;
          seats[s.class_y][s.class_x] = false;
          s.in_class = false;
          if(s.state == COLOR_POSITIVE) {
            stOkuzenih--;
            preveriStanjeOkuzenostiVRazredu();
          }
          s.sitDown = 0;         
          students[j] = null;
          students_inside--;
        }else{
         break;
        }
        
      }
    }

  }
}
