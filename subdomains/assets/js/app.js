if (typeof DEBUG === 'undefined') DEBUG = true;

var BikePlus = (function(w,d){

  var map,
      currentPositionMarker,
      currentOpenMarker,
      wHeight = 400,
      markers = [],
      markersdata = [],
      dragstart,
      docksdebounce,
      oldcenter,
      timerId,
      cityLatitude      = globalLatitude  = bikeplusoptions.lang.mobile_js_global_lat,
      cityLongitude     = globalLongitude = bikeplusoptions.lang.mobile_js_global_lng,
      facebookConnected = false,
      $mapbikes         = d.getElementById('mapbikes'),
      $resetlocation    = d.getElementById('resetlocation'),
      $bookmarks        = d.getElementById('bookmarks'),
      $bookmarkscontent = d.getElementById('bookmarkscontent'),
      $dock             = d.getElementById('dock'),
      $landscape        = d.getElementById('landscape'),
      $parseTime        = d.getElementById('parseTime'),
      $timer            = d.getElementById('timer'),
      $timerlist        = d.getElementById('timerlist'),
      $search           = d.getElementById('search'),
      $searchcontent    = d.getElementById('searchcontent'),
      $menu             = d.getElementById('menu'),
      $menulist         = d.getElementById('menulist'),
      $outofreach       = d.getElementById('outofreach'),
      marker_width = 70,
      marker_height = 50;

  var START_EV = (w.navigator.msPointerEnabled) ? "MSPointerDown" : "ontouchstart" in w ? "touchstart" : "mousedown";
  //var MOVE_EV  = (w.navigator.msPointerEnabled) ? "MSPointerMove" : "ontouchstart" in w ? "touchmove"  : "mousemove";
  var PIXEL_RATIO = (function(){ var ctx = d.createElement("canvas").getContext("2d"), dpr = w.devicePixelRatio || 1, bsr = ctx.webkitBackingStorePixelRatio || ctx.mozBackingStorePixelRatio || ctx.msBackingStorePixelRatio || ctx.oBackingStorePixelRatio || ctx.backingStorePixelRatio || 1; return dpr / bsr; })();
  var isOldAndroid = (function(){ var ua = navigator.userAgent; if( ua.indexOf("Android") >= 0 ) { var androidversion = parseFloat(ua.slice(ua.indexOf("Android")+8)); if (androidversion < 3.2) { return true; } } return false; })();
  var canvas_font = (w.navigator.msPointerEnabled) ? "Arial" : (navigator.userAgent.indexOf("Android") >= 0) ? "Roboto" : "STHeitiSC-Light" ; //STHeitiSC-Light";
  var createGuid = function(){ return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) { var r = Math.random()*16|0, v = c === 'x' ? r : (r&0x3|0x8); return v.toString(16); }); };

  //GeoImg Marker Img
  var geoimgmarker = new Image();
      geoimgmarker.src = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEYAAAAyCAMAAADWQ11hAAACOlBMVEX///+5w8yvusWrt8KfrbmWpbKSoa+Roa+Jmql8j6B9j6B3ipx1iJp0iJpwhJdvg5Zkg59sgZRnfZBofZFmfI9nfJBleo9le45edYlfdYpedIpcc4hacYdYb4VUbIJTa4JPaH9OZ34+aY5JYnpIYnpAW3MgVYIyT2kBPXEPMVAAJEX////jIzXPIDEIcMn4Jjr4L0IBacL/KT/lL0CDlaVqf5JRaoD+9fWVpLL/h5Xz9fb/8fKGo7uPn63/f41vos6MnKuLm6qKm6r/7/GHmKfufYfufIeGl6f87++Bk6N1lK5/kaH6bnzw8vT/7O9vkKz/anrr7vB2iZv66ev/5Odzh5n6YW9xhZfh5eneaHP43uBMir9ugpU5jNP43d9tgpU3i9TX3eLdYW36WWj/0NXqXWr/VWf10tb50NT6VmX10dTyw8c9grxle4/9v8XDy9PcW2hkeo7pVmTbWGVhd4w4frv3vcPpUF7aVGG8xc7/+frvtbroTFvvtLr/rrdWboTYTFkBftUBfNT/rLQBfdSfw9/8qrLXR1UPdMr5+vv5OkwNc8vtqbD8o6xNZn4PccVKZHv/oq5JY3qluMj4M0bVPUz/9PWqtsEBasTlMkL8nKUBa7OQt9hCXXX4Kj7znqbqnKQBZ7EBZrChrrrQMTc7V3A5VW/SLDz29/iXrcHRJzfpl5/QIzOTq78BUZDIHx8BS4sBR4UBRoHeDCGUq8DaAAwBN2abqbb7ipT/iJTjJjg2Um2ou8z7iJN0NEFBAAAAAXRSTlMAQObYZgAAAdtJREFUeF7k0LWO9DAYhWHfz7GT4UVmZmZmZmZmZmZm+PHeNhltpC3sFJPp9imsU73SZ0LIh6PA5unnouAmR2gSUcTMF8GIzLQ9pdKweAmDMuoIad2AUVN/u8h5HAw7sZMBGOd9RnLhBsskAm5gJ0H4ZhBik07giiLJ2vSyrIJZdDLawxFIbNo8YOyabRvM9FPW2NnCeuVUcG0umM3mnKf3aF+9zG8ru2GsmGJ8OhI8z9q418n47AMX1AMy8P8BPG3aOBJn6mkYKmk5ui0A3sAzA0iSBGBYmKGMlTW3/wL81cyL6IMlqJlRUaaaZVHQwxIgfkk3I+lmZtdSKDr6rHCaOxUc9WVIlMm+BSAjfAuKUhlctdrYEWWQTif+jACxpqpEkykEXI8BhXmq3WNhBqhYh6qmJx8CCf9erxR3K2OijAt+Ruaz3XnJORgMAyh86n4r/6da6n7/y9gCzIwraWJgC9ZgNaxTpCEGTUjfd8ZZwJPDJlDoy5gfU9JhKjrMEVeDOXPRYK6slnIl02H+J2dGFtZErBS6QLknVGqLA8D+3xSnqRF3bRMXZndRQsP6C+CMW4nZOd7VN08l8khfs/p4kSiEg0as+MhqO3fGIM0PgpOHPDNz0CjPB90ArfwoF/YDOsQAAAAASUVORK5CYII=';

  //GeoImg Pointer [ geolocationpointer ]
  var geolocationpointer = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABYAAAAWCAMAAADzapwJAAAAk1BMVEUAAAAAAAAAAAAVFRUvLy8qKio0MTE1MjI1MzP+JSX/ISH/HR0AAAA2MTHRKSk3MzMuLi42MjIsLCwcHBw4MjI2MTEpKSnIKSs2MzMyLCz/HR3/JCT/JSX/ISH/Jib/HBz/Hh7/IyP3JyfqKCj/Hx//IiLpKCjlKCjkKCjuKCjyJyf0JyfzJyf/ICD5Jyf8Jyf9Jyf0C/cBAAAAGnRSTlMAAQYMKxhdSHPW9v4DWb9vIUcjEil3JcV3KdIG2UwAAADySURBVHhedZHXbsMwDEXlufdIWmp6juz//7oKtBOkDz6iCOhC4CSIEVtOWdelY8UGeWOYlV24WdNkbmFXpvFWc88PwgggCgPfy7WO6ilJldxRaXJC3cyTM0h1Hykd70rCOclN/bnyUimHljKqrR2kTL3KILHtD3KgbIfqh2/HxCoCUC37QBUEhUUcNwQuvuAQug4pswjab7mFKCtJ3YAU/5Dw87vJz9dzM+1QxiC067rHo9NHe4pBMOXlernh1YYptwLF+kFggVs7/NpP09RPfX/j2M7ePBfLMs/zIvjW/GdUI1tXNu6jOhjswRqOlnaw4j8VMScl24SBeQAAAABJRU5ErkJggg==';
  var geolocationpointersmall = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA8AAAAPCAMAAAAMCGV4AAAAYFBMVEX///8XEAkVDAIVFhcVExEVDAIVCwAYEw4XEAkYEQkYEQoXEgwWJDIVMVEUN10TNVsTNFkNPXIKP3kIQX8EQYMLQHsEQYUGQoMMQHkMQHoOP3QOP3YPPnIIQoEEQocLQXxatOuJAAAAE3RSTlMAEREiIiIiMzMzMzNViJmqu93u8OdLsgAAAHtJREFUeF5lj9kSwjAIRelelWwF0lX9/78UWp3p1PN2uGEJGGXbd31bwpcafYjBY31o5RIbyVV76gZ+GTw4fVFgMjU4YQGNNz1g38A9nDzcoIsnjw/LR3rujJpbP79nEZmFtd/mZ1q3ZVsp23zbn2laJsq2/3rf9f7r/z5HXA0vHQNE+wAAAABJRU5ErkJggg==';
  var geolocationpointeroldandroid = '/assets/img/geolocationmarker_old_android.v2.png';

  function mapInit() {
    google.maps.visualRefresh = true;

    $mapbikes.style.height = w.innerHeight + 70 + "px";

    map = new google.maps.Map($mapbikes, {
      center : (currentPosition.get()) ? new google.maps.LatLng(currentPosition.get().lat, currentPosition.get().lng) :
                                         new google.maps.LatLng('40.7266119', '-73.9930061'),
      zoom: 16,
      mapTypeId: google.maps.MapTypeId.ROADMAP,
      disableDefaultUI: true
    });

    //var bikeLayer = new google.maps.BicyclingLayer();
    //bikeLayer.setMap(map);

    google.maps.event.trigger(map, 'resize');

    currentPositionMarker = new google.maps.Marker({
      //position: center,
      map: map,
      icon: { url: geolocationpointer},
      zIndex: 100
    });

    google.maps.event.addListener(map, 'dragstart', function(/*e*/) {
      $resetlocation.style.top = w.innerHeight - 60 + 'px';
      $resetlocation.style.display = 'block';
      dragstart = true;
      w.scrollTo(0, 1);
    });

    google.maps.event.addListener(map, 'bounds_changed', function() {
      if(typeof docksdebounce !== 'undefined' && (Date.now()-docksdebounce < 250) ) {
        return;
      }
      docksdebounce = +Date.now();
      getDocks();
      currentPositionMarker.setZIndex(google.maps.Marker.MAX_ZINDEX + 1);
      currentPosition.set(map.getCenter().lat(), map.getCenter().lng());
    });

    //Hack to get the real height of the screen
    setTimeout(function(){
      wHeight = w.innerHeight;
      $mapbikes.style.height = wHeight + 70 + "px";
      $bookmarks.style.top = wHeight - 60 + 'px';
      $resetlocation.style.top = wHeight - 60 + 'px';
      $dock.style.top = wHeight + 60 + 'px';
    }, 750);

    watchPosition.getLocationUpdate();

    //var input = document.getElementById('targetinput');
    //var searchBox = new google.maps.places.SearchBox(input);
    //google.maps.event.addListener(searchBox, 'places_changed', function() {
    //  var places = searchBox.getPlaces();
    //  DEBUG && console.log(places);
    //});
  }

  function generateMarker() {
    var zoom = map.getZoom();
    var bounds = map.getBounds();
    var positionInBound = false;

    for(var i=0,ln=bikeplusoptions.data.stations.length; i < ln; i++) {
      var latLng = new google.maps.LatLng(bikeplusoptions.data.stations[i].la, bikeplusoptions.data.stations[i].lo);
      if(bounds.contains(latLng)) {
        positionInBound = true;
        markersdata.push({
          'id'     : bikeplusoptions.data.stations[i].id,
          'ad'     : bikeplusoptions.data.stations[i].ad,
          'ab'     : bikeplusoptions.data.stations[i].ab,
          'sn'     : bikeplusoptions.data.stations[i].sn,
          'la'     : bikeplusoptions.data.stations[i].la,
          'lo'     : bikeplusoptions.data.stations[i].lo,
          'latLng' : latLng
        });
      }
    }
    if(!positionInBound){
      $outofreach.classList.add('active');
      return;
    }
    $outofreach.classList.remove('active');


    DEBUG && console.log(markersdata);

    for(var i=0,ln=markersdata.length; i < ln; i++) {
      id = markersdata[i].id;
      markers[id] = markers[id] || {};
      //DEBUG && console.log(markers[id]);

      if(zoom < 16) {
        var size_small = 15 + ((zoom-16)*2);
        //If marker does not exist assign icon
        if(markers[id].marker === void 0) {
          markers[id].marker = new google.maps.Marker({
            position: markersdata[i].latLng,
            map: map,
            icon: {
              url: geolocationpointersmall,
              size: new google.maps.Size(size_small, size_small),
              scaledSize: new google.maps.Size(size_small, size_small)
            },
            zIndex: 1,
            optimized: true
          });
        }
        //If marker exist and has a big icon then change icon
        else if(markers[id].markerType !== 'small'+size_small) {
          markers[id].marker.setIcon({
              url: geolocationpointersmall,
              size: new google.maps.Size(size_small, size_small),
              scaledSize: new google.maps.Size(size_small, size_small)
          });
        }

        markers[id].markerType = 'small'+size_small;

        if(markers[id].listenerHandler !== void 0) {
          google.maps.event.removeListener(markers[id].listenerHandler);
          markers[id].listenerHandler = void 0;
        }
        continue;
      }

      if(markers[id].marker === void 0) {
        //Create Marker
        markers[id].marker = new google.maps.Marker({
          position: markersdata[i].latLng,
          map: map,
          icon: {
            url: (!isOldAndroid) ? createMarker(markersdata[i].id, markersdata[i].sn, markersdata[i].ab, markersdata[i].ad) : geolocationpointeroldandroid,
            size: new google.maps.Size(marker_width, marker_height),
            scaledSize: new google.maps.Size(marker_width, marker_height)
          },
          zIndex: 1/*,
          optimized: (!isOldAndroid) ? false : true*/
        });
      }
      else if(markers[id].markerType !== 'big') {
        markers[id].marker.setIcon({
          url: (!isOldAndroid) ? createMarker(markersdata[i].id, markersdata[i].sn, markersdata[i].ab, markersdata[i].ad) : geolocationpointeroldandroid,
          size: new google.maps.Size(marker_width, marker_height),
          scaledSize: new google.maps.Size(marker_width, marker_height)
        });
      }
      markers[id].markerType = 'big';

      if(markers[id].listenerHandler === void 0) {
        //Assign event
        markers[id].listenerHandler = google.maps.event.addListener(markers[id].marker, 'click', (function(i){
          return function() {
            //If i is current marker then close the marker
            if(i === currentOpenMarker) {
              $mapbikes.style.height = wHeight + 20 + "px";
              google.maps.event.trigger(map, 'resize');
              map.panTo(oldcenter);
              $resetlocation.style.display = 'block';
              dragstart = true;

              //$dock.classList.remove("bounceIn");
              $dock.style.top = wHeight + 60 + 'px';
              //$dock.style.display = 'none';

              currentOpenMarker = '';
              return;
            }
            //Set current marker id open
            currentOpenMarker = i;

            //$dock.classList.add("bounceIn");
            if(clockHandler.is_running()) {
              markersdata[i].timer = 'true';
              markersdata[i].timerlabel = bikeplusoptions.lang.mobile_js_ride_finish;
            }
            else {
              markersdata[i].timer = '';
              markersdata[i].timerlabel = bikeplusoptions.lang.mobile_js_ride_start;
            }

            if(!facebookConnected) {
              markersdata[i].facebook = 'notconnected';
            }
            else {
              markersdata[i].facebook = '';
            }

            //Check if bookmark already added
            if(localStorage.bookmarkDock === undefined) {
              currentBookmarks = [];
            }
            else {
              currentBookmarks = jsonParse(localStorage.bookmarkDock);
            }
            markersdata[i].bookmarksAdded = currentBookmarks.filter(function(el){return (el.id === markersdata[i].id) ? true : false; })[0];

            /*centra la mappa sul punto del marker*/
            oldcenter = map.getCenter();
            markersdata[i].distance = getDistance(globalLatitude, globalLongitude, markersdata[i].la, markersdata[i].lo);

            $dock.innerHTML = bikeplusoptions.tmpl.dock({data: markersdata[i], lang: bikeplusoptions.lang.tmpl.dock});
            $dock.style.top = wHeight - 100 - 48 + 'px';

            $mapbikes.style.height = wHeight - 100 - 48 + 20 + "px";
            google.maps.event.trigger(map, 'resize');
            map.panTo(markersdata[i].latLng);
            dragstart = true;
          };
        })(i));
      }
    }
  }

  function markersHandler(e) {
    e.preventDefault();
    e.stopPropagation();
    var target = e.target;
    while(target) {
      if(target.className === 'close') { // || target.id === 'dock'

        $mapbikes.style.height = wHeight + 20 + "px";
        google.maps.event.trigger(map, 'resize');
        map.panTo(oldcenter);
        $resetlocation.style.display = 'block';
        dragstart = true;

        //$dock.classList.remove("bounceIn");
        $dock.style.top = wHeight + 60 + 'px';
        //$dock.style.display = 'none';
        break;
      }
      if(target.className.indexOf('timing') > -1) {
        var dock = bikeplusoptions.data.stations.filter(function(el){return (el.id === target.dataset.dockid) ? true : false; })[0];

        if(target.value === 'true') {
          clockHandler.stop({
            'dock' : {
              'id' : dock.id,
              'sn' : dock.sn,
              'la' : dock.la,
              'lo' : dock.lo
            }
          });
          target.className = 'timing';
          target.querySelector('strong').innerHTML = bikeplusoptions.lang.mobile_js_ride_start;
          target.value = '';
          break;
        }
        else {
          var fbshare = (target.querySelector('.sharefacebook').className.indexOf('facebook') > -1) ? true : false;
          var $countdown = target.querySelector('.countdown');
          var $strong = target.querySelector('strong');
          $strong.innerHTML = bikeplusoptions.lang.mobile_js_ride_starting;
          setTimeout(function(){
            $countdown.innerHTML = '<span>3</span>';
          }, 50);
          setTimeout(function(){
            $countdown.innerHTML = '<span>2</span>';
          }, 1250);
          setTimeout(function(){
            $countdown.innerHTML = '<span>1</span>';
            clockHandler.start({
              'fbshare': fbshare,
              'dock' : {
                'id' : dock.id,
                'sn' : dock.sn,
                'la' : dock.la,
                'lo' : dock.lo
              }
            });
          }, 2500);
          setTimeout(function(){
            target.value = 'true';
            target.className = 'timing active';
            $countdown.innerHTML = '<span class="icon-stopwatch"></span>';
            $strong.innerHTML = bikeplusoptions.lang.mobile_js_ride_finish;
          }, 3750);

          setTimeout(function(){
            //OPTIMIZE
            $mapbikes.style.height = wHeight + 20 + "px";
            google.maps.event.trigger(map, 'resize');
            map.panTo(oldcenter);
            $resetlocation.style.display = 'block';
            dragstart = true;

            //$dock.classList.remove("bounceIn");
            $dock.style.top = wHeight + 60 + 'px';
            //$dock.style.display = 'none';
          }, 5000);

        }
        break;
      }
      if(target.className.indexOf('sharefacebook') > -1) {
        if(target.className.indexOf('notconnected') > -1) {
          FB.login(menuCallback, {scope: 'publish_actions'});
        }
        else {
          target.classList.toggle('disabled');
        }
        break;
      }
      if(target.className.indexOf('setbookmark') > -1) {
        bookmarkDock(target);
        break;
      }

      target = target.parentNode;
    }
    return;
  }

  function getDistance(lat1,lon1,lat2,lon2) {
    lat2 = Number(lat2);
    lon2 = Number(lon2);
    lat1 = parseInt(lat1*100000000, 10)/100000000;
    lon1 = parseInt(lon1*100000000, 10)/100000000;
    lat2 = parseInt(lat2*100000000, 10)/100000000;
    lon2 = parseInt(lon2*100000000, 10)/100000000;

    var R = bikeplusoptions.lang.mobile_dockdistanceratio; // km (change this constant to get miles) 6371
    var PI = Math.PI / 180;
    var dLat = (lat2-lat1) * PI;
    var dLon = (lon2-lon1) * PI;
    var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
        Math.cos(lat1 * PI ) * Math.cos(lat2 * PI ) *
        Math.sin(dLon/2) * Math.sin(dLon/2);
    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
    var d = R * c;
    return Math.round(d*100)/100;
  }

  function bookmarkDock(target){
    var dock = bikeplusoptions.data.stations.filter(function(el){return (el.id === target.dataset.dockid) ? true : false; })[0];

    if(localStorage.bookmarkDock === undefined) {
      localStorage.bookmarkDock = JSON.stringify([]);
    }

    var currentBookmark = jsonParse(localStorage.bookmarkDock);
    if(currentBookmark.filter(function(el){return (el.id === target.dataset.dockid) ? true : false; }).length === 0 ) {
      currentBookmark.push({
        'id'     : dock.id,
        'sn'     : dock.sn,
        'la'     : dock.la,
        'lo'     : dock.lo,
        'latLng' : dock.latLng
      });
    }
    localStorage.bookmarkDock = JSON.stringify(currentBookmark);

    target.querySelector('strong').innerHTML = bikeplusoptions.lang.mobile_js_bookmarks_added;
    target.querySelector('.icon-bookmark').classList.add('added');
    setTimeout( function(){ target.querySelector('strong').innerHTML = ''; }, 1750);
  }

  function createMarker(id, sn, ab, ad) {
    var key = sn+ab+ad;
    if(!createMarker.cache){
      createMarker.cache = {};
    }
    if(createMarker.cache[key]){
      return createMarker.cache[key];
    }

    var canvas = d.createElement("canvas");
    context = canvas.getContext("2d");
    canvas.width = marker_width * PIXEL_RATIO;
    canvas.height = marker_height * PIXEL_RATIO;
    context.drawImage(geoimgmarker, 0, 0, canvas.width, canvas.height);

    /*ID*/
    context.fillStyle = "rgba(255,255,255,1)";
    context.font = (10 * PIXEL_RATIO)+"px "+ canvas_font;
    context.textAlign = "left";
    context.fillText(sn, 5 * PIXEL_RATIO, 37 * PIXEL_RATIO, 60 * PIXEL_RATIO);

    /*Bikes*/
    context.fillStyle = "rgba(0,0,0,1)";
    context.font = (16 * PIXEL_RATIO)+"px "+ canvas_font;
    context.textAlign = "left";
    context.fillText(ab, 20 * PIXEL_RATIO, 20 * PIXEL_RATIO);

    /*Docks*/
    //context.fillStyle = "rgba(0,0,0,1)";
    //context.font = (16 * PIXEL_RATIO)+"px "+ canvas_font;
    //context.textAlign = "left";
    context.fillText(ad, 51 * PIXEL_RATIO, 20 * PIXEL_RATIO);

    createMarker.cache[key] = canvas.toDataURL();
    return createMarker.cache[key];
  }

  function getDocks() {
    if(typeof bikeplusoptions.data !== 'undefined' && (Date.now() - bikeplusoptions.data.fetched < 60000*2) ){
      $parseTime.innerHTML = w.bikeplusoptions.data.parseTime;
      generateMarker();
      return;
    }
    promise.get('/api/latest').then(function(error, text/*, xhr*/) {
      if(error){ /*alert('Error ' + xhr.status);*/ return; }
      w.bikeplusoptions.data = jsonParse(text);
      w.bikeplusoptions.data.fetched = Date.now();
      $parseTime.innerHTML = w.bikeplusoptions.data.parseTime;
      generateMarker();
    });
  }

  var currentPosition = (function(){
    function set(lat, lng){
      localStorage.position = JSON.stringify({'lat': lat.toString(), 'lng': lng.toString()});
    }

    function get(){
      if(localStorage.position) {
        return jsonParse(localStorage.position);
      }
      return false;
    }

    return {
      set : set,
      get : get
    };
  })();

  var watchPosition = (function(){
    var watchID,
        accuracy,
        center;

    function updateLocation(position) {
      globalLatitude = position.coords.latitude;
      globalLongitude = position.coords.longitude;
      accuracy = position.coords.accuracy;
      center = new google.maps.LatLng(globalLatitude, globalLongitude);
      currentPositionMarker.setPosition(center);
      if(!dragstart) {
        map.setCenter(center);
      }
    }

    function restoreLocation() {
      center = new google.maps.LatLng(globalLatitude, globalLongitude);
      map.setCenter(center);
      currentPositionMarker.setPosition(center);
      $resetlocation.style.display = 'none';
      dragstart = false;
    }

    function errorHandler(/*err*/) {
      return;
      //if(err.code == 1) {
      //  alert("Error: Access is denied!");
      //}
      //else if( err.code == 2) {
      //  alert("Error: Position is unavailable!");
      //}
    }

    function getLocationUpdate(){
      if(navigator.geolocation){
        var options = {
          enableHighAccuracy: true
          //maximumAge: 30000,
          //timeout: 60000
        };
        watchID = navigator.geolocation.watchPosition(updateLocation, errorHandler, options);
      }
      else {
        alert("Sorry, browser does not support geolocation!");
      }
    }

    return {
      getLocationUpdate : getLocationUpdate,
      restoreLocation : restoreLocation
    };
  })();

  var clockHandler = {
    options : {
      time : 0,
      station : {},
      $time : $timer.querySelector('strong'),
      $stopwatch : $timer.querySelector('.icon-stopwatch'),
      $timelandscape : d.getElementById('timing')
    },
    start : function(opt) {
      DEBUG && console.log('start');
      if(timerId) {
        clockHandler.stop({ dock : { id : 'false' } });
        return;
      }

      if(localStorage.timer && localStorage.timer.length > 0) {
        clockHandler.options.time = localStorage.timer;
      }
      else {
        clockHandler.options.time = localStorage.timer = +Date.now();
      }

      clockHandler.options.$stopwatch.style.display = 'none';

      var diff = clockHandler.difftostring(+Date.now() - clockHandler.options.time);
      clockHandler.options.$time.innerHTML = diff;
      clockHandler.options.$timelandscape.innerHTML = diff;
      timerId = setInterval(clockHandler.insert, 1000);

      if(map === undefined) {
        return;
      }

      //Store time in localstorage
      if(localStorage.timerList === undefined) {
        localStorage.timerList = JSON.stringify([]);
      }
      var timerList = jsonParse(localStorage.timerList);
      var alreadystarted = false;
      for(var i=timerList.length; i--;){
        if(timerList[i].stop.time === 0) {
          alreadystarted = true;
        }
      }

      if(alreadystarted) {
        //DEBUG && console.log('alreadystarted');
        return;
      }
      var now = Math.ceil(Date.now()/1000);
      var lat = map.getCenter().lat();
      var lng = map.getCenter().lng();
      var uuid = createGuid();
      var data = {
        'uuid'  : uuid,
        'start' : {
          'time' : now,
          'la'   : lat,
          'lo'   : lng,
          'dock' : {
            'id' : (opt.dock.id) ? opt.dock.id : false,
            'sn' : (opt.dock.id) ? opt.dock.sn : false,
            'la' : (opt.dock.id) ? opt.dock.la : false,
            'lo' : (opt.dock.id) ? opt.dock.lo : false
          }
        },
        'stop': {
          'time' : 0,
          'la'   : '',
          'lo'   : '',
          'dock' : {
            'id' : '',
            'sn' : '',
            'la' : '',
            'lo' : ''
          }
        },
        'share' : {
          'facebook' : {
            'uuid' : (opt.fbshare) ? uuid : false,
            'responseid' : ''
          }
        }
      };
      //DEBUG && console.log(data);
      timerList.push(data);
      localStorage.timerList = JSON.stringify(timerList);

      //Share in Facebook
      if(opt.fbshare) {
        FBshareRide({ 'uuid' : uuid });
      }

    },
    stop : function(opt){
      //DEBUG && console.log('stop');
      localStorage.timer = '';
      clearInterval(timerId);
      timerId = 0;
      clockHandler.options.$time.innerHTML = '';
      clockHandler.options.$timelandscape.innerHTML = '00 : 00';
      clockHandler.options.$stopwatch.style.display = 'inline-block';

      //Store time in localstorage
      if(localStorage.timerList === undefined) {
        localStorage.timerList = JSON.stringify([]);
      }
      var timerList = jsonParse(localStorage.timerList);
      //timerList = timerList.slice(timerList.length-20);
      var now = Math.ceil(Date.now()/1000);
      var lat = map.getCenter().lat();
      var lng = map.getCenter().lng();
      for(var i=timerList.length; i--;){
        if(timerList[i].stop.time === 0) {
          timerList[i].stop = {
            'time' : now,
            'la'   : lat,
            'lo'   : lng,
            'dock' : {
              'id' : (opt.dock.id) ? opt.dock.id : false,
              'sn' : (opt.dock.id) ? opt.dock.sn : false,
              'la' : (opt.dock.id) ? opt.dock.la : lat,
              'lo' : (opt.dock.id) ? opt.dock.lo : lng
            }
          };

          localStorage.timerList = JSON.stringify(timerList);
          shareRideUpdate(timerList[i]);
          break;
        }
      }
    },
    insert : function() {
      var diff = clockHandler.difftostring(+Date.now() - clockHandler.options.time);
      clockHandler.options.$time.innerHTML = diff;
      clockHandler.options.$timelandscape.innerHTML = diff;
    },
    difftostring : function(diff) {
      var minutes = (~~((diff/1000/60) << 0));
      if(minutes > '59')  return 'over';
      var seconds = (~~((diff/1000) % 60 << 0));
      minutes = (minutes < 10) ? '0'+minutes.toString() : minutes;
      seconds = (seconds < 10) ? '0'+seconds.toString() : seconds;
      return minutes+' : '+seconds;
    },
    check : function(){
      if(localStorage.timer && localStorage.timer.length > 0) {
        clockHandler.start();
      }
    },
    is_running : function(){
      if(timerId) {
        return true;
      }
      return false;
    }
  };

  function timerHandler(e) {
    e.preventDefault();
    e.stopPropagation();
    var target = e.target;
    while(target) {
      if(target.className === 'icon-cycle') {
        w.location.reload();break;
        $search.classList.toggle('active');
        break;
      }

      if(target.id === 'timer') {
        $timerlist.classList.toggle('active');
        var list = {};
        list.timerlabel = (clockHandler.is_running()) ? 'Stop timer' : 'Start timer';
        list.history = [];

        var timerList = jsonParse(localStorage.timerList);

        for(var i=timerList.length; i--;){
          if( timerList[i].stop.time > 0 && (timerList[i].stop.time < timerList[i].start.time + 55) ) continue;
          list.history.push({
            start : {
              time : '<strong>Start:</strong> ' + moment(timerList[i].start.time * 1000).format('MMMM Do, h:mm:ss a'),
              la   : timerList[i].start.la,
              lo   : timerList[i].start.lo
            },
            stop : {
              time : (timerList[i].stop.time === 0) ? 'In progress' : '<strong>Finish:</strong> ' + moment(timerList[i].stop.time * 1000).format('MMMM Do, h:mm:ss a'),
              la   : timerList[i].stop.la,
              lo   : timerList[i].stop.lo
            },
            duration : (timerList[i].stop.time === 0) ?
                                  (~~(((Math.ceil(Date.now()/1000)-timerList[i].start.time)/60) << 0)) + '"'
                                : (~~(((timerList[i].stop.time-timerList[i].start.time)/60) << 0)) + '"',
            'class'  : (timerList[i].stop.time === 0) ? 'active' : ''
          });
        }

        if(!facebookConnected) {
          list.facebook = 'notconnected';
        }
        else {
          list.facebook = '';
        }
        DEBUG && console.log(list);
        $timerlist.innerHTML = bikeplusoptions.tmpl.timerlist({data: list, lang: bikeplusoptions.lang.tmpl.timerlist});
        break;
      }

      target = target.parentNode;
    }
    return;
  }

  function timerlistHandler(e) {
    e.preventDefault();
    e.stopPropagation();
    var target = e.target;
    while(target) {
      if(target.tagName === 'LI') {
        if(target.className === 'active') {
          break;
        }
        $timerlist.classList.toggle("active");

        //https://developers.google.com/maps/documentation/javascript/examples/places-searchbox
        //var bounds = new google.maps.LatLngBounds();
        //map.fitBounds(bounds);

        map.setCenter(new google.maps.LatLng(target.dataset.timerStartLa, target.dataset.timerStartLo));
        $resetlocation.style.display = 'block';
        dragstart = true;
        break;
      }

      target = target.parentNode;
    }
    return;
  }

  function bookmarksHandler(e){
    e.preventDefault();
    e.stopPropagation();

    if($bookmarks.classList.contains("active")) {
      $bookmarks.classList.toggle("active");
      return;
    }

    var currentBookmarks = {};

    if(localStorage.bookmarkDock !== undefined) {
      currentBookmarks.data = jsonParse(localStorage.bookmarkDock);
    }

    var i = currentBookmarks.data.length;
    while (i--) {
      var d = bikeplusoptions.data.stations.filter(function(el){return (el.id === currentBookmarks.data[i].id) ? true : false; })[0];
      currentBookmarks.data[i].ab = d.ab;
      currentBookmarks.data[i].ad = d.ad;
      currentBookmarks.data[i].distance = getDistance(globalLatitude, globalLongitude, currentBookmarks.data[i].la, currentBookmarks.data[i].lo);
    }
    currentBookmarks.lang = bikeplusoptions.lang.tmpl.bookmarks;
    DEBUG && console.log(currentBookmarks);
    DEBUG && console.log(bikeplusoptions.tmpl.bookmarks(currentBookmarks));
    $bookmarkscontent.innerHTML = bikeplusoptions.tmpl.bookmarks(currentBookmarks);
    $bookmarks.classList.toggle("active");

    return;
  }

  function bookmarksContentHandler(e){
    e.preventDefault();
    e.stopPropagation();
    var target = e.target;
    while(target) {
      if(target.tagName === 'LI') {
        $bookmarks.classList.toggle("active");
        map.panTo(new google.maps.LatLng(target.dataset.dockla, target.dataset.docklo));
        $resetlocation.style.display = 'block';
        dragstart = true;
        break;
      }

      if(target.className === 'icon-trashcan') {
        var currentBookmarks;
        currentBookmarks = jsonParse(localStorage.bookmarkDock);
        currentBookmarks = currentBookmarks.filter(function(el){return (el.id === target.parentNode.dataset.dockid) ? false : true; });
        localStorage.bookmarkDock = JSON.stringify(currentBookmarks);
        target.parentNode.style.display = 'none';
        break;
      }

      if(target.id === 'bookmarkscontent') {
        break;
      }

      target = target.parentNode;
    }
    return;
  }

  function searchHandler(e){
    e.preventDefault();
    e.stopPropagation();
    var target = e.target;
    if(target.tagName === 'INPUT') {
      target.focus();
      target.classList.toggle('active');
      var autocomplete = new google.maps.places.Autocomplete(target);
      return;
    }
    w.scrollTo(0, 1);

    while(target) {
      if(target.tagName === 'SPAN') {
        d.getElementById('targetinput').blur();
        $search.classList.toggle('active');
        break;
      }
      target = target.parentNode;
    }
    return;
  }

  d.getElementById('targetinput').addEventListener('focus', function(e){
    //e.preventDefault(); e.stopPropagation();
    window.scrollTo(0, 1);
  }, false);

  function searchContentHandler(e){
    e.preventDefault();
    e.stopPropagation();
    var target = e.target;
    DEBUG && console.log(e);
    while(target) {

      if(target.className === 'icon-trashcan') {
        var currentBookmarks;
        currentBookmarks = jsonParse(localStorage.bookmarkDock);
        currentBookmarks = currentBookmarks.filter(function(el){return (el.id === target.parentNode.dataset.dockid) ? false : true; });
        localStorage.bookmarkDock = JSON.stringify(currentBookmarks);
        target.parentNode.style.display = 'none';
        break;
      }

      target = target.parentNode;
    }
    return;
  }

  function doOnOrientationChange() {
    switch(w.orientation) {
      case -90:
      case 90:
        //alert('landscape');
        $landscape.style.display = 'block';
        break;
      default:
        //alert('portrait');
        $landscape.style.display = 'none';
        break;
    }
    w.scrollTo(0, 1);
  }

  /*Events*/
  $resetlocation.addEventListener(START_EV, function(e){
    e.preventDefault();
    e.stopPropagation();
    watchPosition.restoreLocation(dragstart);
  });

  $landscape.addEventListener(START_EV, function(e){
    e.preventDefault();
    e.stopPropagation();
  });

  $search.addEventListener(START_EV, searchHandler);
  $searchcontent.addEventListener(START_EV, searchContentHandler);

  $timer.addEventListener(START_EV, timerHandler);
  clockHandler.check();

  $timerlist.addEventListener(START_EV, timerlistHandler);

  $menu.addEventListener(START_EV, function(e){
    e.preventDefault();
    e.stopPropagation();
    $menu.classList.toggle("active");
  });

  $bookmarks.addEventListener(START_EV, bookmarksHandler);
  $bookmarkscontent.addEventListener(START_EV, bookmarksContentHandler);

  $dock.addEventListener(START_EV, markersHandler, false);

  $outofreach.addEventListener(START_EV, function(e){
    e.preventDefault();
    e.stopPropagation();
    DEBUG && console.log('$outofreach.addEventListener', e);
    DEBUG && console.log('$outofreach.addEventListener', cityLatitude);
    DEBUG && console.log('$outofreach.addEventListener', cityLongitude);

    map.setCenter(new google.maps.LatLng(cityLatitude, cityLongitude));
    $resetlocation.style.display = 'block';
    dragstart = true;
  });

  setTimeout(function () { w.scrollTo(0, 1); }, 500);

  w.onorientationchange = doOnOrientationChange;

  function jsonParse(s) {
    try {
      return JSON.parse(s);
    } catch (e) {
      DEBUG && console.error('Json Error',e);
      return [];
    }
  }

  //FACEBOOK
  window.fbAsyncInit = function() {
    FB.init({
      appId      : bikeplusoptions.fbappid,
      channelUrl : '//'+bikeplusoptions.shareurl+'/channel.html',
      status     : true,
      cookie     : true,
      xfbml      : false
    });

    FB.getLoginStatus(menuCallback, true);

    $menulist.addEventListener(START_EV, function(e){
      e.preventDefault();
      e.stopPropagation();
      var target = e.target;
      DEBUG && console.log('$menulist.addEventListener', e);
      while(target) {
        if(target.className === 'facebook') {
          FB.login(menuCallback, {scope: 'publish_actions'});
          break;
        }
        if(target.className === 'facebook_logout') {
          var r = confirm(bikeplusoptions.lang.mobile_js_logout);
          if( r === true) {
            FB.logout(function(/*response*/) {
              facebookConnected = false;
              $menulist.innerHTML = bikeplusoptions.tmpl.menulist({lang: bikeplusoptions.lang.tmpl.menulist});
            });
          }
          break;
        }
        if(target.className === 'cities') {
          DEBUG && console.log(target.querySelector('a').href);
          w.location.href = target.querySelector('a').href;
          break;
        }
        target = target.parentNode;
      }
      return;
    });

    //FB.Event.subscribe('auth.authResponseChange', function(e) {
    //  DEBUG && console.log('5', e);
    //});
  };

  function menuCallback(response) {
    //DEBUG && console.log(response);
    //DEBUG && console.log(response.authResponse);
    if(response.authResponse || response.status === 'connected') {
      facebookConnected = true;

      $menu.className = 'loggedin';

      if( $dock.querySelector('.facebook') ) {
        $dock.querySelector('.facebook').classList.toggle('notconnected');
      }

      FB.api('/me?fields=id,first_name,name,picture', function(user) {
        $menulist.innerHTML = bikeplusoptions.tmpl.menulist({ data: user, lang: bikeplusoptions.lang.tmpl.menulist});
        FB.api(
          {
            method: 'fql.query',
            query: 'SELECT uid, name, pic_square FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1 = me() ) AND is_app_user = 1'
          },
          function(response) {
            $menulist.innerHTML = bikeplusoptions.tmpl.menulist({'user': user, 'friends' : response, lang: bikeplusoptions.lang.tmpl.menulist});
            $menu.querySelector('img').src = user.picture.data.url;
            //DEBUG && console.log(user);
            //DEBUG && console.log(response);
          }
        );
      });
    } else {
      $menulist.innerHTML = bikeplusoptions.tmpl.menulist({lang: bikeplusoptions.lang.tmpl.menulist});
    }
  }

  function FBshareRide(options) {
    var timerList = jsonParse(localStorage.timerList);
    var id;
    for(var i=timerList.length; i--;){
      if(timerList[i].share.facebook.uuid === options.uuid) {
        id = i;
        break;
      }
    }
    DEBUG && console.log('FBshareRide: : options', options);
    DEBUG && console.log('FBshareRide: : id', id);
    DEBUG && console.log('FBshareRide: : timerList[id]', timerList[id]);
    if(!id) return;

    var course = 'http://'+bikeplusoptions.shareurl+'/bike/ride/' +
                  timerList[id].uuid +
                  '/start/' +
                  timerList[id].start.dock.id +
                  '/' +
                  timerList[id].start.dock.la +
                  '/' +
                  timerList[id].start.dock.lo;

    DEBUG && console.log('course start: ', course);
    DEBUG && console.log(course);

    promise.get(course).then(function(error/*, text*//*, xhr*/) {
      if(error){ /*alert('Error ' + xhr.status);*/ return; }
      var date = Math.ceil(Date.now()/1000);
      var courseid = 'http://'+bikeplusoptions.shareurl+'/bike/ride/' + timerList[id].uuid;
      //DEBUG && console.log('start courseid', courseid);
      FB.api(
        '/me/fitness.bikes',
        'post',
        {
          course: courseid,
          //message: 'I am riding ‪#‎CityBikeNYC‬ in New York City! Send me cheers along the way by liking or commenting on this post.', // + options.dock.sn,
          start_time : date,
          expires_in: 60*45
          //image : 'https://www.google.com/images/srpr/logo4w.png',
          //start_time : ,
          //end_time : ,
          //created_time : ,
          //expires_in : ,
          //place : ,
          //tags : ,
          //ref : ,
          //message : ,
          //no_feed_story : ,
        },
        function(response) {
          if (!response) {
            DEBUG && console.log('Error occurred.');
          }
          else if (response.error) {
            DEBUG && console.log('Error occurred.', response.error.message);
          }
          else {
            //response.id
            DEBUG && console.log('response.id.', response.id);
            var log = '<a href=\"https://www.facebook.com/me/activity/' + response.id + '\">' + 'Story created.  ID is ' + response.id + '</a>';
            DEBUG && console.log(log);
            timerList[id].share.facebook.responseid = response.id;
            localStorage.timerList = JSON.stringify(timerList);
          }
        }
      );

    });

  }
  function shareRideUpdate(options) {
    //DEBUG && console.log('shareRideUpdate : options: ', options);
    if(!('share' in options) || !('facebook' in options.share)) {
      return;
    }
    DEBUG && console.log(options);
    var course = 'http://'+bikeplusoptions.shareurl+'/bike/ride/' +
            options.share.facebook.uuid +
            '/stop/' +
            options.stop.dock.id +
            '/' +
            options.stop.dock.la +
            '/' +
            options.stop.dock.lo;

    DEBUG && console.log('course stop', course);

    promise.get(course).then(function(error/*, text*//*, xhr*/) {
      if(error){ /*alert('Error ' + xhr.status);*/ return; }
      var date = Math.ceil(Date.now()/1000);
      var courseid = 'http://'+bikeplusoptions.shareurl+'/bike/ride/' + options.share.facebook.uuid;

      DEBUG && console.log('stop courseid', courseid);

      //Posted the whole route
      FB.api(
        options.share.facebook.responseid,
        'post',
        {
          course: courseid,
          //message: '', // + options.dock.sn,
          end_time : date
        },
        function(response) {
          if (!response) {
            DEBUG && console.log('Error occurred.');
          }
          else if (response.error) {
            DEBUG && console.log(response.error.message);
          }
          else {
             DEBUG && console.log(response);
            FB.api(
              options.share.facebook.responseid,
              'get',
              {
              },
              function(response) {
                if (!response) {
                  //DEBUG && console.log('Error occurred.');
                }
                else if (response.error) {
                  //DEBUG && console.log(response.error.message);
                }
                else {
                  //DEBUG && console.log(response);
                  FB.api(
                    response.data.course.id,
                    'post',
                    {
                      scrape : 'true'
                    },
                    function(response) {
                      if (!response) {
                        //DEBUG && console.log('Error occurred.');
                      }
                      else if (response.error) {
                        //DEBUG && console.log(response.error.message);
                      }
                      else {
                        //DEBUG && console.log(response);
                      }
                    }
                  );
                }
              }
            );
          }
        }
      );
    });
  }

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/all.js";
     fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));


  return {
    mapInit: mapInit
  };

})(window, document);



