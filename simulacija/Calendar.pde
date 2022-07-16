class Calendar{
  int cX, cY;  // Position of button
  int cSize;
  int dX,dY;
  int dan=1;
  Calendar(int x,int y,int size){
    this.cX=x;
    this.cY=y;
    this.cSize=size;
    dX=27*2;
    dY=(int)(60);
  }
  void draw(){
    fill(255);
    stroke(0);
    strokeWeight(2);
    rect (cX, cY, cSize*1.3, cSize*1.4,10); 
    line(cX+10,cY+2*cSize/10+5,cX+cSize*1.2,cY+2*cSize/10+5);
    fill((color(254, 160, 160)));
    noStroke();
    rect(cX+dX+5,cY+dY-2,24,24);
    textSize(20);
    fill(0);
    text("December 2021",cX+20+cSize/2,cY+25);
    textSize(15);
    
    //text("                  01    02    03    04    05 \n06    07    08    09    10    11    12\n13    14    15    16    17    18    19\n20    21    22    23    24    25    26\n27    28    29    30    31                  ",cX+24+cSize/2,cY+75);
    text("01\n08\n15\n22\n29",cX+71,cY+75);
    text("02\n09\n16\n23\n30",cX+98,cY+75);
    text("03\n10\n17\n24\n31",cX+125,cY+75);
    text("04\n11\n18\n25",cX+152,cY+75);
    text("05\n12\n19\n26",cX+179,cY+75);
    text("\n06\n13\n20\n27",cX+17,cY+75);
    text("\n07\n14\n21\n28\n",cX+44,cY+75);
    
    fill((color(128,0,0)));
    //text("P       T       S      Č      P      S      N",cX+24+cSize/2,cY+55);
    text("P",cX+17,cY+55);
    text("T",cX+44,cY+55);
    text("S",cX+71,cY+55);
    text("Č",cX+98,cY+55);
    text("P",cX+125,cY+55);
    text("S",cX+152,cY+55);
    text("N",cX+179,cY+55);
  }
  void spremeniDatum(int day){
    dan=day;
    int pomx=(dan+1)%7;
    int pomy=(dan+1)/7;
    dX=27*pomx;
    dY=(int)(25.5*pomy)+60;
  }

}
