import {Component, OnInit} from "@angular/core";
import {UserService} from "../services/user.service";
import {User} from "../classes/user";

@Component({
	templateUrl: "./templates/user.html"
})

export class UserComponent implements OnInit {

	users : User[] = [];

	constructor(protected userService: UserService) {}

	ngOnInit() : void {
		this.getAllUsers();
	}

	getAllUsers() : void {
		this.userService.getAllUsers()
			.subscribe(users => this.users = users);
	}
}