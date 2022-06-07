window.document.onload = nalozi();

let izbran = null;
let urejanje = false;
let iskanje = false;

function oznaci(event) {
	if (!urejanje) {
		let bol = false;
		if (izbran!=null && !Object.is(izbran, event.target.parentElement)) {
			izbran.style.backgroundColor = "";
			izbran = event.target.parentElement;
			izbran.style.backgroundColor = "orange";
			bol = true;
		}
		
		if (!bol) {
			if (event.target.parentElement.style.backgroundColor == "orange") {
				event.target.parentElement.style.backgroundColor = "";
				izbran = null;
			} else {
				event.target.parentElement.style.backgroundColor = "orange";
				izbran = event.target.parentElement;
			}
		}
	}
}

function pocistiPolja() {
	if (urejanje || iskanje) {
		document.getElementById("zgorni-text").innerHTML = "DODAJ OSEBO";
		document.getElementById("potrdi").value = "Dodaj";
	}
	
	if (urejanje) urejanje=false;
	if (iskanje) iskanje=false;
	
	if (izbran!=null) {		
		izbran.style.backgroundColor = "";
		izbran=null;
	}
	
	document.getElementById("ime").value="";
	document.getElementById("priimek").value="";
	document.getElementById("telefonska_st").value="";
	
	document.getElementById("ime").focus();
}

function urejanje_clicked(elementi) {
	// document.getElementById("zgorni-text").innerHTML = "DODAJ OSEBO";
	// document.getElementById("potrdi").value = "Dodaj";
		
	for (let i = 0; i<elementi.length; i++) {
		if (elementi[i].id == izbran.children[0].innerText) {
			let ime_v = document.getElementById("ime").value;
			let priimek_v = document.getElementById("priimek").value;
			let telefonska_v = document.getElementById("telefonska_st").value;

			if (ime_v.length>0 && priimek_v!="" && telefonska_v.length>=9) {
				izbran.children[1].innerText = ime_v;
				izbran.children[2].innerText = priimek_v;
				izbran.children[3].innerText = telefonska_v;
				
				elementi[i].ime = ime_v;
				elementi[i].priimek = priimek_v;
				elementi[i].telefonska = telefonska_v;
				
				localStorage.setItem("osebe", JSON.stringify(elementi));
				izbran.style.backgroundColor = "";
				izbran=null;
				pocistiPolja();
			}
			break;
		}
	}
}

function dodajanje_clicked(elementi, prva) {
	const id = prva;
	const ime = document.getElementById("ime").value;
	const priimek = document.getElementById("priimek").value;
	const telefonska = document.getElementById("telefonska_st").value;
	
	if (ime.length>0 && priimek.length>0 && telefonska.length>=9) {
		const oseba = {id, ime, priimek, telefonska}
		elementi.push(oseba);
		localStorage.setItem("osebe", JSON.stringify(elementi));
		
		const table = document.querySelector("#osebe-table");
		const tr = document.createElement("tr");
		tr.onclick = oznaci;
		tr.style.cursor = "pointer";
		table.appendChild(tr);
		
		let j=0;
		for (let el in oseba) {
			const td = document.createElement("td");
			td.innerText = oseba[el];
			if (j==0)
				td.style.display = "none";
			tr.appendChild(td);
			j++;
		}
		
		if (document.getElementById("prazna").style.display == "")
			document.getElementById("prazna").style.display = "none";
		pocistiPolja();
	}
}

function iskanje_clicked(elementi) {
	// document.getElementById("zgorni-text").innerHTML = "DODAJ OSEBO";
	// document.getElementById("potrdi").value = "Dodaj";
	
	const imeV = document.getElementById("ime").value;
	const priimekV = document.getElementById("priimek").value;
	const telefonskaV = document.getElementById("telefonska_st").value;
	
	let filtrirana = [];

	const table = document.querySelector("#osebe-table");

	while (table.lastChild.tagName=="TR") {
		table.removeChild(table.lastChild);
	}
	
	let j=0;
	for (let i = 0; i<elementi.length; i++) {
		if ((imeV.length>0 && (elementi[i].ime).localeCompare(imeV)!=0) || (priimekV.length>0 && (elementi[i].priimek).localeCompare(priimekV)!=0) || (telefonskaV.length>0 && (elementi[i].telefonska).localeCompare(telefonskaV)!=0)) {
			elementi.splice(i, 1);
			i--;
			j++;
		}
	}
	
	for (let i = 0; i<elementi.length; i++) {
		const tr = document.createElement("tr");
		tr.onclick = oznaci;
		tr.style.cursor = "pointer";
		table.appendChild(tr);
		
		let j=0;
		for (let el in elementi[i]) {
			const td = document.createElement("td");
			td.innerText = elementi[i][el];
			if (j==0)
				td.style.display = "none";
			tr.appendChild(td);
			j++;
		}
	}
	
	if (elementi.length<=0) {
		document.getElementById("prazna").style.display = "";
	} else
		document.getElementById("prazna").style.display = "none";
	
	pocistiPolja();
}

