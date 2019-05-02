import axios from "axios";
let formData;

// Hello
console.log('hello');
const formulaire = document.querySelector(".filtreFormulaire");

console.log(formulaire);
console.log("Bonjoureeeuuu");

formulaire.addEventListener("submit",function (e) {
    e.preventDefault();
    console.log(axios);
    debugger;
    
    formData = new FormData(formulaire);
    axios({
        method:"post",
        url:formulaire.getAttribute("action"),
        data:formData
    }).then((response) => {console.log(response)});
})