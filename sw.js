'use strict';
importScripts('./sw-toolbox.js');
toolbox.precache([
    "./",
    "./index.html",
    "./ar-library-navigation.html",
    "./berita.html",
    "./ebookejournal.html",
    "./Navigasi.html",
    "./opac.html",
    "./openaccess.html",
    "./peta.html",
    "./pinjam.html",
    "./UniUca.html",
    "./css/creative.css",
    "./css/navigasi.css",
    "./css/pinjam.css",    
    "./dispatcher/**.*",
    "./img/icons/**.*",
    "./js/**.*",
    "./lib/**.*",
    "./scripts/**.*",
    "./styles/inline.css",
    "./vendor/jquery/jquery.min.js",
    "https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js",
    "./vendor/scrollreveal/scrollreveal.min.js",
    "./endor/magnific-popup/jquery.magnific-popup.min.js",
    "./vendor/bootstrap/css/bootstrap.min.css",
    "./vendor/font-awesome/css/font-awesome.min.css",
    "https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800",
    "https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic",
    "./vendor/magnific-popup/magnific-popup.css"
]);
toolbox.router.get('./img/*', toolbox.cacheFirst);
toolbox.router.get('./*', toolbox.networkFirst, {
    networkTimeoutSeconds: 5
});
