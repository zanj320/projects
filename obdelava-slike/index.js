let canvas = document.getElementsByTagName('canvas')[0];
let ctx = canvas.getContext("2d");
let img = new Image();

let imgData;
let data;
let tab;

let prejsna=[];

function LoadImage() {
   img.src = prompt("Lokacija slike: slika_motor.jpg", "slika_motor.jpg");
   // img.src = "slika_motor.jpg";
  
   img.onload = function () {
      canvas.width = img.width;
      canvas.height = img.height;
      ctx.drawImage(img, 0, 0, img.width, img.height);
      imgData = ctx.getImageData(0, 0, img.width, img.height);
      data = imgData.data;
      tab = data;
      console.log(data);
      for (let i=0; i<data.length; i++) {
         prejsna[i] = data[i];
      }
   }
}

function Posivinji() {
   for (let i=0; i<data.length; i++) {
      prejsna[i] = data[i];
   }
   
   for(let y = 0; y < imgData.height; y++) {
      for(let x = 0; x < imgData.width; x++) {
         let i = (y * 4) * imgData.width + x * 4;

         let avg = (imgData.data[i] + imgData.data[i + 1] + imgData.data[i + 2]) / 3;
         imgData.data[i] = avg; 
         imgData.data[i + 1] = avg; 
         imgData.data[i + 2] = avg;
      }
   }
   ctx.putImageData(imgData, 0, 0);
}

function OdstraniBarvo(barva) {
   for (let i=0; i<data.length; i++) {
      prejsna[i] = data[i];
   }
   
   for(let y = 0; y < imgData.height; y++) {
      for(let x = 0; x < imgData.width; x++) {
         let i = (y * 4) * imgData.width + x * 4;

         if (barva == 'red') {
            imgData.data[i] = 0;
         }
         else if (barva == 'green') {
            imgData.data[i+1] = 0;
         }
         else {
            imgData.data[i+2] = 0;
         }
      }
   }
   ctx.putImageData(imgData, 0, 0);
}

function PoudariBarvo(barva) {
   for (let i=0; i<data.length; i++) {
      prejsna[i] = data[i];
   }
   
   for(let y = 0; y < imgData.height; y++){
       for(let x = 0; x < imgData.width; x++){
            let i = (y * 4) * imgData.width + x * 4;

            if (barva == 'red') {
               imgData.data[i] = 255;
            }
            else if (barva == 'green') {
               imgData.data[i+1] = 255;
            }
            else {
               imgData.data[i+2] = 255;
            }
       }
   }
   ctx.putImageData(imgData, 0, 0);
}

function Svetlost() {
   for (let i=0; i<data.length; i++) {
      prejsna[i] = data[i];
   }
   
	let pom = document.getElementById('svetlost1').value*0.07;
   for(let y = 0; y < imgData.height; y++) {
      for(let x = 0; x < imgData.width; x++) {
         let i = (y * 4) * imgData.width + x * 4;

         imgData.data[i] += pom;
         imgData.data[i + 1] += pom; 
         imgData.data[i + 2] += pom;
      }
   }
   ctx.putImageData(imgData, 0, 0);
}

function ThresholdNavadna() {
   for (let i=0; i<data.length; i++) {
      prejsna[i] = data[i];
   }
   
   for(let y = 0; y < imgData.height; y++) {
      for(let x = 0; x < imgData.width; x++) {
         let i = (y * 4) * imgData.width + x * 4;

         if (imgData.data[i] > 155) {
            imgData.data[i] = 255;
            imgData.data[i+1] = 255;
            imgData.data[i+2] = 255;
         }
         else {
            imgData.data[i] = 0;
            imgData.data[i+1] = 0;
            imgData.data[i+2] = 0;
         }
      }
   }
   ctx.putImageData(imgData, 0, 0);
}

function ThresholdPoljubna() {
   for (let i=0; i<data.length; i++) {
      prejsna[i] = data[i];
   }

	let pom = document.getElementById('treshold1').value;
   for(let y = 0; y < imgData.height; y++) {
      for(let x = 0; x < imgData.width; x++) {
         let i = (y * 4) * imgData.width + x * 4;

         if (imgData.data[i] < pom)
            imgData.data[i] = 0;

         if (imgData.data[i+1] < pom)
            imgData.data[i+1] = 0;

         if (imgData.data[i+2] < pom)
            imgData.data[i+2] = 0;
      }
   }
   ctx.putImageData(imgData, 0, 0);
}

