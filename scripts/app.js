// Copyright 2017 Rivalus Shakti
//
// Licensed under the Apache License, Version 2.0 (the "License");
// you may not use this file except in compliance with the License.
// You may obtain a copy of the License at
//
//      http://www.apache.org/licenses/LICENSE-2.0
//
// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.

(function () {
    'use strict';

    var app = {
        header: document.querySelector('header'),
        section: document.querySelectorAll('section'),


        //        isLoading: true,
        //        visibleCards: {},
        //        selectedCities: [],
        //        spinner: document.querySelector('.loader'),
        //        cardTemplate: document.querySelector('.cardTemplate'),
        //        container: document.querySelector('.main'),
        //        addDialog: document.querySelector('.dialog-container'),
        //        daysOfWeek: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
    };


    /**************
    Fungsi
    **************/



    // Menampilkan section berdasarkan id, digunakan pada saat tombol menu ditekan
    // pada eventListener click
    //    show(x[cari(x, '#opac')]);

    /**************
    Pada saat app dimulai
    **************/
    // Menyembunyikan seluruh section
    hide(app.section);
    //Menampilkan header
    //    show(app.section[cari(app.section, '#header')]);

    /*****************************************************************************
     *
     * Event listeners for UI elements
     *
     ****************************************************************************/

    document.getElementById('tblTop').addEventListener('click', function () {
        hide(app.header);
        hide(app.section);
        show(app.header);
    });
    document.getElementById('tblBerita').addEventListener('click', function () {

        hide(app.header);
        hide(app.section);
        // show(app.section[cari(app.section, 'section#berita')]);
        show(app.section[0]);
    });

    document.getElementById('tblOpac').addEventListener('click', function () {
        hide(app.header);
        hide(app.section);
        // show(app.section[cari(app.section, 'section#opac')]);
        show(app.section[1]);
    });

    document.getElementById('tblUniuca').addEventListener('click', function () {
        hide(app.header);
        hide(app.section);
        show(app.section[2]);
    });

    document.getElementById('tblEbookejournal').addEventListener('click', function () {
        hide(app.header);
        hide(app.section);
        show(app.section[3]);
    });

    document.getElementById('tblOpenaccess').addEventListener('click', function () {
        hide(app.header);
        hide(app.section);
        show(app.section[4]);
    });

    document.getElementById('tblPeta').addEventListener('click', function () {
        hide(app.header);
        hide(app.section);
        show(app.section[5]);
    });

    document.getElementById('tblPeta').addEventListener('click', function () {
        hide(app.header);
        hide(app.section);
        show(app.section[5]);
    });


    document.getElementById('cariOPAC').addEventListener('click', function () {
        let keyword = document.querySelector('form#cariOPAC [name="keywords"]').value;
        //        $('div#hasilOPAC').text("Menunggu hasil: " + keyword);
        ajaxOPAC(keyword);
    });

    document.getElementById('cariUniUca').addEventListener('click', function () {
        let keyword = document.querySelector('form#cariUniUca [name="keywords"]').value;
//        $('div#hasilUniUca').text("Menunggu hasil: " + keyword);
        ajaxUniUca(keyword);

    });

    /*****************************************************************************
     *
     * Methods to update/refresh the UI
     *
     ****************************************************************************/

    // Menyembunyikan elemen
    function hide(elements) {
        elements = elements.length ? elements : [elements];
        for (var index = 0; index < elements.length; index++) {
            elements[index].style.display = 'none';
        }
    }

    // Menampilkan elemen
    function show(elements, specifiedDisplay) {
        elements = elements.length ? elements : [elements];
        for (var index = 0; index < elements.length; index++) {
            elements[index].style.display = specifiedDisplay || 'block';
        }
    }

    // Memilih berdasarkan kata kunci (rencananya id pada section)
    function cari(array, teks) {
        for (var i = 0; i < array.length; i++) {
            if (array[i].parentElement.querySelector(teks)) return i;
        }
        return -1;
    }



    /*****************************************************************************
     *
     * Methods for dealing with the model
     *
     ****************************************************************************/

    function ajaxOPAC(kata) {
        // Mengambil data JSON dari server
        $.ajax({
            dataType: "json",
            type: "GET", //type bisa GET atau POST
            url: "dispatcher/OPACjson.php", // URL dari web service JSON, dalam hal ini dilayani skrip PHP
            data: "keywords=" + kata,

            // jika pakai POST, pakai:
            //                data: {login: username, passwd: password},


            // Jika web service tidak merespon/gagal
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                $('div#hasilOPAC').text("responseText: " + XMLHttpRequest.responseText +
                    ", textStatus: " + textStatus +
                    ", errorThrown: " + errorThrown);
                $('div#hasilOPAC').removeClass();
                $('div#hasilOPAC').addClass("alert alert-warning");
            }, // error

            // Jika web service merespon
            // data yang mengandung nilai JSON akan dikembalikan oleh skrip PHP
            success: function (data) {
                $('div#hasilOPAC').hide(); // menyembunyikan login panel
                $('div#hasilOPAC').removeAttr("style");
                $('div#hasilOPAC').removeClass();
                $('div#hasilOPAC').text("Hasil: " + data['info']); // key berhasil dan nilai dikembalikan
                $('div#hasilOPAC').append('<br/>');
                for (let i = 0; i < data['data'].length; i++) {
                    $('div#hasilOPAC').append('<span>' + (i+1) + '. </span>');
                    $('div#hasilOPAC').append('<a target="_blank" href="' + data['data'][i][4] + '" >' + data['data'][i][0] + '</a>');
                    $('div#hasilOPAC').append('<span>' + data['data'][i][1] + '</span>');
                    $('div#hasilOPAC').append('<span>' + data['data'][i][2] + '</span>');
                    $('div#hasilOPAC').append('<span>' + data['data'][i][3] + '</span>');
                    $('div#hasilOPAC').append('<br/>');
                }
                $('div#hasilOPAC').addClass("alert alert-success");
            } // success
        }); // ajax
    }
    
     function ajaxUniUca(kata) {
        // Mengambil data JSON dari server
        $.ajax({
            dataType: "json",
            type: "GET", //type bisa GET atau POST
            url: "dispatcher/UniUcajson.php", // URL dari web service JSON, dalam hal ini dilayani skrip PHP
            data: "keywords=" + kata,

            // jika pakai POST, pakai:
            //                data: {login: username, passwd: password},


            // Jika web service tidak merespon/gagal
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                $('div#hasilUniUca').text("responseText: " + XMLHttpRequest.responseText +
                    ", textStatus: " + textStatus +
                    ", errorThrown: " + errorThrown);
                $('div#hasilUniUca').removeClass();
                $('div#hasilUniUca').addClass("alert alert-warning");
            }, // error

            // Jika web service merespon
            // data yang mengandung nilai JSON akan dikembalikan oleh skrip PHP
            success: function (data) {
                $('div#hasilUniUca').hide(); // menyembunyikan login panel
                $('div#hasilUniUca').removeAttr("style");
                $('div#hasilUniUca').removeClass();
                $('div#hasilUniUca').text("Hasil: " + data['info']); // key berhasil dan nilai dikembalikan
                $('div#hasilUniUca').append('<br/>');
                for (let i = 0; i < data['data'].length; i++) {
                    $('div#hasilUniUca').append('<span>' + (i+1) + '. </span>');
                    $('div#hasilUniUca').append('<a target="_blank" href="' + data['data'][i][4] + '" >' + data['data'][i][0] + '</a>');
                    $('div#hasilUniUca').append('<span>' + data['data'][i][1] + '</span>');
                    $('div#hasilUniUca').append('<span>' + data['data'][i][2] + '</span>');
                    $('div#hasilUniUca').append('<span>' + data['data'][i][3] + '</span>');
                    $('div#hasilUniUca').append('<br/>');
                }
                $('div#hasilUniUca').addClass("alert alert-success");
            } // success
        }); // ajax
    }

    /************************************************************************
     *
     * Code required to start the app
     *
     * NOTE:
     *   localStorage is a synchronous API and has serious performance
     *   implications. It should not be used in production applications!
     *   Instead, check out IDB (https://www.npmjs.com/package/idb) or
     *   SimpleDB (https://gist.github.com/inexorabletash/c8069c042b734519680c)
     ************************************************************************/

    // TODO add startup code here

    // Menyembunyikan seluruh section
    hide(app.section);




    // TODO add service worker code here
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function () {
            navigator.serviceWorker.register('/sw.js').then(
                function (registration) {
                    // Registration was successful
                    console.log('ServiceWorker registration successful with scope: ', registration.scope);
                },
                function (err) {
                    // registration failed :(
                    console.log('ServiceWorker registration failed: ', err);
                });
        });
    }

})();