function potrdi_clicked() {
	let elementi = [];
	let prva = 0;

	if (localStorage.getItem("osebe") != null && JSON.parse(localStorage.getItem("osebe")).length > 0) {
		elementi = JSON.parse(localStorage.getItem("osebe"));
		prva = elementi[elementi.length-1].id+1;
	}
	
	if (!iskanje) {
		if (!urejanje) {
			dodajanje_clicked(elementi, prva);
		} else {
			urejanje_clicked(elementi);
		}
	} else {
		iskanje_clicked(elementi);
	}
}

function nalozi() {
	document.querySelector("form").setAttribute("action", "")
	let elementi = JSON.parse(localStorage.getItem("osebe"));

	if (elementi != null && elementi.length>0) {
		document.getElementById("prazna").style.display = "none";
		const table = document.querySelector("#osebe-table");
		
		for (let i = 0; i<elementi.length; i++) {	
			const tr = document.createElement("tr");
			tr.onclick = oznaci;
			tr.style.cursor = "pointer";
			table.appendChild(tr);
			
			let j=0;
			for (let el in elementi[i]) {
				const td = document.createElement("td");
				td.innerText = elementi[i][el];
				if (j==0)
					td.style.display = "none";
				tr.appendChild(td);
				j++;
			}
		}
	} else
		document.getElementById("prazna").style.display = "";
	
	document.getElementById("ime").focus();
}

function dodaj() {
	pocistiPolja();
	
	document.getElementById("zgorni-text").innerHTML = "DODAJ OSEBO";
	document.getElementById("potrdi").value = "Dodaj";
	
	document.getElementById("ime").focus();
}

function uredi() {
	if (izbran!=null) {
		if (iskanje) iskanje=false;
		
		document.getElementById("zgorni-text").innerHTML = "UREDI OSEBO";
		document.getElementById("potrdi").value = "Potrdi spremembe";
		
		document.getElementById("ime").value = izbran.children[1].innerText;
		document.getElementById("priimek").value = izbran.children[2].innerText;
		document.getElementById("telefonska_st").value = izbran.children[3].innerText;
		
		urejanje=true;
	}
	
	document.getElementById("ime").focus();
}

function izbrisi() {
	if (izbran != null) {
		if (confirm("Ali želite brisati "+izbran.children[1].innerText+" "+izbran.children[2].innerText+", s telefonsko "+izbran.children[3].innerText)) {
			izbran.remove();
			let elementi = JSON.parse(localStorage.getItem("osebe"));
			for (let i = 0; i<elementi.length; i++) {
				if (elementi[i].id==izbran.children[0].innerText) {
					j=i;
					break;
				}
			}
			
			elementi.splice(j, 1);
			localStorage.setItem("osebe", JSON.stringify(elementi));

			if (elementi.length<=0)
				document.getElementById("prazna").style.display = "";
			
			document.getElementById("ime").focus();
			izbran=null;
		}
	}
}

function isci() {
	pocistiPolja();
	
	document.getElementById("zgorni-text").innerHTML = "POIŠČI OSEBO";
	document.getElementById("potrdi").value = "Išči";
	
	iskanje=true;
	document.getElementById("ime").focus();
}

function sortiraj() {
	let elementi = [];
	let prva = 0;
	
	if (localStorage.getItem("osebe") != null) {
		elementi = JSON.parse(localStorage.getItem("osebe"));
	}	
	
	if (izbran!=null) {
		izbran.style.backgroundColor = "";
		izbran=null;
	}

	if (arguments[0]==0) {
		elementi.sort(function(a, b) {
			return (a.ime).localeCompare(b.ime);
		});
	} else {
		elementi.sort(function(a, b) {
			return (a.priimek).localeCompare(b.priimek);
		});
	}

	const table = document.querySelector("#osebe-table");
	for (let i = 0; i<elementi.length; i++) {
		table.childNodes[i+2].childNodes[0].innerHTML = elementi[i].id;
		table.childNodes[i+2].childNodes[1].innerHTML = elementi[i].ime;
		table.childNodes[i+2].childNodes[2].innerHTML = elementi[i].priimek;
		table.childNodes[i+2].childNodes[3].innerHTML = elementi[i].telefonska;
	}
}

function change_arrow() {
	if (arguments[0]==1)
		document.getElementById("arrow").innerHTML = "&#x25B2;";
	else
		document.getElementById("arrow").innerHTML = "&#x25BC;";
}

document.addEventListener("DOMContentLoaded", () => {
	document.getElementById("potrdi").onclick = potrdi_clicked;
	
    document.getElementById("pocisti").onclick = pocistiPolja;
	
	document.getElementById("dodaj").onclick = dodaj;
	document.getElementById("uredi").onclick = uredi;
	document.getElementById("izbrisi").onclick = izbrisi;
	document.getElementById("isci").onclick = isci;
	
	document.getElementById("sortiraj_po_imenu").onclick = function() {sortiraj(0);};
	document.getElementById("sortiraj_po_priimku").onclick = function() {sortiraj(1);};
	
	document.getElementById("change-arrow").onmouseover = function() {change_arrow(1);};
	document.getElementById("nav-div-dropdown-content").onmouseover = function() {change_arrow(1);};
	document.getElementById("change-arrow").onmouseout = function() {change_arrow(2);};
	document.getElementById("nav-div-dropdown-content").onmouseout = function() {change_arrow(2);};
});