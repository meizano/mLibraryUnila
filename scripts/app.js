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
