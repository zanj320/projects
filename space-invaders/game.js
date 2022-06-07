class Player {
	constructor(x, y, imageSource){
		this.x = x;
		this.y = y;
		this.ship = new Image();
		this.ship.src = imageSource;
	}
}

class Bullet{
	constructor(x, y, imageSource){
		this.x = x;
		this.y = y;
		this.bullet = new Image();
		this.bullet.src = imageSource;
	}
}

class Enemy{
	constructor(x, y, imageSource){
		this.x = x;
		this.y = y;
		this.alien = new Image();
		this.alien.src = imageSource;
	}
}

class Crate{
	constructor(x, y, imageSource){
		this.x = x;
		this.y = y;
		this.crate = new Image();
		this.crate.src = imageSource;
	}
}

class Helper{
	constructor(x, y, imageSource){
		this.x = x;
		this.y = y;
		this.helper = new Image();
		this.helper.src = imageSource;
	}
}

let canvas;
let ctx;
let buffer;

let xx=3;

let pause=false;
let stevec=0;

let dir=0;
let dir1=0;

let st_metkovrdecega=50;
let st_tockrdecega=0;

let st_metkovmodrega=50;
let st_tockmodrega=0;

let player;
let player1;

let pomagac;
let preverisuznja_rdec=false;
let preverisuznja_moder=false;
let suzenj=0;
let preveripomagac=false;

let drop;
let preveridrop=false;
let izbris=false;

let streljanje_rdecega=true;
let streljanje_modrega=true;

let zacetek=false;
let konec=false;

let randcrate = Math.floor(Math.random() * 41) + 40;

let bullets = [];
let bullets1 = [];

let enemies = [];

let slika = new Image();
slika.src = "odzadje.png";

let h2 = document.createElement("h2");
h2.style="text-align: center";

function initElements() {
	//nardi canvas
	canvas = document.createElement("canvas");

	canvas.width = 700;
	canvas.height = 600;
	
	ctx = canvas.getContext("2d");
	buffer = canvas.getContext("2d");
	
	//nardi prvi division
	div = document.createElement("div");
	div.className = "div_prvi";
	
	document.body.appendChild(div);
	div.innerHTML = "Statistika rdečega";
	
	table = document.createElement("table");
	div.appendChild(table);	

	tr = document.createElement("tr");
	tr1 = document.createElement("tr");
	
	table.appendChild(tr);
	table.appendChild(tr1);	
	
	td = document.createElement("td");
	td1 = document.createElement("td");
	td2 = document.createElement("td");
	td3 = document.createElement("td");
	
	tr.appendChild(td);
	tr.appendChild(td1);
	tr1.appendChild(td2);
	tr1.appendChild(td3);
	
	td.innerHTML = "Metki";
	td2.innerHTML = "Točke";
	
	//nardi drugi division
	div1 = document.createElement("div");
	div1.className = "div_drugi";
	
	document.body.appendChild(div1);
	div1.innerHTML = "Statistika modrega";
	
	table1 = document.createElement("table");
	div1.appendChild(table1);
	
	tr2 = document.createElement("tr");
	tr3 = document.createElement("tr");
	
	table1.appendChild(tr2);
	table1.appendChild(tr3);
	
	td4 = document.createElement("td");
	td5 = document.createElement("td");
	td6 = document.createElement("td");
	td7 = document.createElement("td");
	
	tr2.appendChild(td4);
	tr2.appendChild(td5);
	tr3.appendChild(td6);
	tr3.appendChild(td7);
	
	td4.innerHTML = "Metki";
	td6.innerHTML = "Točke";
	
	//za scoreboard
	p_red = document.createElement("p");
	p_red.innerHTML = "left: a | right: d | shoot: w | reload: r";
	div.appendChild(p_red);
	
	p_blue = document.createElement("p");
	p_blue.innerHTML = "left: ← | right: → | shoot: ↑ | reload: m";
	div1.appendChild(p_blue);
	
	//h2 za pavzo, zmago, zgubo
	document.body.appendChild(canvas);
	
	document.body.appendChild(h2);
	odstevanje();
}

