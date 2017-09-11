import {RouterModule, Routes} from "@angular/router";
import {AboutComponent} from "./components/about.component";
import {FooterComponent} from "./components/footer.component";
import {HomeComponent} from "./components/home.component";
import {MainNavComponent} from "./components/mainnav.component";
import {SignUpComponent} from "./components/signup.component";
import {SessionService} from "./services/session.service";
import {PostComponent} from "./components/post.component";
import {ActivationService} from "./services/activation.service";
import {PostService} from "./services/post.service";
import {SignInService} from "./services/signin.service";
import {SignInComponent} from "./components/signin.component";
import {SignUpService} from "./services/signup.service";
import {CookieService} from "ng2-cookies";
// import {VoteService} from "./services/vote.service";
// import {NavbarComponent} from "./components/navbar.component"
// import {ProfileComponent} from "./components/profile.component";
// import {BaseService} from "./services/base.service";
// import {DistrictService} from "./services/district.service";
// import {ProfileService} from "./services/profile.service";
// import {SignOutService} from "./services/signout.service";

// TODO: add components to this array when ready to test
export const allAppComponents = [
	HomeComponent,
	SignUpComponent,
	MainNavComponent,
	PostComponent,
	FooterComponent,
	AboutComponent,
	SignInComponent];

export const routes: Routes = [

	{path: "", component: HomeComponent},
	{path: "about", component: AboutComponent},
	{path: "footer", component: FooterComponent},
	{path: "signin", component: SignInComponent},
	{path: "post", component: PostComponent},
	{path: "signup", component: SignUpComponent},
	// {path: "navbar", component: NavbarComponent},
	// {path: "profile", component: ProfileComponent},

];

// TODO: add services to this array when ready to test
export const appRoutingProviders: any[] = [
	ActivationService,
	PostService,
	SessionService,
	SignInService,
	SignUpService,
	CookieService
];


export const routing = RouterModule.forRoot(routes);
