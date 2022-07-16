class LinearPath {
  ArrayList<PVector> targets = new ArrayList<PVector>();

  LinearPath(ArrayList<PVector> ts) {
    this.targets = ts;
  }
  
  LinearPath() {}
  
  void addTargets(ArrayList<PVector> ts){
    for (PVector t : ts) {
      this.targets.add(t);
    }
  }

  void addTarget(PVector t) {
    this.targets.add(t);
  }

  void removeLastTarget() {
    if (pathSize() > 0) this.targets.remove(this.targets.size()-1);
  }

  void removeFirstTarget() {
    if (pathSize() > 0) this.targets.remove(0);
  }
  
  void removeAllTargets(){
    targets.clear();
  }

  int pathSize() {
    return this.targets.size();
  }

  PVector getFirst() {
    return this.targets.get(0);
  }

  void drawPath() {
    PVector prev = this.targets.get(0);
    for (PVector t : this.targets ) {
      noFill();
      stroke(255, 0, 0);
      circle(t.x, t.y, 15);
      line(prev.x, prev.y, t.x, t.y);
      prev = t;
    }
  }

  void printTargets() {
    for (PVector t : this.targets) {
      print("("+t.x+", "+t.y+")\n");
    }
  }
  
  ArrayList<PVector> reversedList(){
    
    ArrayList<PVector> rev_ts = new ArrayList<PVector>();
    for(int i=this.targets.size()-1; i>=0; i--){
      rev_ts.add(this.targets.get(i));
    }
    
    return rev_ts;
  }
}
