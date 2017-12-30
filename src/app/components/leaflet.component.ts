/// <reference path="../../typings/leaflet.vectorgrid.d.ts"/>

import {Component, OnInit} from '@angular/core';
import {LeafletService} from "../services/leaflet.service";
import * as L from "leaflet";


@Component({
	selector: 'leaflet',
	templateUrl: './templates/leaflet.html'
})
export class LeafletComponent implements OnInit {

	constructor(private leafletService: LeafletService) {
	}

	ngOnInit() {
		this.loadDistrictMap();

		let map = L.map("map", {
			center: L.latLng(35.0955795, -106.6914833),
			zoom: 11,
			minZoom: 4,
			maxZoom: 12,
			layers: [this.leafletService.baseMaps.OpenStreetMap]
		});

		L.control.layers(this.leafletService.baseMaps).addTo(map);
		L.control.scale().addTo(map);

		this.leafletService.map = map;
	}

	loadDistrictMap() {
		this.leafletService.getDistrictMap()
	}

}








