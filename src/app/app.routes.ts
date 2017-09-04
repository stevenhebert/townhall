import {RouterModule, Routes} from "@angular/router";

import {AboutComponent} from "./components/about.components"
import {FooterComponent} from "./components/footer.components"
import {HomeComponent} from "./components/home.component";
import {NavbarComponent} from "./components/navbar.components"
import {PostComponent} from "./components/post.component";
import {ProfileComponent} from "./components/profile.component";
import {SignUpComponent} from "./components/signup.component";



export const allAppComponents = [HomeComponent];

export const routes: Routes = [

	{path: "about", component: AboutComponent},
	{path: "footer", component: FooterComponent},
	{path: "", component: HomeComponent},
	{path: "navbar", component: NavbarComponent},
	{path: "post", component: PostComponent},
	{path: "profile", component: ProfileComponent},
	{path: "signup", component: SignUpComponent},

];

export const appRoutingProviders: any[] = [];

export const routing = RouterModule.forRoot(routes);