var $tests = document.getElementById('tests');

var PIXEL_RATIO = (function () { var ctx = document.createElement("canvas").getContext("2d"), dpr = window.devicePixelRatio || 1, bsr = ctx.webkitBackingStorePixelRatio || ctx.mozBackingStorePixelRatio || ctx.msBackingStorePixelRatio || ctx.oBackingStorePixelRatio || ctx.backingStorePixelRatio || 1; return dpr / bsr; })();


$tests.innerHTML = $tests.innerHTML + '<strong>navigator.userAgent: </strong>' + navigator.userAgent + '<br>';
$tests.innerHTML = $tests.innerHTML + '<strong>navigator.appVersion: </strong>' + navigator.appVersion + '<br>';
$tests.innerHTML = $tests.innerHTML + '<strong>window.screen.height: </strong>' + window.screen.height + '<br>';
$tests.innerHTML = $tests.innerHTML + '<strong>window.devicePixelRatio: </strong>' + window.devicePixelRatio + '<br>';
$tests.innerHTML = $tests.innerHTML + '<strong>PIXEL_RATIO: </strong>' + PIXEL_RATIO + '<br>';