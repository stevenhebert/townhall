import {NgModule} from "@angular/core";
import {BrowserModule} from "@angular/platform-browser";
import {FormsModule} from "@angular/forms";
import {HttpModule} from "@angular/http";
import {AppComponent} from "./app.component";
import {allAppComponents, appRoutingProviders, routing} from "./app.routes";
import {AboutComponent} from "./components/about.components";
// import {PostService} from "./services/post.service";
// import {ProfileService}from "./services/profile.service";
// import {SignInService} from "./services/signin.service";
// import {SignOutService} from "./services/signout.service";
import {SignUpService} from "./services/signup.service";


const moduleDeclarations = [AppComponent];

@NgModule({
	imports:      [BrowserModule, FormsModule, HttpModule, routing],
	declarations: [...moduleDeclarations, ...allAppComponents],
	bootstrap:    [AppComponent],
	providers: [appRoutingProviders, SignUpService]})
export class AppModule {}