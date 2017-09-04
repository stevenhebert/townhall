import {NgModule} from "@angular/core";
import {BrowserModule} from "@angular/platform-browser";
import {FormsModule} from "@angular/forms";
import {HttpModule} from "@angular/http";
import {AppComponent} from "./app.component";
import {allAppComponents, appRoutingProviders, routing} from "./app.routes";

import {ActivationService} from "./services/activation.service";
import {baseService} from "./services/base.service";
import {postService} from "./services/post.service";
import {profileService} from "./services/profile.service";
import {registerService} from "./services/register.service";
import {sessionService} from "./services/session.service";
import {signinService} from "./services/signin.service";
import {signoutService} from "./services/signout.service";


const moduleDeclarations = [AppComponent];

@NgModule({
	imports:      [BrowserModule, FormsModule, HttpModule, routing],
	declarations: [...moduleDeclarations, ...allAppComponents],
	bootstrap:    [AppComponent],
	providers: [appRoutingProviders, ActivationService, postService, profileService, registerService, sessionService, signinService, signoutService, signoutService]})
export class AppModule {}