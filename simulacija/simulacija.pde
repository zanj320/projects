//najnovejsa 22.17

//Paths
int N_PEOPLE = 150;
int N_PEOPLE_INSIDE = 0;
int N_TOTAL_PEOPLE_SPAWNED = 0;
int N_TOTAL_PEOPLE_RESPAWNED = 0;
int N_TOTAL_CLASSROOMS = 0;
int N_TOTAL_ASSISTANTS = 0;
int day=1;
int br = 0;

color COLOR_BACKGROUND=color(230);
color COLOR_ALLOWED_SPACE = color(255);

color COLOR_POSITIVE = color(200, 0, 0);
color COLOR_NPOSITIVE = color(255, 100, 0);
color COLOR_NEGATIVE = color(0, 200, 0);
color COLOR_HAS_MASK = color(100, 150, 220);
color COLOR_FIXED_PERSON = color(60, 12, 120);
color COLOR_VACCINATED = color(26, 77, 35);

color COLOR_HAS_GLASSES = color(250, 0, 220);
color COLOR_HEALED=color(100, 0, 192);

float INFECTION_CHANCE_MASK = 0.015;
/*float INFECTION_CHANCE_WITHOUT_MASK = 0.8;
float INFECITON_CHANCE_VACCINATED = 0.15;    
*/
int stSrecnihStikov=0;
boolean studentsAreReturning;

ArrayList<Person> students;

Graph g;
Graph g2;
Button b,b2,b3,b4;

Legend l;

Slider ceplenje;

float current_stats=0;

PShape floor;
PShape floor_nice;

int x_start = 8;
int y_start = 0;

PVector[][] points = {
    {null,                  null,                  null,                  null,                  null,                  null,                  null,                  null,                   new PVector(1174, 279), null,                   new PVector(1354, 416), null,                   null,                   null},
    {null,                  null,                  null,                  null,                  null,                  null,                  null,                  null,                   new PVector(1148, 441), new PVector(1252, 451), new PVector(1338, 445), null,                   null,                   null}, 
    {null,                  null,                  null,                  null,                  null,                  null,                  null,                  null,                   new PVector(1137, 464), null,                   null,                   null,                   null,                   null},
    {new PVector(203, 587), new PVector(323, 617), new PVector(447, 617), new PVector(568, 617), new PVector(690, 587), null,                  new PVector(940, 595), new PVector(1029, 513), new PVector(1125, 528), null,                   new PVector(1434, 617), new PVector(1554, 617), new PVector(1610, 617), new PVector(1798, 587)},
    {new PVector(188, 653), new PVector(302, 664), new PVector(424, 664), new PVector(552, 664), new PVector(678, 664), new PVector(770, 664), new PVector(927, 664), new PVector(1020, 664), new PVector(1125, 664), new PVector(1240, 664), new PVector(1362, 664), new PVector(1532, 664), new PVector(1602, 664), new PVector(1728, 664)},
    {new PVector(138, 700), new PVector(259, 700), new PVector(454, 700), null,                  new PVector(628, 700), new PVector(750, 700), new PVector(874, 700), null,                   new PVector(1187, 700), new PVector(1247, 700), new PVector(1371, 700), null,                   new PVector(1606, 700), new PVector(1738, 700)}
};

PVector[][] assistantPoints = {
    {null,                  null,                  null,                  null,                  null,                  null,                  null,                  null,                   null,                   null,                   new PVector(1520, 331), null,                   null,                   null},
    {null,                  null,                  null,                  null,                  null,                  null,                  null,                  null,                   null,                   null,                   null,                   null,                   null,                   null}, 
    {null,                  null,                  null,                  null,                  null,                  null,                  null,                  null,                   null,                   null,                   null,                   null,                   null,                   null},
    {new PVector(215, 531), new PVector(338, 545), new PVector(461, 548), new PVector(581, 551), new PVector(701, 535), null,                  new PVector(827, 348), new PVector(1029, 513), null,                   null,                   new PVector(1444, 549), new PVector(1567, 546), new PVector(1601, 549), new PVector(1815, 541)},
    {null,                  null,                  null,                  null,                  null,                  null,                  null,                  null,                   null,                   null,                   null,                   null,                   null,                   null}, 
    {new PVector(119, 763), new PVector(243, 771), new PVector(451, 765), null,                  new PVector(612, 770), new PVector(738, 766), new PVector(858, 766), null,                   new PVector(1187, 766), new PVector(1230, 766), new PVector(1349, 766), null,                   new PVector(1598, 766), new PVector(1719, 766)}
};

