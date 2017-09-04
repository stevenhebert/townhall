import {RouterModule, Routes} from "@angular/router";
import {HomeComponent} from "./components/home.component";
import {PostsComponent} from "./components/posts.component"

export const allAppComponents = [HomeComponent];

export const routes: Routes = [
	{path: "abq-town-hall", component: HomeComponent}
];

export const appRoutingProviders: any[] = [];

export const routing = RouterModule.forRoot(routes);