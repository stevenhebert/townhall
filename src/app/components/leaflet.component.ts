import {PostService} from "../services/post.service";
import {Component} from '@angular/core';
import {latLng, LatLng, tileLayer} from 'leaflet';

@Component({
	selector: "leaflet",
	templateUrl: "./templates/leaflet.html"
})

export class LeafletComponent {

	options = {
		layers: [
			tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 25, attribution: '...' })

		],
		zoom: 12,
		center: latLng(35.1275061,-106.6257152)
	};


}