int c1_y = 3;
int c2_y = 5;

ArrayList<PVector> targets;
LinearPath lp;

Clock c;
Calendar cal;

int studentSpawnTime = 1;
int studentPom = 1;

ArrayList<Classroom> clasrooms;
ArrayList<Employee> assistants;
ArrayList<Employee> fixedPeople;

PGraphics[] layers = new PGraphics[1];

Okno[] okna;
int sekunde=7;

void setup() {
  //size(1920, 1080);
  fullScreen();
  background(255);
  frameRate(60);
  
  for (int i = 0; i < layers.length; i++) {
    layers[i] = createGraphics(width, height);
    layers[i].beginDraw();
  }
  
  fill(127);
  rect(10, 10, 990, 490);
  
  g = new Graph(COLOR_POSITIVE);
  g2 = new Graph(COLOR_NEGATIVE);
  
  b = new Button(980,935,80); //b=new Button(1715,330,60);
  b.nastaviSlike("pause.png","play.png");
  b.spremeniBarvoGumba(color(#B0B7C0),color(#647C90),color(0));
  //b.spremeniBarvoGumba(color(#BDC3CB),color(#DCD2CC),color(#003B73));
  b2 = new Button(1450,950,50);
  b2.nastaviSlike("neceplen.png","ceplen.png");
  b3 = new Button(1600,950,50);
  b3.nastaviSlike("maska.png","niMaske.png");
  b4 = new Button(1750,950,50);
  b4.nastaviSlike("zaprto.png","odprto.png");
  ceplenje=new Slider(1330,975,0,100,70,100,10);
  
  c = new Clock(new PVector(250,200), 180, 20); //c = new Clock(new PVector(1745,165), 150, 20);
  cal = new Calendar(400, 110, 150);
  l = new Legend(1575, 110); //50 50
    
  students = new ArrayList<Person>();
  clasrooms = new ArrayList<Classroom>();
  assistants = new ArrayList<Employee>();
  fixedPeople = new ArrayList<Employee>();
  
  targets = new ArrayList<PVector>();
  lp = new LinearPath();
  targets.add(points[y_start][x_start]);
  lp.addTarget(points[y_start][x_start]);
  
  studentsAreReturning = false;
  
  floor = loadShape("FRI_objekt_mask.svg");
  floor_nice = loadShape("FRI_objekt_v3_merged2_new.svg");
  
  createClassrooms();
  createFixedPeople();
  
  okna  = new Okno[N_TOTAL_CLASSROOMS];
  
  for (int i=0; i<N_TOTAL_CLASSROOMS; i++) {
    okna[i] = new Okno();
    okna[i].casPrispetjaOkuzenega = 0;
    okna[i].casOdspetjaOkuzenega = 0;
  }
  
  NasopejGumbe();
  
  for (int i=0; i<N_TOTAL_CLASSROOMS; i++) {
    okna[i].oknGumb.spremeniRazmerje(0);
    okna[i].oknGumb.nastaviSlike("zaprto.png","odprto.png");
    okna[i].oknGumb.spremeniBarvoGumba(color(COLOR_BACKGROUND),color(COLOR_BACKGROUND),color(COLOR_BACKGROUND));
  }
  
  layers[0].shape(floor, 10, 10, 1900, 1060);
  layers[0].shape(floor_nice, 10, 10, 1900, 1060);
  
  for (int i = 0; i < layers.length; i++) {
    layers[i].endDraw();
  }
}

void NasopejGumbe() {
  okna[0].oknGumb = new Button(1400, 225, 30);
  okna[1].oknGumb = new Button(155, 419, 30);
  okna[2].oknGumb = new Button(277, 419, 30);
  okna[3].oknGumb = new Button(400, 419, 30);
  okna[4].oknGumb = new Button(520, 419, 30);
  okna[5].oknGumb = new Button(645, 419, 30);
  okna[6].oknGumb = new Button(830, 282, 30);
  okna[7].oknGumb = new Button(1400, 419, 30);
  okna[8].oknGumb = new Button(1505, 419, 30);
  okna[9].oknGumb = new Button(1630, 419, 30);
  okna[10].oknGumb = new Button(1752, 419, 30);
  okna[11].oknGumb = new Button(155, 840, 30);
  okna[12].oknGumb = new Button(277, 840, 30);
  okna[13].oknGumb = new Button(500, 840, 30);
  okna[14].oknGumb = new Button(645, 840, 30);
  okna[15].oknGumb = new Button(768, 840, 30);
  okna[16].oknGumb = new Button(890, 840, 30);
  okna[17].oknGumb = new Button(1262, 840, 30);
  okna[18].oknGumb = new Button(1400, 840, 30);
  okna[19].oknGumb = new Button(1630, 840, 30);
  okna[20].oknGumb = new Button(1752, 840, 30);
}

void izrisujVrata() {             
   stroke(0);
   strokeWeight(1.02);
   if (clasrooms.get(0).door_opened)
     narisiVrataOdprta();
   else
     narisiVrataZaprta();
}

void narisiVrataOdprta(){
  line (1338, 418, 1340, 428);
  line (1363, 414, 1365, 426);
  line (211, 581, 211, 593);
  line (333, 610, 333, 624);
  line (456, 610, 456, 624);
  line (577, 610, 577, 624);
  line (700, 580, 700, 594);
  //line (769, 611, 771, 622);
  //line (794, 610, 796, 620);
  line (926, 596, 928, 608);
  line (950, 594, 952, 605);
  line (1441, 610, 1441, 624);
  line (1563, 610, 1563, 624);
  line (1599, 610, 1599, 624);
  line (1808, 580, 1808, 594);
  line (128, 708, 128, 693);
  line (251, 708, 251, 694);
  line (463, 708, 463, 694);
  line (618, 708, 618, 694);
  line (741, 708, 741, 694);
  line (863, 708, 863, 694);
  line (1236, 708, 1236, 694);
  line (1358, 708, 1358, 694);
  line (1603, 708, 1603, 694);
  line (1726, 708, 1726, 694);
}

void narisiVrataZaprta() {
  line (1338, 418, 1363, 414);
  line (769, 611, 794, 608);
  line (926, 596, 950, 594);
  line (210, 580, 198, 580);
  line (333, 610, 320, 610);
  line (456, 610, 443, 610);
  line (577, 610, 564, 610);
  line (701, 580, 688, 580);
  line (1441, 610, 1428, 610);
  line (1563, 610, 1550, 610);
  line (1599, 610, 1612, 610);
  line (1808, 580, 1795, 580);
  line (128, 708, 142, 708);
  line (251, 708, 264, 708);
  line (463, 708, 445, 708);
  line (618, 708, 632, 708);
  line (741, 708, 755, 708);
  line (863, 708, 876, 708);
  line (1236, 708, 1250, 708);
  line (1358, 708, 1372, 708);
  line (1603, 708, 1618, 708);
  line (1726, 708, 1740, 708);
}

void createClassrooms(){
  clasrooms = new ArrayList<Classroom>();
  for(int i=0; i<6; i++){
    for(int k=0; k<14; k++){
      if((i == c1_y || i == c2_y) && (k != 7 && k != 8) && points[i][k] != null){
        if(i == c1_y && k == 6)
          clasrooms.add(new Classroom(k, i, points[i][k], 56, 7, 8, points[i][k], N_TOTAL_CLASSROOMS));  
        else
          clasrooms.add(new Classroom(k, i, points[i][k], 16, 4, 4, points[i][k], N_TOTAL_CLASSROOMS));    
        
        N_TOTAL_CLASSROOMS++;
        assistants.add(new Employee(k, i, assistantPoints[i][k], COLOR_HAS_MASK, true));
        if(i == c1_y && k == 6)
          assistants.get(assistants.size()-1).setThePoints(new PVector(731, 360), new PVector(920, 345));
        N_TOTAL_ASSISTANTS++;
      }
      if(i == 0 && k == 10){
        clasrooms.add(new Classroom(k, i, points[i][k], 32, 4, 8, points[i][k], N_TOTAL_CLASSROOMS));
        assistants.add(new Employee(k, i, assistantPoints[i][k], COLOR_HAS_MASK, true));
        assistants.get(assistants.size()-1).setThePoints(new PVector(1511, 295), new PVector(1525, 378));
        N_TOTAL_CLASSROOMS++;
        N_TOTAL_ASSISTANTS++;
      }
    }
  }
}

void createStudent(){
  if(N_PEOPLE_INSIDE < N_PEOPLE){
    students.add(new Person(points[0][8]));
    Person s;
    if(studentsAreReturning == true){
      s = students.get(N_TOTAL_PEOPLE_RESPAWNED);
      N_TOTAL_PEOPLE_RESPAWNED++;
    }else{
      s = students.get(N_TOTAL_PEOPLE_SPAWNED);
    }
    
    makeAPath(s, 8, 0);
    if(random(100)<ceplenje.value()&& b2.onOff){
      s.setState(COLOR_VACCINATED);
      s.vaccinated=true;
    }
    
    else
    s.setState(COLOR_NEGATIVE);
    if (N_PEOPLE_INSIDE == 1) {
      s.setState(COLOR_POSITIVE);
      //students.get(N_PEOPLE_INSIDE).okuziSe();
    }
    N_PEOPLE_INSIDE++;
    N_TOTAL_PEOPLE_SPAWNED++;  
  }
}

void createFixedPeople(){
  // študentski svet
  fixedPeople.add(new Employee(-2, -1, new PVector(1015, 403), COLOR_FIXED_PERSON, false));
  fixedPeople.add(new Employee(-2, -1, new PVector(1018, 373), COLOR_FIXED_PERSON, false));
  fixedPeople.add(new Employee(-1, -1, new PVector(1068, 371), COLOR_FIXED_PERSON, false));
  fixedPeople.add(new Employee(-1, -1, new PVector(1058, 408), COLOR_FIXED_PERSON, false));
  
  //b88 prostor
  fixedPeople.add(new Employee(-1, -1, new PVector(1200, 484), COLOR_FIXED_PERSON, false));
  fixedPeople.add(new Employee(-1, -1, new PVector(1195, 510), COLOR_FIXED_PERSON, false));
  fixedPeople.add(new Employee(-1, -1, new PVector(1186, 587), COLOR_FIXED_PERSON, false));
  fixedPeople.add(new Employee(-1, -1, new PVector(1183, 616), COLOR_FIXED_PERSON, false));
  
  //referat
  fixedPeople.add(new Employee(-3, -1, new PVector(1125, 767), COLOR_FIXED_PERSON, false));
  fixedPeople.add(new Employee(-2, -1, new PVector(1169, 774), COLOR_FIXED_PERSON, false));
  fixedPeople.add(new Employee(-2, -1, new PVector(1172, 795), COLOR_FIXED_PERSON, false));
}

void studentsMovement(){
  for (int i = 0; i < N_TOTAL_PEOPLE_SPAWNED; i = i+1) {
    Person student = students.get(i);
    if(student != null){
      student.applyForce(new PVector(random(-0.1, 0.1), random(-0.1, 0.1)));
      student.update();
      student.followPath();
      if(student.in_class)      
        student.infectionInClassroom(students);
      else {
        for (int j = 0; j < N_TOTAL_PEOPLE_SPAWNED; j++) {
          if (i != j) {
            student.interactsWith(students.get(j)); // check here for virus propagation
          }
        }
      }
    }
  }
}

void checkStudentStatus(){
  current_stats = 0;
  for (int i = 0; i < N_TOTAL_PEOPLE_SPAWNED; i = i+1) {
    if (students.get(i).state == COLOR_POSITIVE && students.get(i).inFaculty == true) {
      current_stats++;
    }
  }
}

void releaseAllStudentsFromClass(){
  for(int i=0; i<N_TOTAL_CLASSROOMS; i++)
      clasrooms.get(i).releaseStudents();
}

void closeAllClassroomDoors(){
  for(int i=0; i<N_TOTAL_CLASSROOMS; i++)
      clasrooms.get(i).closeTheDoor();
}

void openAllClassroomDoors(){
  for(int i=0; i<N_TOTAL_CLASSROOMS; i++)
      clasrooms.get(i).openTheDoor();
}

void spawnStudent(){
  // spawn peeps every 15 frames
  if((studentSpawnTime % studentPom == 0) && N_TOTAL_PEOPLE_SPAWNED != N_PEOPLE){ 
    createStudent();
    studentPom = (int)random(10, 50);
    studentSpawnTime = 1;
  }
  studentSpawnTime++;
}

void respawnStudent(){
  if((studentSpawnTime % studentPom == 0) && N_TOTAL_PEOPLE_RESPAWNED != N_TOTAL_PEOPLE_SPAWNED){ 
    Person s = students.get(N_TOTAL_PEOPLE_RESPAWNED);
    makeAPath(s, x_start, y_start);
    s.inFaculty = true;
    if(random(100)<ceplenje.value()&& b2.onOff&&s.state==COLOR_NEGATIVE){
      s.setState(COLOR_VACCINATED);
      s.vaccinated=true;
    }
    
    N_PEOPLE_INSIDE++;
    N_TOTAL_PEOPLE_RESPAWNED++;
    studentPom = (int)random(10, 50);
    studentSpawnTime = 1;
  }else if((studentSpawnTime % studentPom == 0) && N_TOTAL_PEOPLE_SPAWNED != N_PEOPLE){
    createStudent();
    studentPom = (int)random(10, 50);
    studentSpawnTime = 1;
  }
  studentSpawnTime++;
}

void moveAllStudentsToExit(){
  for(Person s : students){
    if(s.path_from_class == false)
      s.lp.removeAllTargets();
    makeAPath(s, s.x, s.y, x_start, y_start);
  }
}

void update() {

  rect(0, 0, 10, 10);
  
  studentsMovement();
  
  checkStudentStatus();
  
  g.update(current_stats);
  g2.update(N_TOTAL_PEOPLE_SPAWNED-current_stats);
  
}

void makeAPath(Person p, int x, int y, int x_dest, int y_dest){
  LinearPath po = new LinearPath();

  boolean point_found = false;
  //x_dest = 1;
  //y_dest = 1;
  
  boolean comingFromP1 = false;
  if(y == 0 && x == 10){
    comingFromP1 = true;
    y++;
    //po.addTarget(points[y][x]);
    //p.setX_Y(y,x);
  }
  
  po.addTarget(points[y][x]);
  while(!point_found){
    point_found = true;
    if(comingFromP1 == true){ // če prihaja iz p1 ga treba premaknt na sredino
      int rand_y = (int)random(-25, 25); // random premik za y
      if(x < 8 && points[y][x+1] != null){
        x++;
        po.addTarget(new PVector(points[y][x].x, points[y][x].y + rand_y));
        point_found = false;
      }else if(x > 8 && points[y][x-1] != null){
        x--;
        po.addTarget(new PVector(points[y][x].x, points[y][x].y + rand_y));
        point_found = false;
      }
      if(x == 8){
        comingFromP1 = false;
      }
    }
    else if(y != c2_y-1 && x != x_dest){
      int rand_x = (int)random(-25, 25); // random premik za y
      if(y < c2_y-1 && points[y+1][x] != null){
        y++;
        po.addTarget(new PVector(points[y][x].x + rand_x, points[y][x].y));
        point_found = false;
      }else if(y > c2_y-1 && points[y-1][x] != null){
        y--;
        po.addTarget(new PVector(points[y][x].x + rand_x, points[y][x].y));
        point_found = false;
      }
        
    }else if(x != x_dest){
      int rand_y = (int)random(-25, 25); // random premik za x
      if(x < x_dest && points[y][x+1] != null){
        x++;
        po.addTarget(new PVector(points[y][x].x, points[y][x].y + rand_y));
        point_found = false;
      }else if(x > x_dest && points[y][x-1] != null){
        x--;
        po.addTarget(new PVector(points[y][x].x, points[y][x].y + rand_y));
        point_found = false;
      }
    }else if(y != y_dest){
      //int rand_x = (int)random(-25, 25); // random premik za y
      if(y < y_dest && points[y+1][x] != null){
        y++;
        po.addTarget(new PVector(points[y][x].x, points[y][x].y));
        point_found = false;
      }else if(y > y_dest && points[y-1][x] != null){
        y--;
        po.addTarget(new PVector(points[y][x].x, points[y][x].y));
        point_found = false;
      }
    }
  }
  p.setX_Y(x,y);
  p.setTargets(po);
}

void makeAPath(Person p, int x, int y){
  LinearPath po = new LinearPath();
  int y_dest = y;
  int x_dest = x;
  
  boolean point_found = false;
  while(((x == x_dest && y == y_dest) || points[y_dest][x_dest] == null) || (y == 1 && (x == 10 || x == 9))){
    y_dest = (int)random(0, 6);
    x_dest = (int)random(0, 14);
  }
  //x_dest = 6;
  //y_dest = c1_y;
  boolean comingFromP1 = false;
  if(y == 0 && x == 10){
    comingFromP1 = true;
    y++;  
    //po.addTarget(points[y][x]);
    //p.setX_Y(y,x);
  }
  
  if(y_dest == 0 && x_dest == 10){
    goToP1(p, x, y);
  }
  else{
    po.addTarget(points[y][x]);
    while(!point_found){
      point_found = true;
     
      if(comingFromP1 == true){ // če prihaja iz p1 ga treba premaknt na sredino
        int rand_y = (int)random(-25, 25); // random premik za y
        if(x < 8 && points[y][x+1] != null){
          x++;
          po.addTarget(new PVector(points[y][x].x, points[y][x].y + rand_y));
          point_found = false;
        }else if(x > 8 && points[y][x-1] != null){
          x--;
          po.addTarget(new PVector(points[y][x].x, points[y][x].y + rand_y));
          point_found = false;
        }
        if(x == 8){
          comingFromP1 = false;
        }
      }
      else if((y != c2_y-1) && x != x_dest){
        int rand_x = (int)random(-25, 25); // random premik za y
        if(y < c2_y-1 && points[y+1][x] != null){
          y++;
          po.addTarget(new PVector(points[y][x].x + rand_x, points[y][x].y));
          point_found = false;
        }else if(y > c2_y-1 && points[y-1][x] != null){
          y--;
          po.addTarget(new PVector(points[y][x].x + rand_x, points[y][x].y));
          point_found = false;
        }
          
      }else if(x != x_dest){
        int rand_y = (int)random(-25, 25); // random premik za x
        if(x < x_dest && points[y][x+1] != null){
          x++;
          po.addTarget(new PVector(points[y][x].x, points[y][x].y + rand_y));
          point_found = false;
        }else if(x > x_dest && points[y][x-1] != null){
          x--;
          po.addTarget(new PVector(points[y][x].x, points[y][x].y + rand_y));
          point_found = false;
        }
      }else if(y != y_dest){
        //int rand_x = (int)random(-25, 25); // random premik za y
        if(y < y_dest && points[y+1][x] != null){
          y++;
          po.addTarget(new PVector(points[y][x].x, points[y][x].y));
          point_found = false;
        }else if(y > y_dest && points[y-1][x] != null){
          y--;
          po.addTarget(new PVector(points[y][x].x, points[y][x].y));
          point_found = false;
        }
      }
    }
    p.setX_Y(x,y);
    p.setTargets(po);
  }
}

void goToP1(Person p, int x, int y){
  LinearPath po = new LinearPath();
  int y_dest = 0;
  int x_dest = 10;
  
  boolean point_found = false;
  if(y == c1_y){
    y++;
  }else if(y == c2_y)
    y--;
    
  po.addTarget(points[y][x]);
  int stage = 0;

  while(!point_found){
    point_found = true;
    if(x != 8 && y != y_dest && stage == 0){
      int rand_y = (int)random(-25, 25); // random premik za y
      if(x < 8 && points[y][x+1] != null){
        x++;
        po.addTarget(new PVector(points[y][x].x, points[y][x].y + rand_y));
        point_found = false;
      }else if(x > 8 && points[y][x-1] != null){
        x--;
        po.addTarget(new PVector(points[y][x].x, points[y][x].y + rand_y));
        point_found = false;
      }   
    }else if(y != 1 && x==8){  
      stage = 1;
      //int rand_x = (int)random(-25, 25); // random premik za y
      if(y < 1 && points[y+1][x] != null){
        y++;
        po.addTarget(new PVector(points[y][x].x, points[y][x].y));
        point_found = false;
      }else if(y > 1 && points[y-1][x] != null){
        y--;
        po.addTarget(new PVector(points[y][x].x, points[y][x].y));
        point_found = false;
      }
    }else if(x != x_dest){
      stage = 2;
      int rand_y = 0;
      if(y != 1)
        rand_y = (int)random(-25, 25); // random premik za x
      if(x < x_dest && points[y][x+1] != null){
        x++;
        po.addTarget(new PVector(points[y][x].x, points[y][x].y + rand_y));
        point_found = false;
      }else if(x > x_dest && points[y][x-1] != null){
        x--;
        po.addTarget(new PVector(points[y][x].x, points[y][x].y + rand_y));
        point_found = false;
      }
    }else if(y != y_dest){
      stage = 3;
      //int rand_x = (int)random(-25, 25); // random premik za y
      if(y < y_dest && points[y+1][x] != null){
        y++;
        po.addTarget(new PVector(points[y][x].x, points[y][x].y));
        point_found = false;
      }else if(y > y_dest && points[y-1][x] != null){
        y--;
        po.addTarget(new PVector(points[y][x].x, points[y][x].y));
        point_found = false;
      }
    }
  }
  p.setX_Y(x,y);
  p.setTargets(po);
}

boolean roundEquals(PVector v1, PVector v2) {
  return (abs(round(v1.x-v2.x)) < 5 && abs(round(v1.y-v2.y)) < 5);
}

void mousePressed(){
  if(b.buttonOver){
    b.switch_onOff();
  }
  if(b2.buttonOver){
    b2.switch_onOff();
    if(!b2.onOff)
    for(int i=0;i<N_PEOPLE_INSIDE;i++){
      if(students.get(i).state!=COLOR_POSITIVE &&students.get(i).state!=COLOR_NPOSITIVE)
      students.get(i).setState(COLOR_NEGATIVE);
    }else
      for(int i=0;i<N_PEOPLE_INSIDE;i++){
        if(students.get(i).vaccinated)
        students.get(i).setState(COLOR_VACCINATED);
    }
  }
  if (b3.buttonOver) {
    b3.switch_onOff();
  }
  if (b4.buttonOver) {
    b4.switch_onOff();
    for(int i=0;i<N_TOTAL_CLASSROOMS;i++) {
      //okna[i].oknGumb.switch_onOff();
      okna[i].oknGumb.onOff=b4.onOff;
      okna[i].stanjeOkna=okna[i].oknGumb.onOff;
      clasrooms.get(i).preveriStanjeOkuzenostiVRazredu();
    }
  }
  for(int i=0; i<N_TOTAL_CLASSROOMS; i++) {
    if (okna[i].oknGumb.buttonOver) {
      okna[i].oknGumb.switch_onOff();
      okna[i].stanjeOkna = !okna[i].stanjeOkna;
      clasrooms.get(i).preveriStanjeOkuzenostiVRazredu();
    }
  }
}

void OkuzenaUcilnica(int i) {
  if((clasrooms.get(i).slabZrak == true && clasrooms.get(i).timerSlabZrak == false) ||
    (clasrooms.get(i).timerSlabZrak == true && okna[i].casPrispetjaOkuzenega+(1000*sekunde) < millis()) ||
    (clasrooms.get(i).slabZrak == false && clasrooms.get(i).timerDoberZrak == true && !(okna[i].casOdspetjaOkuzenega+(1000*sekunde) < millis()))) {
    fill(255, 0, 0, 40);
    noStroke();
    switch(i) {
       case 0: {
           beginShape();
             vertex(1320, 291);vertex(1522, 265);vertex(1537, 389);vertex(1334, 410);
           endShape(CLOSE);
         break;  
       }
       case 1: {
           beginShape();
             vertex(108, 473);vertex(228, 473);vertex(228, 580);vertex(108, 580);
           endShape(CLOSE);
         break;  
       }
       case 2: {
           beginShape();
             vertex(230, 473);vertex(350, 473);vertex(350, 610);vertex(230, 610);
           endShape(CLOSE);
         break;  
       }
       case 3: {
           beginShape();
             vertex(354, 475);vertex(473, 475);vertex(473, 610);vertex(354, 610);
           endShape(CLOSE);
         break;  
       }
       case 4: {
           beginShape();
             vertex(476, 475);vertex(595, 475);vertex(595, 610);vertex(476, 610);
           endShape(CLOSE);
         break;  
       }
       case 5: {
           beginShape();
             vertex(602, 473);vertex(717, 473);vertex(717, 580);vertex(602, 580);
           endShape(CLOSE);
         break;  
       }
       case 6: {
           beginShape();
             vertex(760, 608);vertex(729, 471);vertex(714, 345);vertex(948, 322);vertex(960, 442);vertex(961, 589);
           endShape(CLOSE);
         break;  
       }
       case 7: {
           beginShape();
             vertex(1338, 475);vertex(1458, 475);vertex(1458, 610);vertex(1338, 610);
           endShape(CLOSE);
         break;  
       }
       case 8: {
           beginShape();
             vertex(1458, 471);vertex(1580, 471);vertex(1580, 610);vertex(1458, 610);
           endShape(CLOSE);
         break;  
       }
       case 9: {
           beginShape();
             vertex(1587, 471);vertex(1706, 471);vertex(1706, 610);vertex(1587, 610);
           endShape(CLOSE);
         break;  
       }
       case 10: {
           beginShape();
             vertex(1709, 473);vertex(1828, 473);vertex(1828, 580);vertex(1709, 580);
           endShape(CLOSE);
         break;  
       }
       case 11: {
           beginShape();
             vertex(108, 709);vertex(228, 709);vertex(228, 815);vertex(108, 815);
           endShape(CLOSE);
         break;  
       }
       case 12: {
           beginShape();
             vertex(230, 709);vertex(350, 709);vertex(350, 815);vertex(230, 815);
           endShape(CLOSE);
         break;  
       }
       case 13: {
           beginShape();
             vertex(439, 709);vertex(598, 709);vertex(598, 815);vertex(439, 815);
           endShape(CLOSE);
         break;  
       }
       case 14: {
           beginShape();
             vertex(602, 709);vertex(720, 709);vertex(720, 815);vertex(602, 815);
           endShape(CLOSE);
         break;  
       }
       case 15: {
           beginShape();
             vertex(724, 709);vertex(842, 709);vertex(842, 815);vertex(724, 815);
           endShape(CLOSE);
         break;  
       }
       case 16: {
           beginShape();
             vertex(846, 709);vertex(962, 709);vertex(962, 815);vertex(846, 815);
           endShape(CLOSE);
         break;  
       }
       case 17: {
           beginShape();
             vertex(1220, 709);vertex(1338, 709);vertex(1338, 815);vertex(1220, 815);
           endShape(CLOSE);
         break;  
       }
       case 18: {
           beginShape();
             vertex(1343, 709);vertex(1482, 709);vertex(1482, 815);vertex(1343, 815);
           endShape(CLOSE);
         break;  
       }
       case 19: {
           beginShape();
             vertex(1586, 709);vertex(1705, 709);vertex(1705, 815);vertex(1586, 815);
           endShape(CLOSE);
         break;
       }
       case 20: {
           beginShape();
             vertex(1710, 709);vertex(1827, 709);vertex(1827, 815);vertex(1710, 815);
           endShape(CLOSE);
         break;
       }
     }
     noFill();
  }
}

void draw() {
  if(!b.onOff){
    lp.drawPath();
    
    background(255);
    fill(200);
    noStroke();
    
    image(layers[0], 10, 10);
    loadPixels();

    //assistant.update();
    //assistant.draw();
    for (int i = 0; i < N_TOTAL_ASSISTANTS; i = i+1) {
      assistants.get(i).draw();
    }
    
    for (int i = 0; i < N_TOTAL_PEOPLE_SPAWNED; i = i+1) {
      students.get(i).draw();
    }
    
    for (int i = 0; i < fixedPeople.size(); i = i+1) {
      fixedPeople.get(i).draw();
    }
    
    for(int i=0; i<N_TOTAL_CLASSROOMS; i++) {
       OkuzenaUcilnica(i);
     }
    
    g2.draw(125, 900, N_TOTAL_PEOPLE_SPAWNED, 200, 125);
    g.draw(415, 900, N_TOTAL_PEOPLE_SPAWNED, 200, 125);
    //println(N_TOTAL_PEOPLE_SPAWNED);
    
    c.draw();
    cal.draw();
    l.draw();
    
    update();
    
    textSize(50);
    fill(0);
    text("COVID-19 na FRI", 1030, 100);
    textSize(20);
    fill(0);
    text("Odpri vsa okna", 1770, 940);
    text("Maske", 1625, 940);
    text("Precepljenost:", 1475, 940);
  }
  for(int i=0; i<N_TOTAL_CLASSROOMS; i++) {
       okna[i].oknGumb.draw();
       izrisujVrata();
 }
  b.draw();
  b2.draw();
  b3.draw();
  b4.draw();
  if(b2.onOff){
    ceplenje.draw();
    }
  //r.draw();
  
  if(c.schoolTime){
    INFECTION_CHANCE_MASK = 0.015;
  } else{
    INFECTION_CHANCE_MASK = 0;
  }
}
