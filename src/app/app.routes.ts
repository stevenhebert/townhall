import {RouterModule, Routes} from "@angular/router";
import {AboutComponent} from "./components/about.components"
import {FooterComponent} from "./components/footer.components"
import {HomeComponent} from "./components/home.component";
import {MainNavComponent} from "./components/mainnav.components";
import {SignUpComponent} from "./components/signup.component";
import {SessionService} from "./services/session.service";
import {PostComponent} from "./components/post.component";
import {ActivationService} from "./services/activation.service";
import {PostService} from "./services/post.service";
import {SignInService} from "./services/signin.service";
import {SignInComponent} from "./components/signin.component";
import {SignUpService} from "./services/signup.service";
// import {SignOutService} from "./services/signout.service";
// import {ProfileService} from "./services/profile.service";
// import {BaseService} from "./services/base.service";
// import {DistrictService} from "./services/district.service";
// import {VoteService} from "./services/vote.service";
// import {NavbarComponent} from "./components/navbar.components"
// import {ProfileComponent} from "./components/profile.component";

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

	{path: "about", component: AboutComponent},
	{path: "footer", component: FooterComponent},
	{path: "", component: HomeComponent},
	{path: "post", component: PostComponent},
	{path: "signup", component: SignUpComponent},
	{path: "signin", component: SignInComponent},
	// {path: "navbar", component: NavbarComponent},
	// {path: "profile", component: ProfileComponent},
];

// TODO: add services to this array when ready to test
export const appRoutingProviders: any[] = [
	ActivationService,
	PostService,
	SessionService,
	SignInService,
	SignUpService];

export const routing = RouterModule.forRoot(routes);
