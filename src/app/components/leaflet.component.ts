/// <reference path="../../typings/leaflet.vectorgrid.d.ts"/>

import 'leaflet';
import 'leaflet.vectorgrid';
import {Component, OnInit} from '@angular/core';
import {Http} from '@angular/http';
import {LeafletService} from "../services/leaflet.service";
import * as L from "leaflet";


@Component({
	selector: 'leaflet',
	templateUrl: './templates/leaflet.html'
})
export class LeafletComponent implements OnInit {

	data: any;
	abqLayerAdded: boolean;
	// loading: boolean;
	// vtLayer: any;

	constructor(private http: Http, private leafletService: LeafletService) {
	}

	ngOnInit() {
		let map = L.map("map", {
			zoomControl: false,
			center: L.latLng(35.0955795,-106.6914833),
			zoom: 12,
			minZoom: 4,
			maxZoom: 19,
			layers: [this.leafletService.baseMaps.OpenStreetMap]
		});

		L.control.zoom({position: "topright"}).addTo(map);
		L.control.layers(this.leafletService.baseMaps).addTo(map);
		L.control.scale().addTo(map);

		this.leafletService.map = map;
		this.leafletService.disableMouseEvent("toggle-layer");
	}

	getGeoJSON() {
		this.abqLayerAdded = !this.abqLayerAdded;
		this.leafletService.getGeoJSON();
	}


}
	// makeRequest(): void {
	// 	this.loading = true;
	// 	this.http.request('http://data-cabq.opendata.arcgis.com/datasets/679907ead15d415a8e1afbb29c8be988_3.geojson')
	// 		.subscribe((res: Response) => {
	// 			this.data = res.json();
	// 			// console.log(this.data)
	// 			this.loading = false;
	// 		});
	// }








