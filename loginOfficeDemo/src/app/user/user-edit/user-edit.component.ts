import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { FormGroup, FormControl, FormBuilder, Validators, NgForm } from '@angular/forms';
import { ApiService } from '../../api.service';

@Component({
  selector: 'app-user-edit',
  templateUrl: './user-edit.component.html',
  styleUrls: ['./user-edit.component.css']
})
export class UserEditComponent implements OnInit {
  angForm: FormGroup;
  userData = [];
  email = '';
  name = '';
  userId = '';

  constructor(private fb: FormBuilder, private route: ActivatedRoute, private router:Router, private dataService: ApiService) {

    this.angForm = this.fb.group({
      email: ['', [Validators.required, Validators.minLength(1), Validators.email]],
      name: ['', Validators.required],
      userId: ['', Validators.required],
    });
  }

  ngOnInit(): void {
    // get paramiter 
    let id = this.route.snapshot.paramMap.get('id');
    console.log(id);
    // other way to get paramiter name.
    /* this.route.paramMap.subscribe(
      params => {
        let id = +params.get('id');
        console.log("getting paramiters==="+id);
      }
    ); */

    this.dataService.getUserDetail(id).subscribe((res: any[]) => {
      this.userData = res;
      //  this.email = res.email;
      // this.name = res.name;
      this.userId = id;
    });
  }

  postdata(angForm1) {
    // console.log(angForm1);
    console.log("====>"+angForm1.value.userId);
    this.dataService.updateUser(angForm1.value.userId, angForm1.value.name, angForm1.value.email )
     .subscribe(
      data => {
        this.router.navigate(['user']);
      },

      error => {
      });
  }
  /*
    get email() { return this.angForm.get('email'); }
    get name() { return this.angForm.get('name'); } 
  */
}
