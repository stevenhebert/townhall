/// <reference path="../../typings/leaflet.vectorgrid.d.ts"/>

import {Injectable} from "@angular/core";
import * as L from "leaflet";
import {Http} from "@angular/http";

@Injectable()
export class LeafletService {

	public map: L.Map;
	public baseMaps: any;

	constructor(private http: Http) {

		this.baseMaps = {
			OpenStreetMap: L.tileLayer("https://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png"),
			Esri: L.tileLayer("https://server.arcgisonline.com/ArcGIS/rest/services/World_Topo_Map/MapServer/tile/{z}/{y}/{x}"),
			CartoDB: L.tileLayer("https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}.png")
		};
	}

	getDistrictMap() {
		return this.http.get("https://data-cabq.opendata.arcgis.com/datasets/679907ead15d415a8e1afbb29c8be988_3.geojson")
			.map(res => res.json());
	}

}
