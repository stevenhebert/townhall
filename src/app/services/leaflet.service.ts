/// <reference path="../../typings/leaflet.vectorgrid.d.ts"/>

import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import * as L from "leaflet";
import {Observable} from "rxjs/Observable";
import {Post} from "../classes/post";
import {BaseService} from "./base.service";

// import * as rewind from 'geojson-rewind';


@Injectable()
export class LeafletService extends BaseService{

	public map: L.Map;
	public baseMaps: any;
	// public geoJSON: any;
	// vtLayer: any;
	abqLayer: any;


	constructor(protected http: Http) {
		super(http);

		this.baseMaps = {
			OpenStreetMap: L.tileLayer("https://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png"),
			Esri: L.tileLayer("https://server.arcgisonline.com/ArcGIS/rest/services/World_Topo_Map/MapServer/tile/{z}/{y}/{x}"),
			CartoDB: L.tileLayer("https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}.png")
		};
	}

	// disableMouseEvent(elementId: string) {
	// 	let element = <HTMLElement>document.getElementById(elementId);
	//
	// 	L.DomEvent.disableClickPropagation(element);
	// 	L.DomEvent.disableScrollPropagation(element);
	// }

	// getGeoJSON() {
	//
	// 	this.http.get('http://data-cabq.opendata.arcgis.com/datasets/679907ead15d415a8e1afbb29c8be988_3.geojson')
	// 		.map(res => res.json())
	// 		.subscribe(result => {
	//
	// 			this.abqLayer = L.geoJSON(result, {
	// 				onEachFeature(feature, layer) {
	// 					layer.bindPopup(feature.properties);
	// 				}
	// 			}).addTo(this.map);
	// 		})
	// }

	getDistrictMap() {
			this.http.get('https://data-cabq.opendata.arcgis.com/datasets/679907ead15d415a8e1afbb29c8be988_3.geojson')
				.map(res => res.json())
				.subscribe(result => {

					this.abqLayer = L.geoJSON(result, {
						onEachFeature(feature, layer) {
							layer.bindPopup(feature.properties);
						}
					}).addTo(this.map);
				})
		}

	// this.vtLayer = L.vectorGrid.slicer(result);
	// this.vtLayer.addTo(this.map);
	// rewind(result, clockwise);
}
