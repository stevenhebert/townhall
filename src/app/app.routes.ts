import {RouterModule, Routes} from "@angular/router";

import {AboutComponent} from "./components/about.components"
import {FooterComponent} from "./components/footer.components"
import {HomeComponent} from "./components/home.component";
import {NavbarComponent} from "./components/navbar.components"
import {PostComponent} from "./components/post.component";
import {ProfileComponent} from "./components/profile.component";


export const allAppComponents = [HomeComponent];

export const routes: Routes = [
	{path: "", component: HomeComponent},
	{path: "post", component: PostComponent},
	{path: "profile", component: ProfileComponent},

];

export const appRoutingProviders: any[] = [];

export const routing = RouterModule.forRoot(routes);