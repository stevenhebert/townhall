import {Component, OnInit} from '@angular/core';
import * as esri from 'esri-leaflet';
import * as L from 'leaflet';

declare let $: any;

@Component({
	selector: "leaflet",
	templateUrl: "./templates/leaflet.html"
})

export class LeafletComponent implements OnInit {

	constructor() {
	}

	ngOnInit() {

		let map = L.map('map');
		L.esri.basemapLayer('Topographic').addTo(map);

		L.esri.get('http://data-cabq.opendata.arcgis.com/datasets/679907ead15d415a8e1afbb29c8be988_3.geojson', {}, function(error, response) {
			let features = response.operationalLayers[0].featureCollection.layers[0].featureSet.features;
			let idField = response.operationalLayers[0].featureCollection.layers[0].layerDefinition.objectIdField;

			// empty geojson feature collection
			let featureCollection = {
				type: 'FeatureCollection',
				features: []
			};

			for(let i = features.length - 1; i >= 0; i--) {
				// convert ArcGIS Feature to GeoJSON Feature
				let feature = L.esri.Util.arcgisToGeoJSON(features[i], idField);

				// unproject the web mercator coordinates to lat/lng
				let latlng = L.Projection.Mercator.unproject(L.point(feature.geometry.coordinates));
				feature.geometry.coordinates = [latlng.lng, latlng.lat];

				featureCollection.features.push(feature);
			}

			let geojson = L.geoJSON(featureCollection).addTo(map);
			map.fitBounds(geojson.getBounds());
		});

	}
}