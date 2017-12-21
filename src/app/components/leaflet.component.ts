import {Component, OnInit} from '@angular/core';
import {LeafletService} from "../services/leaflet.service";
import * as L from "leaflet";


@Component({
	selector: "leaflet",
	templateUrl: "./templates/leaflet.html",
	providers: []
})

export class LeafletComponent implements OnInit {

	abqLayer: boolean;
	public baseMaps: any;

	constructor(private leafletService: LeafletService) {
	}

	ngOnInit() {
		let map = L.map("map", {
			center: L.latLng(35.0847321, -106.6467757),
			zoom: 12,
			minZoom: 4,
			maxZoom: 19,
			layers: [this.leafletService.baseMaps.OpenStreetMap]
		});

		L.control.layers(this.leafletService.baseMaps).addTo(map);

		this.leafletService.map = map;
	}

}