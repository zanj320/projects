class Button{
  int bX, bY;  // Position of button
  float odmikX=10;
  int bSize;
  float pomozna;
  //float razmerje=2;
  color bColor;
  color bHighlight;
  color currColor;
  color strokeColor;
  boolean buttonOver = false;
  boolean onOff=false;
  PImage imgOn;
  PImage imgOff;
  
  Button(int x,int y,int velikost){
    bColor = color(160, 175, 182);
    bHighlight = color(120,144,156);
    strokeColor=color(69, 90, 100);
    bX = x;
    bY = y;
    bSize = velikost;
    imgOff = loadImage("neceplen.png");
    imgOn = loadImage("ceplen.png");
    
    pomozna=bSize*0.03;
  }
  void spremeniRazmerje(float n){
    odmikX=n;
  }
  
  void spremeniBarvoGumba(color a,color b,color c ){
    bColor = a;
    bHighlight = b;
    strokeColor=c;
  }
  void nastaviSlike(String slikaOn, String slikaOff){
    imgOff = loadImage(slikaOff);
    imgOn = loadImage(slikaOn);
  }
  
  void switch_onOff(){
    onOff=!onOff;
  }
  
  void draw() {
    buttonOver = overButton(bX, bY, bSize);
    noStroke();
    fill(COLOR_BACKGROUND);
    rect (bX-bSize*0.1, bY-bSize*0.1, bSize*1.2, bSize*1.2); 
    stroke(strokeColor);
    strokeWeight(2);
    if (buttonOver) {
      currColor=bHighlight;
      pomozna=bSize*0.03;
      fill(0);
    }
    else{
      currColor=bColor;
      pomozna=0;
    }
      fill(currColor);
      rect(bX-pomozna, bY-pomozna, bSize+pomozna*2, bSize+pomozna*2,bSize/5);
    
    if(onOff)
      image(imgOff, bX+odmikX-pomozna, bY+odmikX-pomozna,bSize-(odmikX*2)+pomozna*2,bSize-(odmikX*2)+pomozna*2);
    
    else
      image(imgOn, bX+odmikX-pomozna, bY+odmikX-pomozna,bSize-(odmikX*2)+pomozna*2,bSize-(odmikX*2)+pomozna*2);   

  }  
  boolean overButton(int x, int y, int sirvis) {
    return (mouseX >= x && mouseX <= x+(sirvis) && 
      mouseY >= y && mouseY <= y+sirvis);  
  }
}
