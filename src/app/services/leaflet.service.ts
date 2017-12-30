/// <reference path="../../typings/leaflet.vectorgrid.d.ts"/>

import {BaseService} from "./base.service";
import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import * as L from "leaflet";

@Injectable()
export class LeafletService extends BaseService {

	public map: L.Map;
	public baseMaps: any;
	abqLayer: any;

	constructor(protected http: Http) {
		super(http);

		this.baseMaps = {
			OpenStreetMap: L.tileLayer("https://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png"),
			Esri: L.tileLayer("https://server.arcgisonline.com/ArcGIS/rest/services/World_Topo_Map/MapServer/tile/{z}/{y}/{x}"),
			CartoDB: L.tileLayer("https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}.png")
		};
	}

	getDistrictMap() {
		this.http.get('https://data-cabq.opendata.arcgis.com/datasets/679907ead15d415a8e1afbb29c8be988_3.geojson')
			.map(res => res.json())
			.subscribe(result => {

				this.abqLayer = L.geoJSON(result, {
					onEachFeature: function(feature, layer) {

						let popupHTML = (
							"<img src='" + feature.properties.PICTURE + "'" + "class=popupImage" + "><br/>" +
							"<b><a href='" + feature.properties.WEBPAGE + "'>" + feature.properties.COUNCILORNAME + "</a> - <a href='" + "mailto:" + feature.properties.COUNCILOREMAIL+ "'>@cabq.gov</a><br/></b>" +
							"<br/>" +
							"<b>Contact Analyst: </b>" + feature.properties.POLICYANALYST + "<br/>" +
							"<b>Contact Email: </b>" + "<a href='" + "mailto:" + feature.properties.ANALYSTEMAIL + "'>" + feature.properties.ANALYSTEMAIL + "</a><br/>" +
							"<b>Contact Phone: </b>" + feature.properties.ANALYSTPHONE + "<br/>"
						);

						layer.bindPopup(popupHTML);
					}
				}).addTo(this.map);
			})
	}

}
