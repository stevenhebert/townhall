export class Profile{
	constructor(
		public profileId: number,
		public profileAddress1: string,
		public profileAddress2: string,
		public profileCity: string,
		public profileEmail: string,
		public profileFirstName: string,
		public profileLastName: string,
		public profileState: string,
		public profilePassword: string,
		public profilePasswordConfirm: string,
		public profileZip: string
	){
	}
}