function NajdiRoboveLaplac() {
   for (let i=0; i<data.length; i++) {
      prejsna[i] = data[i];
   }

   Posivinji();
   for(let i = 0; i < img.height; i++) {
      for(let j = 4; j < img.width * 4 - 4; j++) {
         if(j % 4 != 3) {
            if(((((i-1) * img.width * 4) + (j-4)) >= 0) && ((((i+1) * img.width * 4) + (j+4)) < data.length)) {
               data[(i * img.width * 4)+j] = (
                  tab[((i-1) * img.width * 4) + (j-4)] * (1)  +
                  tab[((i-1) * img.width * 4) +   (j)] * (1)  +
                  tab[((i-1) * img.width * 4) + (j+4)] * (1)  +
                  tab[    (i * img.width * 4) + (j-4)] * (1)  +
                  tab[    (i * img.width * 4) +   (j)] * (-4) +
                  tab[    (i * img.width * 4) + (j+4)] * (1)  + 
                  tab[((i+1) * img.width * 4) + (j-4)] * (1)  +
                  tab[((i+1) * img.width * 4) +   (j)] * (1)  +
                  tab[((i+1) * img.width * 4) + (j+4)] * (1)
               ) * (1/8);
            }
         }
      }
   }
   ctx.putImageData(imgData, 0, 0);

   /*
                 -1     -1     -1

      -1/6   *   -1      8     -1
            
                 -1     -1     -1

                        ali

                1      1      1

      1/8   *   1     -4      1
            
                1      1      1
   */
}

function NajdiRoboveSobelV() {
   for (let i=0; i<data.length; i++) {
      prejsna[i] = data[i];
   }

   Posivinji();
   for(let i = 0; i < img.height; i++) {
      for(let j = 4; j < img.width * 4 - 4; j++) {
         if(j % 4 != 3) {
            if(((((i-1) * img.width * 4) + (j-4)) >= 0) && ((((i+1) * img.width * 4) + (j+4)) < data.length)) {
               data[(i * img.width * 4)+j] = (
                  tab[((i-1) * img.width * 4) + (j-4)] * (1)  +
                  tab[((i-1) * img.width * 4) +   (j)] * (2)  +
                  tab[((i-1) * img.width * 4) + (j+4)] * (1)  +
                  tab[    (i * img.width * 4) + (j-4)] * (0)  +
                  tab[    (i * img.width * 4) +   (j)] * (0)  +
                  tab[    (i * img.width * 4) + (j+4)] * (0)  + 
                  tab[((i+1) * img.width * 4) + (j-4)] * (-1) +
                  tab[((i+1) * img.width * 4) +   (j)] * (-2) +
                  tab[((i+1) * img.width * 4) + (j+4)] * (-1)
               ) * (-1);
            }
         }
      }
   }
   ctx.putImageData(imgData, 0, 0);

   /*
               1      2      1

               0      0      0
         
              -1     -2     -1
   */
}

function NajdiRoboveSobelH() {
   for (let i=0; i<data.length; i++) {
      prejsna[i] = data[i];
   }
   
   Posivinji();
   for(let i = 0; i < img.height; i++) {
      for(let j = 4; j < img.width * 4 - 4; j++) {
         if(j % 4 != 3) {
            if(((((i-1) * img.width * 4) + (j-4)) >= 0) && ((((i+1) * img.width * 4) + (j+4)) < data.length)) {
               data[(i * img.width * 4)+j] = (
                  tab[((i-1) * img.width * 4) + (j-4)] * (-1) +
                  tab[((i-1) * img.width * 4) +   (j)] * (0)  +
                  tab[((i-1) * img.width * 4) + (j+4)] * (1)  +
                  tab[    (i * img.width * 4) + (j-4)] * (-2) +
                  tab[    (i * img.width * 4) +   (j)] * (0)  +
                  tab[    (i * img.width * 4) + (j+4)] * (2)  + 
                  tab[((i+1) * img.width * 4) + (j-4)] * (-1) +
                  tab[((i+1) * img.width * 4) +   (j)] * (0)  +
                  tab[((i+1) * img.width * 4) + (j+4)] * (1)
               ) * (-1);
            }
         }
      }
   }
   ctx.putImageData(imgData, 0, 0);

   /*
              -1      0      1

              -2      0      2
         
              -1      0      1
   */
}

