import { Injectable, Output, EventEmitter } from '@angular/core';
import { map } from 'rxjs/operators';
import { HttpClient } from '@angular/common/http';
import { Users } from './users';

@Injectable({
  providedIn: 'root'
})
export class ApiService {
  redirectUrl: string;
  //baseUrl: string = "http://localhost/angular/target/Q2/api";
  baseUrl: string = "http://localhost/angular/target/Q2/api";
  @Output() getLoggedInName: EventEmitter<any> = new EventEmitter();
  constructor(private httpClient: HttpClient) { }

  public userlogin(username, password) {
    return this.httpClient.post<any>(this.baseUrl + '/login.php', { username, password })
      .pipe(map(Users => {
        this.setToken(Users[0].name);
        this.getLoggedInName.emit(true);
        return Users;
      }));
  }

  public userregistration(name, email, pwd) {
    return this.httpClient.post<any>(this.baseUrl + '/register.php', { name, email, pwd })
      .pipe(map(Users => {
        return Users;
      }));
  }

  public getUser() {
    return this.httpClient.post<any>(this.baseUrl + '/user.php', {})
      .pipe(map(Users => {
        return Users;
      }));
  }

  public getUserDetail(id) {
    return this.httpClient.get<any>(this.baseUrl + '/userdetail.php?id=' + id, {})
      .pipe(map(Users => {
        return Users;
      }));
  }

  public getUserDelete(id) {
    return this.httpClient.get<any>(this.baseUrl + '/userdelete.php?id=' + id, {})
      .pipe(map(Users => {
        return Users;
      }));
  }

  public updateUser(id, name, email) {
    return this.httpClient.post<any>(this.baseUrl + '/updateuser.php', { id, name, email})
      .pipe(map(Users => {
        return Users;
      }));
  }

  //token
  setToken(token: string) {
    localStorage.setItem('token', token);
  }
  getToken() {
    return localStorage.getItem('token');
  }
  deleteToken() {
    localStorage.removeItem('token');
  }
  isLoggedIn() {
    const usertoken = this.getToken();
    if (usertoken != null) {
      return true
    }
    return false;
  }
}
