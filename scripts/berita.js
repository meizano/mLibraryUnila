// Berita
let hasilberita = document.getElementById('hasilberita');

fetchberita();

// Mengambil data JSON dari server
function fetchberita() {
    var url = 'http://localhost/PWA/mLIbraryUnila/'; // URL RSS
    fetch(url)
        .then((resp) => resp.html())
        .then(function (data) {
            hasilberita.classList.remove("alert", "alert-warning", "alert-success");
            console.log(data);
            hasilberita.innerHTML = 'data masuk';
            // hasilberita.innerHTML = `
            // Hasil: ${data['info']}
            // <br/>
            // `;
            
            // for (let i = 0; i < data['data'].length; i++) {
            //     hasilberita.innerHTML += `
            //     <span>${i+1}</span>
            //     <a target="_blank" href="${data['data'][i][4]}" >${data['data'][i][0]}</a>
            //     <span>${data['data'][i][1]}</span>
            //     <span>${data['data'][i][2]}</span>
            //     <span>${data['data'][i][3]}</span>
            //     <br/>
            //     `;
            // }

            // hasilberita.classList.add("alert", "alert-success");
            
        })
        .catch(function (error) {
            hasilberita.classList.remove("alert", "alert-warning",  "alert-success");
            hasilberita.innerHTML = "Masalah: " + JSON.stringify(error);
            hasilberita.classList.add("alert", "alert-warning");
        });
};