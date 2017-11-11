import {RouterModule, Routes} from "@angular/router";

import {AboutComponent} from "./components/about.component";
import {ReplyComponent} from "./components/reply.component"
import {FooterComponent} from "./components/footer.component";
import {HomeComponent} from "./components/home.component";
import {MainNavComponent} from "./components/mainnav.component";
import {SignInComponent} from "./components/signin.component"
import {SignUpComponent} from "./components/signup.component";
import {ActivationComponent} from "./components/activation.component";
import {UserNavComponent} from "./components/usernav.component";
import {EditProfileComponent} from "./components/editprofile.component";
import {SignOutComponent} from "./components/signout.component";
import {PostComponent} from "./components/post.component";
import {RecoveryComponent} from "./components/recovery.component";
import {ForgotComponent} from "./components/forgot.component";

import {SessionService} from "./services/session.service";
import {ActivationService} from "./services/activation.service";
import {SignInService} from "./services/signin.service";
import {SignUpService} from "./services/signup.service";
import {CookieService} from "ng2-cookies";
import {PostService} from "./services/post.service";
import {SignOutService} from "./services/signout.service";
import {EditProfileService} from "./services/editprofile.service";
import {ProfileService} from "./services/profile.service";
import {VoteService} from "./services/vote.service";
import {RecoveryService} from "./services/recovery.service";
import {ForgotService} from "./services/forgot.service";

import {APP_BASE_HREF} from "@angular/common";


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
	SignOutComponent,
	RecoveryComponent,
	ReplyComponent,
	ForgotComponent
];


export const routes: Routes = [
	{path:  "about", component: AboutComponent},
	{path:  "post/:postDistrictId", component: PostComponent},
	{path:  "reply/:id", component: ReplyComponent},
	{path:  "activation/:activation", component: ActivationComponent},
	{path:  "recovery/:recovery", component: RecoveryComponent},
	{path:  "signout", component: SignOutComponent},
	{path:  "", component: HomeComponent}
];

export const appRoutingProviders: any[] = [
	{provide: APP_BASE_HREF, useValue: window["_base_href"]},
	ActivationService,
	SessionService,
	SignInService,
	SignOutService,
	SignUpService,
	CookieService,
	EditProfileService,
	PostService,
	ProfileService,
	RecoveryService,
	VoteService,
	ForgotService
];

export const routing = RouterModule.forRoot(routes);
