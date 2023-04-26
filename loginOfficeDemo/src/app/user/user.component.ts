import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { ApiService } from '../api.service';

@Component({
  selector: 'app-user',
  templateUrl: './user.component.html',
  styleUrls: ['./user.component.css']
})
export class UserComponent implements OnInit {

  ItemsArray= [];

  constructor(private dataService: ApiService) { }

  ngOnInit(): void {
    this.dataService.getUser().subscribe((res: any[])=>{
      this.ItemsArray= res;
    });
  }

}
