import {Component, OnInit} from "@angular/core";
import {SessionService} from "../services/session.service";

@Component({
	selector: "abq-town-hall",
	templateUrl: "./templates/abq-town-hall.html"
})

export class AppComponent implements OnInit {

	constructor(protected sessionService: SessionService) {}

	ngOnInit() : void {
		this.sessionService.setSession();
	}

}