import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "../services/base.service";
import {Status} from "../classes/status";
import {Profile} from "../classes/profile";

@Injectable()
export class SignUpComponent extends BaseService {
	constructor(protected http: Http) {
		super(http);
	}

	private signUpUrl = "api/register/";

	postSignUp(profile:Profile) : Observable<Status> {
		return(this.http.post(this.signUpUrl, profile)
			.map(this.extractMessage)
			.catch(this.handleError));
	}
}