//doda background canvasu
function drawBackground() {
	ctx.drawImage(slika,0,0,700,600);
}

//drawa playerja(ladji) na trenutni lokaciji
function drawPlayer() {
	buffer.drawImage(player.ship, player.x-19, player.y-18, 35, 42);
	buffer.drawImage(player1.ship, player1.x-19, player1.y-18, 35, 42);
}

function move_p() {
	//movement rdec
	if (dir==1) {
		if (player.x>25) {
			player.x-=2.4;
			if (preverisuznja_rdec==true)
				pomagac.x-=2.4;
		}
	}
	else if (dir==2) {
		if (preverisuznja_rdec==false) {
			if (player.x<canvas.width-23)
				player.x+=2.4;
		}
		else {
			if (player.x<canvas.width-45) {
				player.x+=2.4;
				pomagac.x+=2.4;
			}
		}
	}
	
	//movement moder
	if (dir1==1) {
		if (player1.x>25) {
			player1.x-=2.4;
			if (preverisuznja_moder==true)
				pomagac.x-=2.4;
		}
	}
	else if (dir1==2) {
		if (preverisuznja_moder==false) {
			if (player1.x<canvas.width-23)
				player1.x+=2.4;
		}
		else {
			if (player1.x<canvas.width-45) {
				player1.x+=2.4;
				pomagac.x+=2.4;
			}
		}
	}
}

//spawna crate
function spawnCrate() {
	let nakljucnox = Math.floor(Math.random() * 601) + 50;
	let nakljucnoy = Math.floor(Math.random() * 101) + 400;
	drop = new Crate(canvas.width-nakljucnox, canvas.height-nakljucnoy, "crate.png");
}

//drawa crate & ustvari pomagaca
function drawCrate() {
	buffer.drawImage(drop.crate, drop.x, drop.y, 35, 35);
	drop.y+=2;
	
	if (((player.x>=drop.x) && (player.x<=drop.x+35)) && ((player.y>=drop.y) && (player.y<=drop.y+35))){
		izbris=true;		
		delete drop;
		if (preveripomagac==false) {
			pomagac = new Helper(player.x+35, player.y+15, "pomagac.png");
			st_metkovrdecega+=10;
			preveripomagac=true;
		}
		suzenj=1;
	}

	if (((player1.x>=drop.x) && (player1.x<=drop.x+35)) && ((player1.y>=drop.y) && (player1.y<=drop.y+35))){
		izbris=true;		
		delete drop;
		if (preveripomagac==false) {
			pomagac = new Helper(player1.x+35, player1.y+15, "pomagac.png");
			st_metkovmodrega+=10;
			preveripomagac=true;
		}
		suzenj=2;
	}
	
	//deleta drop ce gre izven canvasa
	if (drop.y>=600) {
		izbris=true;
		delete drop;
	}
}

//drawa pomagaca
function drawHelper() {
	if (suzenj==1) {
		buffer.drawImage(pomagac.helper, pomagac.x-19, pomagac.y-18, 30, 30);
		preverisuznja_rdec=true;
	}
	else if (suzenj==2) {
		buffer.drawImage(pomagac.helper, pomagac.x-19, pomagac.y-18, 30, 30);
		preverisuznja_moder=true;
	}
}

//spawna enemije
function spawnEnemies() {
	let x_pom=40;
	let y_pom=10;
	for(let i=0; i<96; i++){
		enemy = new Enemy(x_pom, y_pom, "enemy.png");
		enemies[i]=enemy;
		if(x_pom>600){
			x_pom=40;
			y_pom+=30;
		}
		else
			x_pom+=40;
	}
}

//narise enemije
function drawEnemies() {
	for(let i=0; i<enemies.length; i++)
		buffer.drawImage(enemies[i].alien, enemies[i].x, enemies[i].y, 20, 20);
}

