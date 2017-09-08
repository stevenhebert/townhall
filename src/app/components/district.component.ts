import {Component, OnInit} from "@angular/core";
import {ActivatedRoute, Params} from "@angular/router";
import {Observable} from "rxjs";
import {DistrictService} from "../services/district.service";
import {District} from "../classes/district";
import {Status} from "../classes/status";

@Component({
	templateUrl: "./templates/district.php"
})

export class DistrictComponent implements OnInit {

	constructor(protected postService: PostService) {};
