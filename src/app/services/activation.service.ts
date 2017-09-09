import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base.service";
import {Profile} from "../classes/profile";
import {Status} from "../classes/status";

@Injectable()
export class ActivationService extends BaseService {
    constructor(protected http: Http){
        super(http);
    }

    private activationUrl = "api/activation/";
    /* activate account through emailed link
     * based on session */

    getActivation(activation: string): Observable<Status>{
        return(this.http.get(this.activationUrl+"?profileActivation="+activation)
            .map(this.extractData)
            .catch(this.handleError));
    }
}