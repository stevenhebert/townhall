/// <reference path="../../typings/leaflet.vectorgrid.d.ts"/>

import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import * as L from "leaflet";

import * as rewind from 'geojson-rewind';


	@Injectable()
export class LeafletService {

	public map: L.Map;
	public baseMaps: any;
	vtLayer: any;


	constructor(private http: Http) {
		this.baseMaps = {
			OpenStreetMap: L.tileLayer("http://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png"),
			Esri: L.tileLayer("http://server.arcgisonline.com/ArcGIS/rest/services/World_Topo_Map/MapServer/tile/{z}/{y}/{x}"),
			CartoDB: L.tileLayer("http://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}.png")
		};
	}

	disableMouseEvent(elementId: string) {
		let element = <HTMLElement>document.getElementById(elementId);

		L.DomEvent.disableClickPropagation(element);
		L.DomEvent.disableScrollPropagation(element);
	}

	getGeoJSON() {
		this.http.get('http://data-cabq.opendata.arcgis.com/datasets/679907ead15d415a8e1afbb29c8be988_3.geojson')
			.subscribe(result => {
				rewind(result, clockwise);
				this.vtLayer = L.vectorGrid.slicer(result);
				this.vtLayer = L.vectorGrid.slicer(result);
				this.vtLayer.addTo(this.map);
			});
	}

}