/// <reference path="../../typings/leaflet.vectorgrid.d.ts"/>

import {Component, OnInit} from '@angular/core';
import {LeafletService} from "../services/leaflet.service";
import {CookieService} from "ng2-cookies";
import * as L from "leaflet";


@Component({
	selector: 'leaflet',
	templateUrl: './templates/leaflet.html'
})


export class LeafletComponent implements OnInit {

	public result: any;
	districtId: number = null;
	cookieJar: any = {};

	constructor(private leafletService: LeafletService, private cookieService: CookieService) {
	}

	ngOnInit() {
		this.cookieJar = this.cookieService.getAll();
		this.districtId = this.cookieJar['profileDistrictId'];

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
		this.createDistrictMap()
	}

	createDistrictMap() {
		this.leafletService.getDistrictMap()
			.subscribe(result => {
				this.result = L.geoJSON(result,
					{
						onEachFeature: this.OnEachFeature,
						style: this.Style

					})
					.addTo(this.leafletService.map);
			});
	}


	OnEachFeature(feature: any, layer: any) {

		let popupHTML = (
			"<img src='" + feature.properties.PICTURE + "'" + "class=popupImage" + "><br/>" +
			"<b><a href='" + feature.properties.WEBPAGE + "'>" + feature.properties.COUNCILORNAME + "</a> - <a href='" + "mailto:" + feature.properties.COUNCILOREMAIL + "'>@cabq.gov</a><br/></b>" +
			"<br/>" +
			"<b>Contact Analyst: </b>" + feature.properties.POLICYANALYST + "<br/>" +
			"<b>Contact Email: </b>" + "<a href='" + "mailto:" + feature.properties.ANALYSTEMAIL + "'>" + feature.properties.ANALYSTEMAIL + "</a><br/>" +
			"<b>Contact Phone: </b>" + feature.properties.ANALYSTPHONE + "<br/>");

		layer.bindPopup(popupHTML);
	};


	Style(feature: any) {
		if(feature.properties.DISTRICTNUMBER == 2) {
			return {
				weight: 2,
				color: '#333',
				dashArray: '',
				fillOpacity: 0.75,
				fillColor: '#008B8B'
			}
		}
		else {
			return {
				weight: 2,
				opacity: 1,
				color: '#333',
				dashArray: '3',
				fillOpacity: 0.75,
				fillColor: '#F7C744'
			}
		}
	};

}
