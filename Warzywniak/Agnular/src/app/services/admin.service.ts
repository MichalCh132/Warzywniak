import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { User } from '../model/user';
import { BehaviorSubject } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class AdminService {

  users: Array<User> = [];
  usersObs = new BehaviorSubject<Array<User>>([]);
  constructor(private http: HttpClient) { }

  getUsers(){
    this.http.get('http://localhost/Warzywniak/api/api/user/read.php', { responseType: 'json' }
    ).subscribe(
      (data: Response) => {
        console.log('Got some data from backend: ', data);
        this.users=data['records'];
        this.usersObs.next(this.users);
      }, (error) => {
        console.log('Errorr!', error);
      },
      () =>{}
    );
  }
  getUsersObs(){
    return this.usersObs.asObservable();
  }
  updateProduct(id_item,name,available,describe,price){
    const data = {
      'id_item': id_item,
      'name':name,
      'available':available,
      'price':price,
      'describe':describe
    }
    console.log(data);
    this.http.patch('http://localhost/Warzywniak/api/api/item/update.php',data,{ responseType: 'json' }
    ).subscribe(
      (data: Response) => {
        console.log('Got some data from backend: ', data);
      }, (error) => {
        console.log('Errorr!', error);
      },
      () =>{}
    );
    
  }
  addProduct(name,available,describe,price){
    const data = {
      'name':name,
      'available':available,
      'price':price,
      'describe':describe
    }
    this.http.post('http://localhost/Warzywniak/api/api/item/create.php',data,{ responseType: 'json' }
    ).subscribe(
      (data: Response) => {
        console.log('Got some data from backend: ', data);
      }, (error) => {
        console.log('Errorr!', error);
      },
      () =>{}
    );
    
  }
  deleteProduct(id){
    const data = {
      'id_item' : id
    }
    this.http.post('http://localhost/Warzywniak/api/api/item/delete.php',data,{ responseType: 'json' }
    ).subscribe(
      (data: Response) => {
        console.log('Got some data from backend: ', data);
      }, (error) => {
        console.log('Errorr!', error);
      },
      () =>{}
    );
    
  }
}
