import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class DataService {

  constructor(private http: HttpClient) { }

  getUsers(){
    return this.http.get('http://localhost:8080/api/auth/users');
  }

  deleteUser(id){
    return this.http.delete('http://localhost:8080/api/auth/user/'+id);
  }

  resetPassword(id, password){
    return this.http.post('http://localhost:8080/api/auth/user/'+id+'/password', {password: password});
  }

  updateDetails(id, name, address){
    return this.http.put('http://localhost:8080/api/auth/user/'+id, {name: name, address: address});
  }
}