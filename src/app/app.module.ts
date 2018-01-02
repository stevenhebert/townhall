import {NgModule} from "@angular/core";
import {BrowserModule} from "@angular/platform-browser";
import {FormsModule} from "@angular/forms";
import {HttpModule} from "@angular/http";
import {OrderModule} from 'ngx-order-pipe';
import {LeafletModule} from '@asymmetrik/ngx-leaflet';

import {AppComponent} from "./app.component";
import {allAppComponents, appRoutingProviders, routing} from "./app.routes";

import {ActivationService} from "./services/activation.service";
import {CookieService} from "ng2-cookies";
import {EditProfileService} from "./services/editprofile.service"
import {ForgotService} from "./services/forgot.service";
import {SessionService} from "./services/session.service";
import {SignInService} from "./services/signin.service";
import {SignOutService} from "./services/signout.service"
import {SignUpService} from "./services/signup.service";
import {LeafletService} from "./services/leaflet.service";
import {RecoveryService} from "./services/recovery.service";

const moduleDeclarations = [AppComponent];

@NgModule({
	imports:      [BrowserModule, FormsModule, HttpModule, routing, OrderModule, LeafletModule.forRoot()],
	declarations: [...moduleDeclarations, ...allAppComponents],
	bootstrap:    [AppComponent],
	providers: [
		appRoutingProviders,
		ActivationService,
		EditProfileService,
		ForgotService,
		RecoveryService,
		SignInService,
		SignOutService,
		SignUpService,
		LeafletService
	]})
export class AppModule {	cookieJar : any = {};

	constructor(protected cookieService: CookieService, protected sessionService: SessionService) {}

	run() : void {
				this.sessionService.setSession()
					.subscribe(response => {
							this.cookieJar = this.cookieService.getAll();
							console.log(this.cookieJar);
						});
			}
}