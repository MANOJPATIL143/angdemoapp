import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { ApiService } from '../../api.service';

@Component({
  selector: 'app-user-delete',
   templateUrl: './user-delete.component.html',
  styleUrls: ['./user-delete.component.css']
})
export class UserDeleteComponent implements OnInit {

  constructor( private route: ActivatedRoute,private router:Router, private dataService: ApiService) { }

  ngOnInit(): void {
    // get paramiter 
    let id = this.route.snapshot.paramMap.get('id');
    // console.log(id);

    this.dataService.getUserDelete(id).subscribe((res: any[]) => {
      // this.userData = res;
      // this.email = this.userData.email;
      // console.log(this.userData);
      // this.ItemsArray= res;
      this.router.navigate(['user']);
    });
  }

}
