class Legend{
  int x,y;
  int sizeX,sizeY;
  int steviloStanj=7;
  int velikostKroga=10; //15
  
  Legend(int x,int y){
    this.x=x;
    this.y=y;
    sizeX=325;
    sizeY=250;
  }
  
  void draw() {
    stroke(color(0));
    fill(255);
    rect (x,y,sizeX,sizeY+5,10); 
    textSize(20); //23.5
    fill(0);
    text("Legenda:",x + 65,y+30);
    int x_odmik = 50;
    
    noFill();
    strokeWeight(4);
    strokeCap(PROJECT);
    stroke(COLOR_POSITIVE);
    arc(x+x_odmik, y+20+sizeY/steviloStanj, velikostKroga*2, velikostKroga*2, -QUARTER_PI,QUARTER_PI );
    stroke(COLOR_NEGATIVE);
    arc(x+x_odmik, y+20+2*sizeY/steviloStanj, velikostKroga*2, velikostKroga*2, -QUARTER_PI,QUARTER_PI );
    stroke(COLOR_VACCINATED);
    arc(x+x_odmik, y+20+3*sizeY/steviloStanj, velikostKroga*2, velikostKroga*2, -QUARTER_PI,QUARTER_PI );
    stroke(COLOR_NPOSITIVE);
    arc(x+x_odmik, y+20+4*sizeY/steviloStanj, velikostKroga*2, velikostKroga*2, -QUARTER_PI,QUARTER_PI );
    stroke(COLOR_HAS_MASK);
    arc(x+x_odmik, y+20+5*sizeY/steviloStanj, velikostKroga*2, velikostKroga*2, -QUARTER_PI,QUARTER_PI );
    stroke(COLOR_FIXED_PERSON);
    arc(x+x_odmik, y+20+6*sizeY/steviloStanj, velikostKroga*2, velikostKroga*2, -QUARTER_PI,QUARTER_PI );
    
    noStroke();
    fill(COLOR_POSITIVE);
    circle(x+x_odmik, y+20+sizeY/steviloStanj, velikostKroga);
    fill(COLOR_NEGATIVE);
    circle(x+x_odmik, y+20+2*sizeY/steviloStanj, velikostKroga);
    fill(COLOR_VACCINATED);
    circle(x+x_odmik, y+20+3*sizeY/steviloStanj, velikostKroga);
    fill(COLOR_NPOSITIVE);
    circle(x+x_odmik, y+20+4*sizeY/steviloStanj, velikostKroga);
    fill(COLOR_HAS_MASK);
    circle(x+x_odmik, y+20+5*sizeY/steviloStanj, velikostKroga);
    fill(COLOR_FIXED_PERSON);
    circle(x+x_odmik, y+20+6*sizeY/steviloStanj, velikostKroga);
    
    textSize(20); //20
    fill(0);
    
    text("-pozitiven",x + x_odmik - 20 + 93,y+27+sizeY/steviloStanj);
    text("-negativen",x + x_odmik - 20 + 95,y+27+2*sizeY/steviloStanj);
    text("-cepljen",x + x_odmik - 20 + 82,y+27+3*sizeY/steviloStanj);
    text("-pozitiven, a ne prenaša",x + x_odmik - 20 + 160,y+27+4*sizeY/steviloStanj);
    text("-asistent",x + x_odmik - 20 + 87,y+27+5*sizeY/steviloStanj);
    text("-zaposleni",x + x_odmik - 20 + 95,y+27+6*sizeY/steviloStanj);
  }
}
