import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {BaseService} from "./base.service";
import * as L from "leaflet";


@Injectable()
export class LeafletService extends BaseService {

	 esri = require('esri-leaflet');

	public map: L.Map;
	public baseMaps: any;
	public abqLayer: any;

	constructor(protected http: Http) {
		super(http);

		this.baseMaps = {
			OpenStreetMap: L.tileLayer("http://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png", {}),
			Esri: L.tileLayer("http://server.arcgisonline.com/ArcGIS/rest/services/World_Topo_Map/MapServer/tile/{z}/{y}/{x}", {}),
			CartoDB: L.tileLayer("http://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}.png", {}),
		};

		this.abqLayer = this.esri.dynamicMapLayer({
			url: "http://coagisweb.cabq.gov/arcgis/rest/services/public/adminboundaries/MapServer",
			layers: "id:3",
			opacity: 0.75,
			useCors: false
		})

	}

}