//premik enemijov
function move_e() {
	for(let i=0; i<enemies.length; i++){
		enemies[i].y+=0.3;
	}
}

function updateBullets() {
	//updata vse bulete
	for(let i = 0; i < bullets.length; i++){
		bullets[i].y -= 3;
			for(let j=0; j<enemies.length; j++){
				if((bullets[i].x>=enemies[j].x && bullets[i].x<=enemies[j].x+20) 
											&& 
					(bullets[i].y>=enemies[j].y && bullets[i].y<=enemies[j].y+20)){
					enemies.splice(j, 1);
					bullets.splice(i, 1);
					st_tockrdecega = st_tockrdecega+5;
					return;
			}
		}	
		
	//ce grejo metki izven canvasa jih izbrise iz tabele
	if(bullets[i].y <= 0)
		bullets.splice(i, 1);
	}

	for(let i = 0; i < bullets1.length; i++){
		bullets1[i].y -= 3;
			for(let j=0; j<enemies.length; j++){
				if((bullets1[i].x>=enemies[j].x && bullets1[i].x<=enemies[j].x+20) 
											&& 
					(bullets1[i].y>=enemies[j].y && bullets1[i].y<=enemies[j].y+20)){
					enemies.splice(j, 1);
					bullets1.splice(i, 1);
					st_tockmodrega = st_tockmodrega+5;
					return;
			}
		}	
		
		if(bullets1[i].y <= 0)
			bullets1.splice(i, 1);
	}
}

//za bullete rdecga
function drawBullets() {
	//ce je tabela buletov prazna kipa to funkcijo
	if(bullets.length == 0)
		return;

	//drawa bullete
	for(let i = 0; i < bullets.length; i++){
		buffer.beginPath();
		buffer.drawImage(bullets[i].bullet, bullets[i].x-11, bullets[i].y-28, 20, 20);		
	}

	//updata bullete
	updateBullets();
}

//za bullete modrga
function drawBullets1() {
	if (bullets1.length == 0)
		return;
	
	for (let i=0; i<bullets1.length; i++) {
		buffer.beginPath();
		buffer.drawImage(bullets1[i].bullet, bullets1[i].x-11, bullets1[i].y-28, 20, 20)
	}
	
	updateBullets();
}

//collision da zgubiš
function izgubi() {
	for(let i = 0; i < enemies.length; i++){
		if (enemies[i].y>=600 || ((player.x>=enemies[i].x && player.x<=enemies[i].x+20) && (player.y>=enemies[i].y && player.y<=enemies[i].y+20)) ||
		((player1.x>=enemies[i].x && player1.x<=enemies[i].x+20) && (player1.y>=enemies[i].y && player1.y<=enemies[i].y+20))) {
			h2.innerHTML = "Zgubila sta! Press SPACE to restart!";				
			pause=true;
			konec=true;
		}
	}
}

//za zmago/izenačenje
function zmagaj() {
	pause = true;
	konec=true;
	if (st_tockmodrega>st_tockrdecega)
		h2.innerHTML = "Zmaga modrega! Press SPACE to restart!";
	else if (st_tockmodrega<st_tockrdecega)
		h2.innerHTML = "Zmaga rdečega! Press SPACE to restart!";
	else
		h2.innerHTML = "Izenačeno! Press SPACE to restart!";
}

//funkcija za odstevanje za zacetek
function odstevanje() {
	pause=true;
	
	let pom = setInterval(function() {
		if (xx>0) {
			h2.innerHTML="Začetek čez: "+xx;		
			xx--;
		}
		else if (xx==0) {
			h2.innerHTML="";
			clearInterval(pom);
		}
	},1000);
}

//statistika igralcev (točke modrega še ne delajo)
function scoreboard() {
	td1.innerHTML = st_metkovrdecega;
	td3.innerHTML = st_tockrdecega;
	
	td5.innerHTML = st_metkovmodrega;
	td7.innerHTML = st_tockmodrega;
}

