
// on DOM load
$( document ).ready(function() {
    // Initialization of Mobile Collapse Button functional
    // @see http://materializecss.com/navbar.html
    $('.button-collapse').sideNav();

    // @see http://leafletjs.com/ for more details
    if($('#map').length !== 0){
        // set height
        var contentHeight = parseInt($(window).height() - $('header').height() - $('footer').height() - 40);
        $('#map').css('height', contentHeight+'px');

        var map = L.map('map').setView([53.9, 27.57], 12);
        L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        L.marker([53.88758, 27.44741]).addTo(map)
            .bindPopup('Мы здесь<br/><a href="http://katran.by">katran.by</a>')
            .openPopup();

    }

});