function Blurr() {
   for (let i=0; i<data.length; i++) {
      prejsna[i] = data[i];
   }
   
   for(let i = 0; i < img.height; i++) {
      for(let j = 4; j < img.width * 4 - 4; j++) {
         if(j % 4 != 3) {
            if(((((i-1) * img.width * 4) + (j-4)) >= 0) && ((((i+1) * img.width * 4) + (j+4)) < data.length)) {
               data[(i * img.width * 4)+j] = (
                  tab[((i-1) * img.width * 4) + (j-4)] * (1/16) +
                  tab[((i-1) * img.width * 4) +   (j)] * (1/8)  +
                  tab[((i-1) * img.width * 4) + (j+4)] * (1/16) +
                  tab[    (i * img.width * 4) + (j-4)] * (1/8)  +
                  tab[    (i * img.width * 4) +   (j)] * (1/4)  +
                  tab[    (i * img.width * 4) + (j+4)] * (1/8)  + 
                  tab[((i+1) * img.width * 4) + (j-4)] * (1/16) +
                  tab[((i+1) * img.width * 4) +   (j)] * (1/8)  +
                  tab[((i+1) * img.width * 4) + (j+4)] * (1/16)
               );
            }
         }
      }
   }
   ctx.putImageData(imgData, 0, 0);

   /*
            1/16     1/8     1/16

            1/8      1/4     1/8
            
            1/16     1/8     1/16
   */
}

function Sharpen() {
   for (let i=0; i<data.length; i++) {
      prejsna[i] = data[i];
   }

   for(let i = 0; i < img.height; i++) {
      for(let j = 4; j < img.width * 4 - 4; j++) {
         if(j % 4 != 3) {
            if(((((i-1) * img.width * 4) + (j-4)) >= 0) && ((((i+1) * img.width * 4) + (j+4)) < data.length)) {
               data[(i * img.width * 4)+j] = (
                  tab[((i-1) * img.width * 4) + (j-4)] * (0)  +
                  tab[((i-1) * img.width * 4) +   (j)] * (-1) +
                  tab[((i-1) * img.width * 4) + (j+4)] * (0)  +
                  tab[    (i * img.width * 4) + (j-4)] * (-1) +
                  tab[    (i * img.width * 4) +   (j)] * (8)  +
                  tab[    (i * img.width * 4) + (j+4)] * (-1) + 
                  tab[((i+1) * img.width * 4) + (j-4)] * (0)  +
                  tab[((i+1) * img.width * 4) +   (j)] * (-1) +
                  tab[((i+1) * img.width * 4) + (j+4)] * (0)
               ) * (1/4);
            }
         }
      }
   }
   ctx.putImageData(imgData, 0, 0);

   /*
                 0     -1      0

      1/4   *   -1      8     -1
            
                 0     -1      0
   */
}

function BoxFilter() {
   for (let i=0; i<data.length; i++) {
      prejsna[i] = data[i];
   }

   for(let i = 0; i < img.height; i++) {
      for(let j = 4; j < img.width * 4 - 4; j++) {
         if(j % 4 != 3) {
            if(((((i-1) * img.width * 4) + (j-4)) >= 0) && ((((i+1) * img.width * 4) + (j+4)) < data.length)) {
               data[(i * img.width * 4)+j] = (
                  tab[((i-1) * img.width * 4) + (j-4)] * (1) +
                  tab[((i-1) * img.width * 4) +   (j)] * (1) +
                  tab[((i-1) * img.width * 4) + (j+4)] * (1) +
                  tab[    (i * img.width * 4) + (j-4)] * (1) +
                  tab[    (i * img.width * 4) +   (j)] * (1) +
                  tab[    (i * img.width * 4) + (j+4)] * (1) + 
                  tab[((i+1) * img.width * 4) + (j-4)] * (1) +
                  tab[((i+1) * img.width * 4) +   (j)] * (1) +
                  tab[((i+1) * img.width * 4) + (j+4)] * (1)
               ) * (1/9);
            }
         }
      }
   }
   ctx.putImageData(imgData, 0, 0);

   /*
                1     1     1

      1/9   *   1     1     1
            
                1     1     1

                     ali

            1/9     1/9     1/9

            1/9     1/9     1/9
            
            1/9     1/9     1/9
   */
}