//  function timerlist_OLDHandler(e) {
//    e.preventDefault(); e.stopPropagation();
//    var target = e.target;
//    while(target) {
//      if(target.className === 'close') {
//        timerSharer.hide();
//        break;
//      }
//      if(target.className === 'dock') {
//        var dock = bikeplusoptions.data.stations.filter(function(el){return (el.id === target.dataset.dockid) ? true : false; })[0];
//        DEBUG && console.log(dock);
//        break;
//      }
//      target = target.parentNode;
//    }
//    return;
//  }

//  var timerSharer = (function(){
//    var nearDocks = [];
//    function activate(){
//      $timerlist_OLD.classList.add('active');
//      $timerlist_OLD.innerHTML = tmpl.timerlist_OLD( _nearestPoints() );
//    };
//
//    function hide(){
//      $timerlist_OLD.classList.remove('active');
//    }
//
//    function _nearestPoints(){
//      nearDocks = [];
//      for(var i=0,ln=bikeplusoptions.data.stations.length; i < ln; i++) {
//        var latLng = new google.maps.LatLng(bikeplusoptions.data.stations[i].la, bikeplusoptions.data.stations[i].lo);
//        var bounds = map.getBounds();
//        if(bounds.contains(latLng)) {
//          nearbikeplusoptions.datapush({
//            'id'     : bikeplusoptions.data.stations[i]['id'],
//            'ad'     : bikeplusoptions.data.stations[i]['ad'],
//            'ab'     : bikeplusoptions.data.stations[i]['ab'],
//            'sn'     : bikeplusoptions.data.stations[i]['sn'],
//            'la'     : bikeplusoptions.data.stations[i]['la'],
//            'lo'     : bikeplusoptions.data.stations[i]['lo'],
//            'latLng' : latLng,
//            'dist'   : _distance(bikeplusoptions.data.stations[i].la, bikeplusoptions.data.stations[i].lo, map.getCenter().lat(), map.getCenter().lng())
//          });
//        }
//      }
//      nearbikeplusoptions.datasort(function(a,b) {return (a.dist > b.dist) ? 1 : ((b.dist > a.dist) ? -1 : 0);} );
//      return nearbikeplusoptions.dataslice(0,10);
//    }
//
//    function _distance(lat1,lon1,lat2,lon2) {
//      var R = 3958.7558657440545; // km (change this constant to get miles) 6371
//      var PI = Math.PI / 180;
//      var dLat = (lat2-lat1) * PI;
//      var dLon = (lon2-lon1) * PI;
//      var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
//          Math.cos(lat1 * PI ) * Math.cos(lat2 * PI ) *
//          Math.sin(dLon/2) * Math.sin(dLon/2);
//      var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
//      var d = R * c;
//      return Math.round(d*100)/100;
//    }
//
//    return {
//      activate : activate,
//      hide     : hide
//    }
//  })();


/*Load external resources*/
//function loadMapScript() {
//  var script = d.createElement("script");
//  script.type = "text/javascript";
//  script.src = "https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&callback=BikePlus.mapInit";
//  d.body.appendChild(script);
//}
//w.onload = loadMapScript;


//var Lat = 40.760424;
//var Lng = -73.9887083;
//var center = new google.maps.LatLng(Lat, Lng);


//  google.maps.event.addListenerOnce(map, 'idle', function(){
//    //var bounds = map.getBounds();
//    //DEBUG && console.log(bounds);
//    //var ne = bounds.getNorthEast();
//    //var sw = bounds.getSouthWest();
//    //var nw = new google.maps.LatLng(ne.lat(), sw.lng());
//    //var se = new google.maps.LatLng(sw.lat(), ne.lng());
//  });
//
