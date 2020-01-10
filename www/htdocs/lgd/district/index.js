import "ol/ol.css";
import Map from "ol/map";
import View from "ol/view";
import TileLayer from "ol/layer/tile";
import XYZ from "ol/source/xyz";
import proj from "ol/proj";

new Map({
  target: "map",
  layers: [
    new TileLayer({
      source: new XYZ({
        url: "http://{a-d}.tile.stamen.com/terrain/{z}/{x}/{y}.png"
      })
    })
  ],
  view: new View({
    center: proj.fromLonLat([-110, 45.6]),
    zoom: 5
  })
});