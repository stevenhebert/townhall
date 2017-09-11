import {RouterModule, Routes} from "@angular/router";

import {AboutComponent} from "./components/about.component";
import {FooterComponent} from "./components/footer.component";
import {HomeComponent} from "./components/home.component";
import {MainNavComponent} from "./components/mainnav.component";
import {SignInComponent} from "./components/signin.component"
import {SignUpComponent} from "./components/signup.component";
import {ActivationComponent} from "./components/activation.component";

import {SessionService} from "./services/session.service";
import {ActivationService} from "./services/activation.service";
import {SignInService} from "./services/signin.service";
import {SignUpService} from "./services/signup.service";
import {CookieService} from "ng2-cookies";
import {PostComponent} from "./components/post.component";
import {PostService} from "./services/post.service";

// TODO: add components to this array when ready to test
export const allAppComponents = [
	HomeComponent,
	SignUpComponent,
	MainNavComponent,
	FooterComponent,
	AboutComponent,
	SignInComponent,
	PostComponent,
	ActivationComponent
];


export const routes: Routes = [

	{path: "about", component: AboutComponent},
	{path:  "tempPost", component: PostComponent},
	{path:	"activation/:activation", component: ActivationComponent},
	{path: "", component: HomeComponent}

];

// TODO: add services to this array when ready to test
export const appRoutingProviders: any[] = [
	ActivationService,
	SessionService,
	SignInService,
	SignUpService,
	CookieService,
	PostService
];

export const routing = RouterModule.forRoot(routes);
