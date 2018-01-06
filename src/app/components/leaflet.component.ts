/// <reference path="../../typings/leaflet.vectorgrid.d.ts"/>

import {Component, OnInit} from '@angular/core';
import {LeafletService} from "../services/leaflet.service";
import * as L from "leaflet";


@Component({
	selector: 'leaflet',
	templateUrl: './templates/leaflet.html'
})


export class LeafletComponent implements OnInit {

	public result: any;

	constructor(private leafletService: LeafletService) {
	}

	ngOnInit() {

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


	OnEachFeature = function(feature: any, layer: any) {

		let popupHTML = (
			"<img src='" + feature.properties.PICTURE + "'" + "class=popupImage" + "><br/>" +
			"<b><a href='" + feature.properties.WEBPAGE + "'>" + feature.properties.COUNCILORNAME + "</a> - <a href='" + "mailto:" + feature.properties.COUNCILOREMAIL + "'>@cabq.gov</a><br/></b>" +
			"<br/>" +
			"<b>Contact Analyst: </b>" + feature.properties.POLICYANALYST + "<br/>" +
			"<b>Contact Email: </b>" + "<a href='" + "mailto:" + feature.properties.ANALYSTEMAIL + "'>" + feature.properties.ANALYSTEMAIL + "</a><br/>" +
			"<b>Contact Phone: </b>" + feature.properties.ANALYSTPHONE + "<br/>"
		);
		layer.bindPopup(popupHTML);
		// layer.on({mouseover: this.highlightFeature, mouseout: this.resetHighlight, click: this.zoomToFeature});
	};

	highlightFeature(e: any) {
		let layer = e.target;

		layer.setStyle({
			weight: 5,
			color: '#666',
			dashArray: '',
			fillOpacity: 0.7
		});

		if(!L.Browser.ie && !L.Browser.opera12 && !L.Browser.edge) {
			layer.bringToFront()
		}
	};

	resetHighlight(e: any) {
		L.geoJSON().resetStyle(e.target);
	};

	zoomToFeature(e: any) {
		this.leafletService.map.fitBounds(e.target.getBounds())
	};

	Style(feature: any) {
		return {
			weight: 2,
			opacity: 1,
			color: 'white',
			dashArray: '3',
			fillOpacity: 0.75,
			fillColor: '#F7C744'
		}
	}


}