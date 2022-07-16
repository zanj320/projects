int N_HISTORY = 1000;

class Graph {
  float[] datapoints;
  int current_index;
  color clr;
  
  Graph(color c) {
    datapoints = new float[N_HISTORY];
    for (int i = 0; i < N_HISTORY; i = i+1) {
      datapoints[i] = 0;
    }
    current_index = 0;
    clr = c;
  }

  void update(float d) {
    datapoints[current_index] = d;
    current_index = current_index + 1;
    if (current_index >= N_HISTORY) {
      current_index = 0;
    }
  }

  void draw(int x, int y, float max_y, int w, int h) {
    pushMatrix();
    translate(x-15, y + h); // set offset for plotting the graph
    scale(1.0, -1.0); // flip y axis to plot properly
    
    stroke(0);
    strokeWeight(2);
    line(-0.05*w, 0, 1.05*w, 0); // plot coordinate system
    line(1.05*w, 0, 1.05*w-6, -5);
    line(1.05*w, 0, 1.05*w-6, 5);
    line(0, -0.05*h, 0, 1.05*h);
    line(0, 1.05*h, 0-5, 1.05*h-6);
    line(0, 1.05*h, 0+5, 1.05*h-6);
    
    stroke(clr);
    strokeWeight(4);
    //int i = current_index+1;
    //while(current_index - (i % N_HISTORY) != 1) {
    fill(color(0));
    textSize(16);
    for (int i = 1; i < N_HISTORY; i = i+1) {
      
      //int i = j % N_HISTORY;
      //print(i);
      float data_0;
      float data_1;
      
      data_0 = (datapoints[(current_index + (i-1)) % N_HISTORY] / max_y) * h;
      data_1 = (datapoints[(current_index + (i)) % N_HISTORY] / max_y) * h;   
      
      float x_0 = (float)(i-1) / (float)(N_HISTORY) * w;
      float x_1 = (float)(i) / (float)(N_HISTORY) * w;
      
      if (data_0 > 0.01 && data_1 > 0.01) {
        line(x_0, data_0, x_1, data_1);
      }
      
      if (i == N_HISTORY-1) {
        pushMatrix();
        scale(1.0, -1.0);
        text(str(datapoints[(current_index + (i)) % N_HISTORY]), w, (h-data_1)-h);
        popMatrix();
      }
    }
    popMatrix();
  }
}
