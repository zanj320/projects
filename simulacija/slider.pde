class Slider{  
  float range; //velikost sliderja
  float yrange;//visina sliderja
  float min; float max; float xR;float yR;float value;  
  Slider(float x,float y,float najmn,float najvec,float zacetek,float velikostX,float velikostY){
     xR = x; 
     yR = y;
     min=najmn;
     max=najvec;
     value=zacetek;
     range=velikostX;
     yrange=velikostY;
  }
  
  void draw() {
    if(value < min) {
      value = min;
    } else if(value > max){
      value = max; 
    }

    noStroke();
    fill(COLOR_BACKGROUND);
    rect(xR-20,yR-25,range+30,yrange+50);
    stroke(0);
    strokeWeight(1);
    fill(255,255,255);
    rect(xR,yR,range,yrange,180);  // uno po katerem se premika

    float rX = map(value,min,max,xR - range/2, xR + range/2);

    stroke(47,79,79);
    fill(0,79,79);
    rect(rX+range/2-10,yR-yrange/2,20,yrange*2,6);  //uno k se premika
    
    if(mousePressed) {
      if(mouseX > xR  && mouseX < xR + range) { 
        if(mouseY > yR - yrange*2 && mouseY < yR + yrange*2) { 
            value = map(mouseX,xR,xR + range,min,max); 
          }
        }
    }
  
    textSize(yrange*2);
    fill(0);
    text(floor(value)+"%", xR+range/2, yR-yrange);
  }
  
  int value(){
    return floor(value);
  }
}
