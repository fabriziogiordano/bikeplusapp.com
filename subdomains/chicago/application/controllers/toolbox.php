<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Toolbox extends CI_Controller {
	//Populate the table dockDirections with first content
  public function docktable(){
    $this->Apis->docktable();
  }

  public function gmapdistances(){
    $a = $this->Apis->gmapdistances('40.68098339', '-73.95004798', '40.77152200', '-73.99054100');
    echo '<pre>'.var_dump($a).'</pre>';
  }

  public function json(){



  $json = <<<EOT
  {
"routes" : [
  {
     "bounds" : {
        "northeast" : {
           "lat" : 40.77297930,
           "lng" : -73.94950799999999
        },
        "southwest" : {
           "lat" : 40.68037470,
           "lng" : -74.01320740
        }
     },
     "copyrights" : "Map data ©2013 Google",
     "legs" : [
        {
           "distance" : {
              "text" : "9.6 mi",
              "value" : 15373
           },
           "duration" : {
              "text" : "52 mins",
              "value" : 3147
           },
           "end_address" : "876-898 11th Avenue, New York, NY 10019, USA",
           "end_location" : {
              "lat" : 40.77152220,
              "lng" : -73.99054149999999
           },
           "start_address" : "30 Macon Street, Brooklyn, NY 11216, USA",
           "start_location" : {
              "lat" : 40.68103380,
              "lng" : -73.95005730
           },
           "steps" : [
              {
                 "distance" : {
                    "text" : "95 ft",
                    "value" : 29
                 },
                 "duration" : {
                    "text" : "1 min",
                    "value" : 4
                 },
                 "end_location" : {
                    "lat" : 40.68107000000001,
                    "lng" : -73.9497150
                 },
                 "html_instructions" : "Head \u003cb\u003eeast\u003c/b\u003e on \u003cb\u003eMacon St\u003c/b\u003e toward \u003cb\u003eNostrand Ave\u003c/b\u003e",
                 "polyline" : {
                    "points" : "mohwFzjjbMGcA"
                 },
                 "start_location" : {
                    "lat" : 40.68103380,
                    "lng" : -73.95005730
                 },
                 "travel_mode" : "BICYCLING"
              },
              {
                 "distance" : {
                    "text" : "262 ft",
                    "value" : 80
                 },
                 "duration" : {
                    "text" : "1 min",
                    "value" : 41
                 },
                 "end_location" : {
                    "lat" : 40.68037470,
                    "lng" : -73.94950799999999
                 },
                 "html_instructions" : "Turn \u003cb\u003eright\u003c/b\u003e onto \u003cb\u003eNostrand Ave\u003c/b\u003e",
                 "maneuver" : "turn-right",
                 "polyline" : {
                    "points" : "uohwFvhjbM~AUDAHAFCRK"
                 },
                 "start_location" : {
                    "lat" : 40.68107000000001,
                    "lng" : -73.9497150
                 },
                 "travel_mode" : "BICYCLING"
              },
              {
                 "distance" : {
                    "text" : "0.2 mi",
                    "value" : 327
                 },
                 "duration" : {
                    "text" : "1 min",
                    "value" : 74
                 },
                 "end_location" : {
                    "lat" : 40.6806410,
                    "lng" : -73.95337099999999
                 },
                 "html_instructions" : "Turn \u003cb\u003eright\u003c/b\u003e onto \u003cb\u003eFulton St\u003c/b\u003e",
                 "maneuver" : "turn-right",
                 "polyline" : {
                    "points" : "ikhwFlgjbMUrI_@nL"
                 },
                 "start_location" : {
                    "lat" : 40.68037470,
                    "lng" : -73.94950799999999
                 },
                 "travel_mode" : "BICYCLING"
              },
              {
                 "distance" : {
                    "text" : "0.7 mi",
                    "value" : 1155
                 },
                 "duration" : {
                    "text" : "4 mins",
                    "value" : 240
                 },
                 "end_location" : {
                    "lat" : 40.6909080,
                    "lng" : -73.955410
                 },
                 "html_instructions" : "Turn \u003cb\u003eright\u003c/b\u003e onto \u003cb\u003eBedford Ave\u003c/b\u003e",
                 "maneuver" : "turn-right",
                 "polyline" : {
                    "points" : "_mhwFp_kbMwC\\oCZsC\\oCZqC\\sC\\qCZqC\\qCZsC\\qCZsC\\oC\\sCZ"
                 },
                 "start_location" : {
                    "lat" : 40.6806410,
                    "lng" : -73.95337099999999
                 },
                 "travel_mode" : "BICYCLING"
              },
              {
                 "distance" : {
                    "text" : "1.5 mi",
                    "value" : 2386
                 },
                 "duration" : {
                    "text" : "8 mins",
                    "value" : 502
                 },
                 "end_location" : {
                    "lat" : 40.69002930,
                    "lng" : -73.98353070
                 },
                 "html_instructions" : "Turn \u003cb\u003eleft\u003c/b\u003e onto \u003cb\u003eDekalb Ave\u003c/b\u003e",
                 "maneuver" : "turn-left",
                 "polyline" : {
                    "points" : "emjwFhlkbMT|DTtD\\bGRvDFnAHtAl@fKVnET|DTvDT|DT`EV`E?T?XEzCGlEIhEEdEEfEI`EGbEEfDC^CfEAh@C`CCxBAX?Z?v@Cp@A`@ArAAdA@NIjE?`@IhFGx@AdB"
                 },
                 "start_location" : {
                    "lat" : 40.6909080,
                    "lng" : -73.955410
                 },
                 "travel_mode" : "BICYCLING"
              },
              {
                 "distance" : {
                    "text" : "0.1 mi",
                    "value" : 230
                 },
                 "duration" : {
                    "text" : "1 min",
                    "value" : 45
                 },
                 "end_location" : {
                    "lat" : 40.69209410,
                    "lng" : -73.98340550
                 },
                 "html_instructions" : "Turn \u003cb\u003eright\u003c/b\u003e onto \u003cb\u003eAlbee Square\u003c/b\u003e",
                 "maneuver" : "turn-right",
                 "polyline" : {
                    "points" : "ugjwF`|pbM}@CcCI[Aq@?s@CwAC"
                 },
                 "start_location" : {
                    "lat" : 40.69002930,
                    "lng" : -73.98353070
                 },
                 "travel_mode" : "BICYCLING"
              },
              {
                 "distance" : {
                    "text" : "0.2 mi",
                    "value" : 329
                 },
                 "duration" : {
                    "text" : "1 min",
                    "value" : 55
                 },
                 "end_location" : {
                    "lat" : 40.69224130,
                    "lng" : -73.98729960
                 },
                 "html_instructions" : "Turn \u003cb\u003eleft\u003c/b\u003e onto \u003cb\u003eWilloughby St\u003c/b\u003e",
                 "maneuver" : "turn-left",
                 "polyline" : {
                    "points" : "qtjwFh{pbMExDGxDGhEGjE"
                 },
                 "start_location" : {
                    "lat" : 40.69209410,
                    "lng" : -73.98340550
                 },
                 "travel_mode" : "BICYCLING"
              },
              {
                 "distance" : {
                    "text" : "0.3 mi",
                    "value" : 441
                 },
                 "duration" : {
                    "text" : "2 mins",
                    "value" : 100
                 },
                 "end_location" : {
                    "lat" : 40.69620460,
                    "lng" : -73.98710249999999
                 },
                 "html_instructions" : "Turn \u003cb\u003eright\u003c/b\u003e onto \u003cb\u003eJay St\u003c/b\u003e",
                 "maneuver" : "turn-right",
                 "polyline" : {
                    "points" : "oujwFrsqbMiCEk@Ci@AsACmFIiCEiAEa@A"
                 },
                 "start_location" : {
                    "lat" : 40.69224130,
                    "lng" : -73.98729960
                 },
                 "travel_mode" : "BICYCLING"
              },
              {
                 "distance" : {
                    "text" : "456 ft",
                    "value" : 139
                 },
                 "duration" : {
                    "text" : "2 mins",
                    "value" : 112
                 },
                 "end_location" : {
                    "lat" : 40.69626870,
                    "lng" : -73.9887490
                 },
                 "html_instructions" : "Turn \u003cb\u003eleft\u003c/b\u003e onto \u003cb\u003eTillary St\u003c/b\u003e",
                 "maneuver" : "turn-left",
                 "polyline" : {
                    "points" : "gnkwFjrqbMGvBClD?RAN"
                 },
                 "start_location" : {
                    "lat" : 40.69620460,
                    "lng" : -73.98710249999999
                 },
                 "travel_mode" : "BICYCLING"
              },
              {
                 "distance" : {
                    "text" : "0.2 mi",
                    "value" : 363
                 },
                 "duration" : {
                    "text" : "1 min",
                    "value" : 65
                 },
                 "end_location" : {
                    "lat" : 40.69952380000001,
                    "lng" : -73.98865370
                 },
                 "html_instructions" : "Turn \u003cb\u003eright\u003c/b\u003e onto \u003cb\u003eBrooklyn Bridge Promenade\u003c/b\u003e",
                 "maneuver" : "turn-right",
                 "polyline" : {
                    "points" : "unkwFt|qbMeM[aA?g@Ag@?g@DIB"
                 },
                 "start_location" : {
                    "lat" : 40.69626870,
                    "lng" : -73.9887490
                 },
                 "travel_mode" : "BICYCLING"
              },
              {
                 "distance" : {
                    "text" : "0.8 mi",
                    "value" : 1295
                 },
                 "duration" : {
                    "text" : "4 mins",
                    "value" : 233
                 },
                 "end_location" : {
                    "lat" : 40.70794830,
                    "lng" : -73.99920569999999
                 },
                 "html_instructions" : "Take the pedestrian overpass",
                 "polyline" : {
                    "points" : "_clwF`|qbMOFc@TSNSVe@t@g@~@O\\A??@GLINQXKPIJc@j@UZGFg@n@EFIJOROTY^GJC@EF]f@a@j@a@h@c@l@c@j@?@A@ABA@A@MP}AvB[b@ABA@?@[`@eAvAgAxAcBzBKNKLmDxE{ElGgBbCc@l@c@j@a@h@Y`@"
                 },
                 "start_location" : {
                    "lat" : 40.69952380000001,
                    "lng" : -73.98865370
                 },
                 "travel_mode" : "BICYCLING"
              },
              {
                 "distance" : {
                    "text" : "0.5 mi",
                    "value" : 746
                 },
                 "duration" : {
                    "text" : "3 mins",
                    "value" : 153
                 },
                 "end_location" : {
                    "lat" : 40.71294540,
                    "lng" : -74.00422949999999
                 },
                 "html_instructions" : "Take the pedestrian overpass",
                 "polyline" : {
                    "points" : "uwmwF`~sbMEFMRA@ABA@GHOV?@QXQTQT_@f@ABEDILGFUXsArB{@hAA?QTA@mHlJA@CBeAtAY\\ABMN?@CBA@ILEFKLIJKLONGFKDKBGBO?I?G?EAG?ECACAC@G]YECECSI"
                 },
                 "start_location" : {
                    "lat" : 40.70794830,
                    "lng" : -73.99920569999999
                 },
                 "travel_mode" : "BICYCLING"
              },
              {
                 "distance" : {
                    "text" : "85 ft",
                    "value" : 26
                 },
                 "duration" : {
                    "text" : "1 min",
                    "value" : 3
                 },
                 "end_location" : {
                    "lat" : 40.71313350,
                    "lng" : -74.00404970
                 },
                 "html_instructions" : "Merge onto \u003cb\u003eCentre St\u003c/b\u003e",
                 "maneuver" : "merge",
                 "polyline" : {
                    "points" : "}vnwFl}tbMc@c@"
                 },
                 "start_location" : {
                    "lat" : 40.71294540,
                    "lng" : -74.00422949999999
                 },
                 "travel_mode" : "BICYCLING"
              },
              {
                 "distance" : {
                    "text" : "0.6 mi",
                    "value" : 902
                 },
                 "duration" : {
                    "text" : "4 mins",
                    "value" : 254
                 },
                 "end_location" : {
                    "lat" : 40.71732870,
                    "lng" : -74.01320740
                 },
                 "html_instructions" : "Turn \u003cb\u003eleft\u003c/b\u003e onto \u003cb\u003eChambers St\u003c/b\u003e",
                 "maneuver" : "turn-left",
                 "polyline" : {
                    "points" : "axnwFh|tbMg@tA]|@}AlEo@~AsCdIqBdGGPuC`Ig@tAUp@yA~DM`@Yv@Ob@"
                 },
                 "start_location" : {
                    "lat" : 40.71313350,
                    "lng" : -74.00404970
                 },
                 "travel_mode" : "BICYCLING"
              },
              {
                 "distance" : {
                    "text" : "4.1 mi",
                    "value" : 6598
                 },
                 "duration" : {
                    "text" : "19 mins",
                    "value" : 1169
                 },
                 "end_location" : {
                    "lat" : 40.77297930,
                    "lng" : -73.99374150
                 },
                 "html_instructions" : "Turn \u003cb\u003eright\u003c/b\u003e onto \u003cb\u003eHudson River Greenway\u003c/b\u003e",
                 "maneuver" : "turn-right",
                 "polyline" : {
                    "points" : "irowFpuvbMWGIAoCc@aAOQIOEm@IWEWCUEMCUAUAGAIAoB]o@KOCKCMCMEMCEAuG{@g@E{AQiDc@}AQc@GkCWw@Gk@E{@Gk@Em@GcGa@}DUM?M?Q@O?k@ASAa@CMCKCKCI?MAKAeDOOAcBIg@CuBA_AEw@Ca@G]E[Cc@Co@Ai@E[CC?[?o@Eg@A[A_@@U@w@E[Ac@Cs@Iw@GoGU_@?OAM@q@BuAHg@@OBQ?S?Q?QAQAOCQCMCIAKCOGQGQGMGIEECE?EAE?C?E?CAECGCKGIGIGKIKKKKKIIGKEIEICICMCMAQEMCSEcFo@}AQKAI?GAE@EAE?YE_AIUCk@IC?CACCCAEACAKAwBUGAWEWI_BQeIw@wGo@M@E@EDEFAD?BALGNKLGBEBGBUHQJIDMPC@MDK?EAGAMGKESCQ?QDWFUD[@q@@_@Aq@Ga@IcD}@[I_Cm@cEkAcAWECSE_@Kk@Yg@[YQAAuA_Ac@Uu@g@UOc@Wg@]e@[m@_@OKi@_@_@WYQ[SSMa@Yc@Wi@_@w@i@q@g@MGGCyCsBIESEm@e@e@[q@c@UQWO_@Wa@WECGEGCSGCA_Am@}@m@AAACAACAACACAAACCAAAECq@e@e@_@GIIIY]AAu@eAe@u@SWMSOY[i@KMSa@EIQYQQCCGGCEQMMI{AgACASOUOe@_@u@e@cAq@cAu@SOyFsDeBkAuCkBc@WMGICCAGCuBuAk@a@OICAC?C@A@GBIFC@CACAIGC?GEGCMGQGMEYGUCs@CgAIaAIYEUGEAMEWQECYUUQq@a@o@a@kAu@IGGEGGII"
                 },
                 "start_location" : {
                    "lat" : 40.71732870,
                    "lng" : -74.01320740
                 },
                 "travel_mode" : "BICYCLING"
              },
              {
                 "distance" : {
                    "text" : "0.2 mi",
                    "value" : 314
                 },
                 "duration" : {
                    "text" : "1 min",
                    "value" : 69
                 },
                 "end_location" : {
                    "lat" : 40.77162960,
                    "lng" : -73.99046919999999
                 },
                 "html_instructions" : "Turn \u003cb\u003eright\u003c/b\u003e onto \u003cb\u003eW 59th St\u003c/b\u003e",
                 "maneuver" : "turn-right",
                 "polyline" : {
                    "points" : "cnzwFz{rbMDMDMBK@ANe@J]b@qAzDmM"
                 },
                 "start_location" : {
                    "lat" : 40.77297930,
                    "lng" : -73.99374150
                 },
                 "travel_mode" : "BICYCLING"
              },
              {
                 "distance" : {
                    "text" : "43 ft",
                    "value" : 13
                 },
                 "duration" : {
                    "text" : "1 min",
                    "value" : 28
                 },
                 "end_location" : {
                    "lat" : 40.77152220,
                    "lng" : -73.99054149999999
                 },
                 "html_instructions" : "Turn \u003cb\u003eright\u003c/b\u003e onto \u003cb\u003e11th Ave\u003c/b\u003e",
                 "maneuver" : "turn-right",
                 "polyline" : {
                    "points" : "uezwFlgrbMTL"
                 },
                 "start_location" : {
                    "lat" : 40.77162960,
                    "lng" : -73.99046919999999
                 },
                 "travel_mode" : "BICYCLING"
              }
           ],
           "via_waypoint" : []
        }
     ],
     "overview_polyline" : {
        "points" : "mohwFzjjbMGcA~AUNCZOu@bWkQrBiQtBkQrBcHx@j@rJbA`RpBl]bAvQEtDQvKKlKQdKIfEEpFIpHG~E?tAIlFIhFGx@AdB}@C_DKeBCwACExDObKGjEiCEuAEuOYa@AGvBC`EANeM[iBAg@?g@DYJw@d@SVe@t@w@|AA@c@v@y@hAkAzAsBrCmCrDqCzDsMhQmM~Pk@|@wArBm@t@sArB{@hASTuHtJaBvBy@fA[\\SLSFY?MAMCCG@G]YKGSIc@c@eArCmClHeGjQ}CrIeDhJi@zAa@IoCc@aAOQI}@Oo@IoAMqDm@w@QSE}HaAgKoAcE_@gBMyAMaMw@}@@oBKo@IeH]}CEwBI_AM_AGyBKoCIu@BsAGwAMgI]o@A_AD_DNiACy@M_A[c@QUA]Qk@e@m@c@k@QaAQwIcAYA{C]OGmC[_@GWI_BQ}QgBSBKLAHI\\SPu@\\WVQFQAUI_@Ic@Dm@LmABqAIeEgAcL{CYIkAe@yCoBsCeBkCeBcG}DiBqAUKcDyBSEm@e@wA_Am@a@oAy@[KcAo@cAu@IKMKwAeAQSqAeBy@mA]m@aAcBo@w@_CeBm@a@cFmDiO{Jq@_@MEyDeCGAEBQJG?YOu@Yo@K{BM{AO[Ie@W_@YcEkCc@_@lGmSTL"
     },
     "summary" : "Hudson River Greenway",
     "warnings" : [
        "Bicycling directions are in beta. Use caution – This route may contain streets that aren't suited for bicycling."
     ],
     "waypoint_order" : []
  }
],
"status" : "OK"
}
EOT;
    $json = '{}';
    var_dump(json_decode($json, true));
  }

}