function Zdruzi() {
   for (let i=0; i<data.length; i++) {
      prejsna[i] = data[i];
   }

   let imgPom = new Image();

   imgPom.src = prompt("Lokacija slike: slika_avto.jpg", "slika_avto.jpg");
   // imgPom.src = "slika_avto.jpg";

   imgPom.onload = function() {
      ctx.drawImage(imgPom, 0, 0);

      let imgDataPom = ctx.getImageData(0, 0, imgPom.width, imgPom.height);
      let dataPom = imgDataPom.data;

      for(let i=0; i < dataPom.length; i++){
         data[i] = data[i] * 0.5 + dataPom[i] * 0.5;
      }
      ctx.putImageData(imgData, 0, 0);
   }
}

function Sosed() {
   let koliko = 1.3;
   let imgDataPom = ctx.getImageData(0, 0, canvas.width*koliko, canvas.height*koliko);
   let tab1 = [];
   let a = canvas.width/(canvas.width*koliko);

   for(let i=0; i<canvas.height*koliko; i++) {
      for(let j=0; j<canvas.width*koliko; j++) {
         let x = Math.floor(j * a);
         let y = Math.floor(i * a);

         tab1.push(data[y * canvas.width * 4 + 4 * x]);
         tab1.push(data[y * canvas.width * 4 + 4 * x + 1]);
         tab1.push(data[y * canvas.width * 4 + 4 * x + 2]);
         tab1.push(255); //alpha
      }
   }

   for(let i=0; i<tab1.length; i++) {
      imgDataPom.data[i] = tab1[i];
   }

   imgData = imgDataPom;

   canvas.width = canvas.width * koliko;
   canvas.height = canvas.height * koliko;
   ctx.putImageData(imgData, 0, 0);

   /*
                        10 10 20 20 30 30
                        10 10 20 20 30 30
         10 20 30       40 40 50 50 60 60
         40 50 60  ->   40 40 50 50 60 60
         70 80 90       70 70 80 80 90 90
                        70 70 80 80 90 90
   */
}

function Bilinearno() {
   let koliko = 2;
   let imgData2 = ctx.getImageData(0, 0, canvas.width*koliko, canvas.height*koliko);
   let tab1 = [];

   for(let i=0; i<canvas.height*koliko; i+=2) {
      for(let j=0; j<canvas.width*koliko; j+=2) {
         let a = (i *(canvas.width*koliko)+j)*4;
         let b = a/2 - (canvas.width*4/2)*i;
         tab1[a] = imgData.data[b];
         tab1[a + 1] = imgData.data[b + 1];
         tab1[a + 2] = imgData.data[b + 2];
         tab1[a + 3] = imgData.data[b + 3];
         tab1[a + 4] = (imgData.data[b] + imgData.data[b+4])/2;
         tab1[a + 5] = (imgData.data[b+1] + imgData.data[b+5])/2;
         tab1[a + 6] = (imgData.data[b+2] + imgData.data[b+6])/2;
         tab1[a + 7] = (imgData.data[b+3] + imgData.data[b+7])/2;
      }
   }

   for(let i=1; i<canvas.height*koliko; i+=2) {
      for(let j=0; j<canvas.width*koliko; j++) {
         let a = (i *(canvas.width*koliko)+j)*4;
         tab1[a] = (tab1[a - (canvas.width*koliko)*4] + tab1[a + (canvas.width*koliko)*4])/2;
         tab1[a + 1] = (tab1[a - (canvas.width*koliko)*4 + 1] + tab1[a + (canvas.width*koliko)*4 + 1])/2;
         tab1[a + 2] = (tab1[a - (canvas.width*koliko)*4 + 2] + tab1[a + (canvas.width*koliko)*4 + 2])/2;
         tab1[a + 3] = 255;
      }
   }

   for(let i=0; i<tab1.length; i++) {
      imgData2.data[i] = tab1[i];
   }

   imgData = imgData2;

   canvas.width = canvas.width*koliko;
   canvas.height = canvas.height*koliko;
   ctx.putImageData(imgData, 0, 0);
}

function Razveljavi() {
   for (let i=0; i<prejsna.length; i++) {
      data[i] = prejsna[i];
   }
   ctx.putImageData(imgData, 0, 0);
}