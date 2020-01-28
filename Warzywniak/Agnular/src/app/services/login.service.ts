import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Item } from '../model/item';
import { BehaviorSubject } from 'rxjs';
import { User } from '../model/user';

@Injectable({
  providedIn: 'root'
})
export class LoginService {

  private loginStatus: string;
  private idUser: number;
  private loginStatusObs = new BehaviorSubject<string>('');

  constructor(private http: HttpClient) {
    this.loginStatus = 'REJECTED';
  }

  login(email:string, password:string) {
     const data = {
       "password" : password,
       "email" : email
     };
    this.http.post('http://localhost/Warzywniak/api/api/user/login.php',data, { responseType: 'json' }
    ).subscribe(
      (data: Response) => {
        console.log('Got some data from backend: ', data);
        this.loginStatus=data['answer'];
        this.idUser=data['id_user'];
        if(this.idUser==1)this.loginStatus="ADMIN";
      }, (error) => {
        console.log('Errorr!', error);
      },
      () =>{ this.loginStatusObs.next(this.loginStatus); }
    );
  }

  refresh(){
    this.loginStatusObs.next(this.loginStatus);
  } 
  logut(){
    this.loginStatus="REJECTED";
    this.loginStatusObs.next(this.loginStatus);
  }

  getIdUser(){
    return this.idUser;
  }

  getLoginStatus(){
    return this.loginStatusObs.asObservable();
  }

  deleteAccount(id?:number){
    let iduser;
    if(id===undefined) iduser = this.getIdUser() 
    else  iduser=id;
    if(iduser==1){
      alert('Nie mozesz usunac konta administratora!');
      return;}
    console.log(iduser);
    const data = {
      "iduser" : iduser
    };
   this.http.post('http://localhost/Warzywniak/api/api/user/delete.php',data, { responseType: 'json' }
   ).subscribe(
     (data: Response) => {
       console.log('Got some data from backend: ', data);
     }, (error) => {
       console.log('Errorr!', error);
     },
     () =>{ this.loginStatus="REJECTED"}
   );
  }

  singup(email:string,name: string,phone:number,password:string) {

    const data = {
      'name'     : name,
      'email'    : email,
      'phone'    : phone,
      'password' : password
    }

    this.http.post('http://localhost/Warzywniak/api/api/user/create.php', data, { responseType: 'json' }
    ).subscribe(
      (data: Response) => {
        console.log('Got some data from backend: ', data);
        data['answer'];
      }, (error) => {
        console.log('Errorr!', error);
      },
      () => { this.login(email,password)}
    );
  }
}
