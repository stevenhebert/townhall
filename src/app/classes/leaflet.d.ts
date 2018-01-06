//courtesy of json2ts
declare module Gson {

	export interface Properties {
		OBJECTID: number;
		DISTRICTNUMBER: number;
		COUNCILORNAME: string;
		WEBPAGE: string;
		PICTURE: string;
		created_user: string;
		created_date?: Date;
		last_edited_user: string;
		last_edited_date: Date;
		COUNCILOREMAIL: string;
		POLICYANALYST: string;
		ANALYSTEMAIL: string;
		ANALYSTPHONE: string;
	}

	export interface Geometry {
		type: string;
		coordinates: number[][][];
	}

	export interface Feature {
		type: string;
		properties: Properties;
		geometry: Geometry;
	}

	export interface RootObject {
		type: string;
		features: Feature[];
	}
}