// import {Component, OnInit} from "@angular/core";
// import {ActivatedRoute, Params} from "@angular/router";
// import {Status} from "../classes/status";
// import {ActivationService} from "../services/activation.service";
//
// @Component({
// 	templateUrl: "./templates/home-template.php",
// 	selector: "activation"
// })
//
// export class ActivationComponent implements OnInit{
// 	status: Status = null;
//
// 	constructor(private activationService: ActivationService, private route: ActivatedRoute){}
//
// 	ngOnInit(): void {
// 		this.route.params
// 			.switchMap((params: Params) => this.activationService.(params['activation']))
// 			.subscribe(status => {
// 				this.status = status;
// 				if(status.status === 200) {
//                     alert(" WELCOME! Thank you for activating your account, you will be auto-redirected to your profile shortly.")
// 				}
// 			});
//
// 	}
// }