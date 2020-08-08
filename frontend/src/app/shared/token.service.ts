import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})

export class TokenService {

  private issuer = {
    login: 'http://localhost:8080/api/login',
    register: 'http://localhost:8080/api/register'
  }

  constructor() { }

  handleData(token){
    localStorage.setItem('access_token', token);
    //localStorage.setItem('user_role', role);
  }

  getToken(){
    return localStorage.getItem('access_token');
  }

  // Verify the token
  isValidToken(){
     const token = this.getToken();

     if(token){
       const payload = this.payload(token);
       if(payload){
         return Object.values(this.issuer).indexOf(payload.iss) > -1 ? true : false;
       }
     } else {
        return false;
     }
  }

  payload(token) {
    const jwtPayload = token.split('.')[1];
    return JSON.parse(atob(jwtPayload));
  }

  // User state based on valid token
  isLoggedIn() {
    return this.isValidToken();
  }

  // Remove token
  removeToken(){
    localStorage.removeItem('access_token');
    //localStorage.removeItem('user_role');
  }

}
