// Berita
let hasilberita = document.getElementById('hasilberita');

fetchberita();

// Mengambil data JSON dari server
function fetchberita() {
    var url = './dispatcher/beritajson.php?/'; // URL dari data JSON
    fetch(url)
        .then((resp) => resp.json())
        .then(function (data) {
            hasilberita.classList.remove("alert", "alert-warning", "alert-success");
            console.log(data);
//            hasilberita.innerHTML = 'data masuk';
            hasilberita.innerHTML = ``;
             for (let i = 0; i < data['data'].length; i++) {
                 hasilberita.innerHTML += `
                 <h2 target="_blank" href="${data['data'][i][4]}" >${data['data'][i][0]}</h2>
                 <p>${data['data'][i][1]}</p>
                 <p>${data['data'][i][2]}</p>
                 <p>${data['data'][i][3]}</p>
                 <br/>
                 `;
             }

             hasilberita.classList.add("alert", "alert-success");
            
        })
        .catch(function (error) {
            hasilberita.classList.remove("alert", "alert-warning",  "alert-success");
            hasilberita.innerHTML = "Masalah: " + JSON.stringify(error);
            hasilberita.classList.add("alert", "alert-warning");
        });
};