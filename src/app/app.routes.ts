import {RouterModule, Routes} from "@angular/router";

import {AboutComponent} from "./components/about.component";
import {FooterComponent} from "./components/footer.component";
import {HomeComponent} from "./components/home.component";
import {MainNavComponent} from "./components/mainnav.component";
import {SignInComponent} from "./components/signin.component"
import {SignUpComponent} from "./components/signup.component";
import {ActivationComponent} from "./components/activation.component";
import {UserNavComponent} from "./components/usernav.component";
import {EditProfileComponent} from "./components/editprofile.component";
import {SignOutComponent} from "./components/signout.component";

import {SessionService} from "./services/session.service";
import {ActivationService} from "./services/activation.service";
import {SignInService} from "./services/signin.service";
import {SignUpService} from "./services/signup.service";
import {CookieService} from "ng2-cookies";
import {PostComponent} from "./components/post.component";
import {PostService} from "./services/post.service";


import {APP_BASE_HREF} from "@angular/common";

import {SignOutService} from "./services/signout.service";
import {EditProfileService} from "./services/editprofile.service";

// TODO: add components to this array when ready to test
export const allAppComponents = [
	HomeComponent,
	SignUpComponent,
	MainNavComponent,
	FooterComponent,
	AboutComponent,
	SignInComponent,
	PostComponent,
	ActivationComponent,
	UserNavComponent,
	EditProfileComponent,
	SignOutComponent
];


export const routes: Routes = [

	{path: "about", component: AboutComponent},
	{path:  "post/:postDistrictId", component: PostComponent},
	{path:	"activation/:activation", component: ActivationComponent},
	{path:	"signout", component: SignOutComponent},
	{path: "", component: HomeComponent}

];

// TODO: add services to this array when ready to test
export const appRoutingProviders: any[] = [
	{provide: APP_BASE_HREF, useValue: window["_base_href"]},
	ActivationService,
	SessionService,
	SignInService,
	SignOutService,
	SignUpService,
	CookieService,
	EditProfileService,
	PostService
];

export const routing = RouterModule.forRoot(routes);