//za premik
function playerInput(e) {
	console.log(e.keyCode);
	
	if (pause==false) {
		//"a"
		if (e.keyCode == "65") {
			dir=1;
		}
		//"d"
		else if (e.keyCode == "68") {
			dir=2;
		}

		//"left"
		if (e.keyCode == "37") {
			dir1=1;
		}
		//"right"
		else if (e.keyCode == "39") {
			dir1=2;
		}
	}
}

//za premik brez spamanja
function inputp1(e) {
	if (pause==false) {
		
		//"w"
		if (e.keyCode == "87" && streljanje_rdecega==true) {
			if (st_metkovrdecega>0) {
				bullets.push(new Bullet(player.x, player.y, "metek1.png"));
				if (preverisuznja_rdec==true) {
					bullets.push(new Bullet(pomagac.x, pomagac.y, "metek3.png"));
						st_metkovrdecega-=2;
						if (st_metkovrdecega==1)
							st_metkovrdecega=0;
				}
				else
					st_metkovrdecega--;	
				updateBullets();
			}
		}
	
		//"up"
		if (e.keyCode == "38" && streljanje_modrega==true) {
			if (st_metkovmodrega>0) {
				bullets1.push(new Bullet(player1.x, player1.y, "metek2.png"));
				if (preverisuznja_moder==true) {
					bullets1.push(new Bullet(pomagac.x, pomagac.y, "metek3.png"));
						st_metkovmodrega-=2;
						if (st_metkovmodrega==1)
							st_metkovmodrega=0;
				}
				else
					st_metkovmodrega--;
				updateBullets();
			}
		}
		
		//reload metke rdecega
		if (e.keyCode == "82") {
			streljanje_rdecega=false;
			setTimeout(function() {
				if (preverisuznja_rdec==true)
					st_metkovrdecega=60;
				else
					st_metkovrdecega=50;
				
				streljanje_rdecega=true;
			},1500);
		}
		//reload metke modrega
		if (e.keyCode == "77") {
			streljanje_modrega=false;
			setTimeout(function() {
				if (preverisuznja_moder==true)
					st_metkovmodrega=60;
				else
					st_metkovmodrega=50;
				
				streljanje_modrega=true;
			},1500);
		}
	}
	
	//pavzera igro s p-jem
	if (e.keyCode == "80") {
		stevec++;
		if (stevec%2==0)
			pause=false;
		else
			pause=true;
	}
	
	//reloada page
	if (e.keyCode == "32") {
		window.location.reload();
	}
}

//kliče vsak frame
function draw() {
	drawBackground();
	drawPlayer();	
	drawEnemies();	
	drawHelper();
	scoreboard();
	
	if (pause == false) {
		drawBullets();
		drawBullets1();
		move_e();
		move_p();		
		
		// za spawnanje crata
		if (enemies.length==randcrate && preveridrop==false) {
			spawnCrate();
			preveridrop=true;
		}
		
		//za draw crate
		if (preveridrop==true && izbris==false) {
			drawCrate();
		}
	}
	
	//zmaga
	if (st_tockmodrega+st_tockrdecega==480)
		zmagaj();
	//zguba
	else 
		izgubi();
	
	//pavza
	if (pause==true && zacetek==true && konec==false)
		h2.innerHTML = "PAVZA!"
	else if (pause==false && zacetek==true && konec==false)
		h2.innerHTML = "";
	
	window.requestAnimationFrame(draw);
}

function init() {
	document.addEventListener('keydown', playerInput);
	document.addEventListener('keyup', inputp1);
	initElements(); 
	
	player = new Player(canvas.width-600, canvas.height-30, "ship1.png");
	player1 = new Player(canvas.width-100, canvas.height-30, "ship2.png");
	
	//starta game
	draw();
	setTimeout(function() {
		spawnEnemies();
		pause=false;
		zacetek=true;
	},4000);
}
