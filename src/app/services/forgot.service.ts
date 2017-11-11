import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base.service";
import {Status} from "../classes/status";
import {Forgot} from "../classes/forgot";

@Injectable()
export class ForgotService extends BaseService {
	constructor(protected http: Http) {
		super(http);
	}

	private forgotUrl = "api/forgot/";

	createForgot(forgot:Forgot) : Observable<Status> {
		return(this.http.post(this.forgotUrl, forgot)
			.map(this.extractMessage)
			.catch(this.handleError));
	}
}