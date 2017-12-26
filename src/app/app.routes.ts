import {RouterModule, Routes} from "@angular/router";

import {AboutComponent} from "./components/about.component";
import {ActivationComponent} from "./components/activation.component";
import {EditProfileComponent} from "./components/editprofile.component";
import {FooterComponent} from "./components/footer.component";
import {ForgotComponent} from "./components/forgot.component";
import {HomeComponent} from "./components/home.component";
import {LeafletComponent} from "./components/leaflet.component";
import {MainNavComponent} from "./components/mainnav.component";
import {PostComponent} from "./components/post.component";
import {RecoveryComponent} from "./components/recovery.component";
import {ReplyComponent} from "./components/reply.component"
import {SignInComponent} from "./components/signin.component"
import {SignOutComponent} from "./components/signout.component";
import {SignUpComponent} from "./components/signup.component";
import {UserNavComponent} from "./components/usernav.component";

import {SessionService} from "./services/session.service";
import {ActivationService} from "./services/activation.service";
import {SignInService} from "./services/signin.service";
import {SignUpService} from "./services/signup.service";
import {CookieService} from "ng2-cookies";
import {PostService} from "./services/post.service";
import {SignOutService} from "./services/signout.service";
import {EditProfileService} from "./services/editprofile.service";
import {VoteService} from "./services/vote.service";
import {RecoveryService} from "./services/recovery.service";
import {ForgotService} from "./services/forgot.service";
import {LeafletService} from "./services/leaflet.service";


import {APP_BASE_HREF} from "@angular/common";


export const allAppComponents = [
	AboutComponent,
	ActivationComponent,
	EditProfileComponent,
	FooterComponent,
	ForgotComponent,
	HomeComponent,
	LeafletComponent,
	MainNavComponent,
	PostComponent,
	RecoveryComponent,
	ReplyComponent,
	SignInComponent,
	SignOutComponent,
	SignUpComponent,
	UserNavComponent
];


export const routes: Routes = [
	{path:  "", component: HomeComponent},
	{path:  "about", component: AboutComponent},
	{path:  "activation/:activation", component: ActivationComponent},
	{path:  "post/:postDistrictId", component: PostComponent},
	{path:  "recovery/:recovery", component: RecoveryComponent},
	{path:  "reply/:id", component: ReplyComponent},
	{path:  "signout", component: SignOutComponent},
	{path:  "signup", component: SignUpComponent}
];

export const appRoutingProviders: any[] = [
	{provide: APP_BASE_HREF, useValue: window["_base_href"]},
	ActivationService,
	CookieService,
	EditProfileService,
	ForgotService,
	PostService,
	RecoveryService,
	SessionService,
	SignInService,
	SignOutService,
	SignUpService,
	VoteService,
	LeafletService
];

export const routing = RouterModule.forRoot(routes);
