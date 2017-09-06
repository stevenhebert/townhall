import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base.service";
import {Distric} from "../classes/district";

@Injectable()
export class DistrictService extends BaseService {
	constructor(protected http: Http) {
		super(http);
	}

	private postUrl = "api/post/";

	getAllDistricts() : Observable<District[]> {
		return(this.http.get(this.postUrl)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getPostByDistrictId(districtId : number) : Observable<District> {
		return(this.http.get(this.postUrl + districtId)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getPostByLatLong(Lat Long : number) : Observable<District> {
		return(this.http.get(this.postUrl + districtId)
			.map(this.extractData)
			.catch(this.handleError));
	}
}