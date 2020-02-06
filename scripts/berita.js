// Berita
let hasilberita = document.getElementById('hasilberita');

fetchberita();

// Mengambil data JSON dari server
function fetchberita() {
    var url = "https://library.unila.ac.id/web/wp-json/wp/v2/posts"; // URL dari data JSON
    fetch(url)
        .then((resp) => resp.json())
        .then(function (data) {
            hasilberita.classList.remove("alert", "alert-warning", "alert-success");
            console.log(data);
            //            hasilberita.innerHTML = 'data masuk';
            hasilberita.innerHTML = ``;
            for (let i = 0; i < data.length; i++) {
                console.log(data[i].link);
                console.log(data[i].title.rendered); //console.log
                console.log(data[i].author);
                console.log(data[i].modified);
                console.log(data[i].content.rendered);
                hasilberita.innerHTML += `
                 <h2 align="center"> <a target="_blank" href="${data[i].link}" >${data[i].title.rendered}</a></h2>
                 <p align="center">${data[i].author}  
                 ${data[i].modified}</p>
                 <p align="justify">${data[i].content.rendered}</p>
                 <br/>
                 `;
            }

            hasilberita.classList.add("nav");

        })
        .catch(function (error) {
            hasilberita.classList.remove("alert", "alert-warning", "alert-success");
            hasilberita.innerHTML = "Masalah: " + JSON.stringify(error);
            hasilberita.classList.add("alert", "alert-warning");
        });
};

function fetchpenulis(idpenulis) {
    var url = "https://library.unila.ac.id/web/wp-json/wp/v2/users/" + idpenulis; // URL dari data JSON
    fetch(url)
        .then((resp) => resp.json())
        .then(function (data) {
//        console.log(data.name);
        return data;
        })
        .catch(function (error) {
        });
};
