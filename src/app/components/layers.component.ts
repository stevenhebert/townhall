import { Layer } from 'leaflet';

export class LeafletLayers {

	constructor(
		public baseLayers: {
			id: string,
			name: string,
			enabled: boolean,
			layer: Layer
		}[],
		public baseLayer: string,
		public overlayLayers: {
			id: string,
			name: string,
			enabled: boolean,
			layer: Layer
		}[] = []
	) { }

}
